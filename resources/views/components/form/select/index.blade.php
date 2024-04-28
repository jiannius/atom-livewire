@php
    $icon = $attributes->get('icon');
    $multiple = $attributes->get('multiple', false);
    $callback = $attributes->get('callback');
    $params = $attributes->get('params');
    $searchable = $attributes->get('searchable', true);
    $clearable = $attributes->get('clearable', true);
    $wiremodel = $attributes->wire('model');
    $placeholder = tr($attributes->get('placeholder', 'app.label.select-option'));

    $options = collect($attributes->get('options'))->map(fn($opt) => is_string($opt) ? [
        'value' => $opt, 'label' => $opt,
    ] : $opt)->toArray();

    $except = ['options', 'icon', 'multiple', 'callback', 'params', 'searchable', 'placeholder'];
@endphp

<x-form.field {{ $attributes }}>
    <div
        wire:ignore
        x-cloak
        x-data="{
            value: @entangle($wiremodel),
            options: @js($options),
            multiple: @js($multiple),
            searchable: @js($searchable),
            clearable: @js($clearable),
            callback: @js($callback),
            params: @js($params),
            endpoint: @js(route('__select')),
            focus: false,
            loading: false,
            dropdown: false,
            search: null,
            pointer: null,

            get selection () {
                return this.multiple
                    ? this.options.filter(opt => (this.value.includes(opt.value)))
                    : this.options.find(opt => (opt.value === this.value))
            },

            get isSearchable () {
                return this.searchable && (
                    this.loading
                    || (!this.loading && (this.options.length || !empty(this.search)))
                )
            },

            get isEmpty () {
                return this.multiple
                    ? (!this.value || !this.value.length)
                    : (this.value === null || this.value === undefined)
            },

            get filtered () {
                return this.options.filter(opt => (!opt.hidden))
            },

            init () {
                this.$nextTick(() => {
                    if (this.value === undefined && this.multiple) this.value = []
                    if (!this.isEmpty) this.filter()
                })

                this.$watch('search', (search) => this.filter(search))
            },

            open () {
                this.dropdown = true
                this.$nextTick(() => {
                    this.$refs.search?.focus()
                    this.$refs.dropdown.style.minWidth = this.$root.offsetWidth+'px'
                    if (!this.options.length && this.callback) this.filter()
                })
            },

            close () {
                this.search = null
                this.focus = false
                this.dropdown = false
            },

            select (index) {
                const opt = this.filtered[index]

                if (this.multiple) {
                    const index = this.value.indexOf(opt.value)
                    if (index === -1) this.value.push(opt.value)
                    else this.value.splice(index, 1)
                }
                else if (this.value === opt.value) this.value = null
                else this.value = opt.value

                this.$dispatch('input', this.value)

                if (!this.multiple) this.close()
            },

            remove (opt = null) {
                if (opt === null) {
                    if (this.multiple) this.value = []
                    else this.value = null
                }
                else {
                    const index = this.value.indexOf(opt.value)
                    this.value.splice(index, 1)
                }

                this.$dispatch('input', this.value)
            },

            fetch (callback, params) {
                this.loading = true

                ajax(this.endpoint)
                .post({ callback, params, value: this.value })
                .then(res => this.options = res)
                .finally(() => {
                    this.loading = false
                    this.$refs.search?.focus()
                })
            },

            filter (search) {
                if (this.callback) {
                    this.fetch(this.callback, { ...this.params, search })
                }
                else {
                    this.options = this.options.map(opt => ({
                        ...opt,
                        hidden: !empty(search) && (
                            !opt.label.toLowerCase().includes(search.toLowerCase())
                            && !opt.small?.toLowerCase().includes(search.toLowerCase())
                            && !opt.caption?.toLowerCase().includes(search.toLowerCase())
                        ),
                    }))
                }

                this.$dispatch('fetch', search)
            },

            navigate (e) {
                const isUp = e.key === 'ArrowUp'
                const isDown = e.key === 'ArrowDown'
                const max = this.filtered.length ? this.filtered.length - 1 : 0

                if (isDown && !this.$refs.dropdown.isOpened) this.$refs.dropdown.open()
                else {
                    if (this.pointer === null) this.pointer = 0
                    else if (isDown) this.pointer++
                    else if (isUp) this.pointer--

                    if (this.pointer < 0) this.pointer = 0
                    if (this.pointer > max) this.pointer = max
                }
            },

            isSelected (opt) {
                return this.multiple && this.value && this.value.includes(opt.value)
                    || !this.multiple && this.value === opt.value
            },
        }"
        x-modelable="value"
        x-on:focus="focus = true"
        x-on:blur="focus = false"
        x-on:click.away="close()"
        x-on:keydown.down.stop="navigate"
        x-on:keydown.up.stop="navigate"
        x-on:keydown.enter.prevent="select(pointer || 0)"
        x-on:keydown.esc.prevent="close()"
        tabindex="0"
        class="focus:outline-none active:outline-none"
        {{ $attributes->except($except)}}>
        <div
            x-ref="anchor"
            x-on:click="open()"
            x-bind:class="focus && 'active'"
            class="form-input w-full cursor-pointer flex gap-3">
            @if ($icon) <div class="shrink-0 text-gray-400"><x-icon :name="$icon"/></div> @endif

            <template x-if="isEmpty">
                <div class="grow text-gray-400">{{ $placeholder }}</div>
            </template>
    
            @if ($slot->isNotEmpty())
                <template x-if="!isEmpty">
                    <div class="grow">{{ $slot }}</div>
                </template>
            @else
                <template x-if="!isEmpty && multiple">
                    <div class="grow flex items-center gap-2 flex-wrap {{ !$icon ? '-ml-1.5' : '' }}">
                        <template x-for="option in selection">
                            <div class="bg-slate-200 rounded border border-gray-200">
                                <div class="flex items-center max-w-[200px]">
                                    <div x-text="option.label" class="px-2 truncate text-xs font-medium"></div>
                                    <div class="shrink-0 text-sm flex items-center justify-center px-1">
                                        <x-close x-on:click.stop="remove(option)"/>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>

                <template x-if="!isEmpty && !multiple">
                    <div x-text="selection?.label" class="grow"></div>
                </template>
            @endif

            <template x-if="clearable && !isEmpty">
                <div class="shrink-0"><x-close x-on:click.stop="remove()"/></div>
            </template>

            <template x-if="!clearable || (clearable && isEmpty)">
                <div class="shrink-0"><x-icon name="dropdown-caret"/></div>
            </template>
        </div>

        <div
            x-ref="dropdown"
            x-show="dropdown"
            x-transition.opacity.duration.300
            x-anchor.offset.4="$refs.anchor"
            class="bg-white shadow-lg rounded-md border border-gray-300 overflow-hidden">
            <template x-if="isSearchable">
                <div x-on:input.stop class="rounded-t-md border bg-slate-100 py-2 px-4 flex items-center gap-3">
                    <div class="shrink-0 text-gray-400"><x-icon name="search"/></div>

                    <input type="text"
                        x-ref="search"
                        x-model.debounce.500ms="search"
                        placeholder="{{ tr('app.label.search') }}"
                        class="grow transparent w-full">

                    <div
                        x-show="search && !loading" 
                        x-on:click="() => {
                            search = null
                            $nextTick(() => $refs.search.focus())
                        }"
                        class="shrink-0 text-gray-400 cursor-pointer">
                        <x-icon name="arrow-left"/>
                    </div>

                    <div x-show="loading" class="shrink-0 flex items-center justify-center text-theme">
                        <x-spinner size="20"/>
                    </div>
                </div>
            </template>

            <div class="flex flex-col divide-y">
                <ul class="max-h-[250px] overflow-auto">
                    <template x-for="(opt, i) in filtered" x-bind:key="opt.value">
                        <li 
                            x-bind:class="pointer === i ? 'bg-gray-50' : 'hover:bg-gray-50'"
                            x-on:mouseover="pointer = null"
                            x-on:click="select(i)" 
                            class="cursor-pointer border-b last:border-0">
                            <div x-show="opt.is_group" class="py-2 px-4 flex items-center gap-3 font-semibold bg-gray-100">
                                <template x-if="opt.icon">
                                    <i x-bind:class="opt.icon.split(' ').map(val => `fa-${val}`)"></i>
                                </template>
                                <div class="grow font-semibold" x-text="opt.label"></div>
                                <x-icon name="chevron-down" class="shrink-0"/>
                            </div>

                            <div 
                                x-show="!opt.is_group"
                                x-bind:class="isSelected(opt) 
                                    ? 'border-l-4 border-theme pl-3 pr-4'
                                    : 'px-4 hover:bg-slate-50'"
                                class="py-2 flex items-center gap-3 cursor-pointer">
                                <template x-if="opt.color">
                                    <div class="shrink-0 w-4 h-4 rounded-full shadow"
                                        x-bind:style="{ backgroundColor: opt.color }"></div>
                                </template>

                                <template x-if="opt.avatar?.url || typeof opt.avatar === 'string'">
                                    <div class="shrink-0 w-10 h-10 rounded-full border shadow">
                                        <img x-bind:src="opt.avatar?.url || opt.avatar" class="w-full h-full object-cover">
                                    </div>
                                </template>

                                <template x-if="typeof opt.avatar === 'object' && !opt.avatar?.url && opt.avatar?.placeholder">
                                    <div class="shrink-0 w-10 h-10 rounded-full bg-gray-500 text-gray-100 shadow flex items-center justify-center">
                                        <div class="font-bold" x-text="opt.avatar?.placeholder.substring(0, 2).toUpperCase()"></div>
                                    </div>
                                </template>

                                <template x-if="opt.hasOwnProperty('flag')">
                                    <div class="shrink-0 w-5 h-5 flex">
                                        <img x-show="opt.flag" x-bind:src="opt.flag" class="w-full object-contain m-auto">
                                        <div x-show="!opt.flag" class="w-full h-full border rounded bg-gray-100"></div>
                                    </div>
                                </template>

                                <div class="grow">
                                    <div class="flex items-center gap-3">
                                        <div class="grow grid">
                                            <div x-text="opt.label" class="truncate"></div>
                                        </div>
                                        <div x-text="opt.remark" class="shrink-0 text-right text-sm text-gray-500 font-medium"></div>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <div class="grow grid">
                                            <div class="text-sm text-gray-500 truncate" x-text="opt.small || opt.caption"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </template>

                    <template x-if="!loading && !filtered.length">
                        <x-no-result xs/>
                    </template>
                </ul>

                @if (isset($foot) && $foot->isNotEmpty())
                    <div x-show="!loading" class="p-3 bg-gray-100">{{ $foot }}</div>
                @endif 
            </div>
        </div>
    </div>
</x-form.field>
