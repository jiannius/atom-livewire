@php
$code = $attributes->get('code', '+60');
$placeholder = $attributes->get('placeholder', 'app.label.phone-number');
@endphp

<x-input class="h-px" :attributes="$attributes->except('class')">
    <span
        x-cloak
        x-data="{
            wire: @entangle($attributes->wire('model')),
            show: false,
            input: null,
            search: null,
            option: null,
            options: [],
            code: @js($code),
            endpoint: @js(route('__select')),
            number: null,
    
            get filtered () {
                return this.options.filter(opt => (
                    !this.search
                    || opt.value.includes(this.search)
                    || opt.label.toLowerCase().includes(this.search.toLowerCase())
                ))
            },
    
            init () {
                ajax(this.endpoint).post({ callback: 'dial_codes' }).then(data => {
                    this.options = [...data]
    
                    this.$nextTick(() => {
                        if (this.wire) this.initInput(this.wire)
                        else if (this.code) {
                            const find = this.options.find(opt => (opt.value === this.code))
                            if (find) this.select(find)
                        }
                    })
                })
    
                this.$watch('code', () => this.format())
                this.$watch('number', () => this.format())
                this.$watch('wire', wire => this.initInput(wire))
            },
    
            format () {
                const val = `${this.code}${this.number}`
                this.input = val.length ? val : null
                this.$dispatch('input', this.input)
            },
            
            initInput (val) {
                const find = this.options.find(opt => (val.startsWith(opt.value)))
    
                if (find) {
                    this.select(find)
                    this.number = val.replace(this.code, '').replace('+', '')
                }
            },
            
            select (opt) {
                if (!opt) return
                this.option = { ...opt }
                this.code = opt.value
                this.close()
            },
    
            open () {
                this.show = true
                this.$nextTick(() => this.$refs.search.focus())
            },
    
            close () {
                this.show = false
                setTimeout(() => this.search = null, 300)
            },
        }"
        x-modelable="input"
        x-on:focus="$nextTick(() => $refs.tel.focus())"
        x-on:click.away="close()"
        class="inline-flex items-center w-full h-full"
        {{ $attributes->whereStartsWith('x-') }}
        {{ $attributes->wire('model') }}>
        <div x-ref="anchor" class="grow inline-flex items-center gap-3">
            <div x-on:click="open()" class="cursor-pointer flex items-center gap-2 form-input-caret pr-6">
                <div class="w-4 h-4 flex">
                    <img x-bind:src="option?.flag" x-show="option" class="w-full h-full object-contain">
                </div>
                <div class="text-gray-500" x-text="code"></div>
            </div>
    
            <input 
                type="tel" 
                x-ref="tel"
                x-model="number"
                x-on:input.stop
                class="grow appearance-none bg-transparent">
        </div>
    
        <div 
            x-ref="dropdown"
            x-show="show"
            x-anchor.bottom-start.offset.4="$refs.anchor"
            x-transition.opacity.duration.300
            class="bg-white z-10 border border-gray-300 shadow-lg rounded-md overflow-hidden">
            <div x-on:input.stop class="rounded-t-md border bg-slate-100 py-2 px-4 flex items-center gap-3">
                <div class="shrink-0 text-gray-400">
                    <x-icon name="search"/>
                </div>

                <input type="text"
                    x-ref="search"
                    x-model.debounce.100ms="search"
                    x-on:keydown.enter.prevent="filtered.length && select(filtered[0])"
                    placeholder="{{ tr('app.label.search') }}"
                    class="grow transparent w-full">
            </div>

            <div class="max-h-[250px] overflow-auto">
                <div class="flex flex-col divide-y">
                    <template x-for="opt in filtered">
                        <div x-on:click="select(opt)" class="flex items-center gap-2 py-2 px-4 hover:bg-gray-100 cursor-pointer">
                            <div class="shrink-0 w-4 h-4 flex">
                                <img x-bind:src="opt.flag" x-show="opt.flag" class="w-full h-full object-contain">
                            </div>
                            <div class="shrink-0 text-gray-500" x-text="opt.value"></div>
                            <div class="grow font-medium" x-text="opt.label"></div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </span>
</x-input>