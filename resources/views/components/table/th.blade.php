@php
    $label = $attributes->get('label');
    $sortBy = $attributes->get('sort');
    $checkbox = $attributes->get('checkbox', false);
@endphp

@if ($attributes->get('menu'))
    <th class="bg-slate-100 border-b border-gray-200 w-12"></th>
@elseif ($checkbox)
    <th 
        x-data="{
            get checkboxes () {
                return this.$el.closest('table').querySelectorAll('[data-checkbox-value]')
            },
            get isSelectedAll () {
                return this.$wire.get('checkboxes').length >= this.checkboxes.length
            },
            selectAll () {
                if (this.isSelectedAll) this.$wire.set('checkboxes', [])
                else {
                    const values = Array.from(this.checkboxes)
                        .map((checkbox) => (checkbox.getAttribute('data-checkbox-value')))
                    this.$wire.set('checkboxes', values)
                }
            },
        }"
        x-on:click.stop="selectAll"
        class="py-1 px-2 bg-slate-100 border-b border-gray-200 w-10 sticky top-0 z-10">
        <div
            x-bind:class="isSelectedAll ? 'border-theme border-2' : 'bg-white border-gray-300'" 
            class="mx-4 w-6 h-6 p-0.5 rounded shadow border cursor-pointer">
            <div x-show="isSelectedAll" class="bg-theme w-full h-full"></div>
        </div>
    </th>
@else
    <th class="py-1 px-2 bg-slate-100 font-medium text-sm border-b border-gray-200 leading-6 tracking-wider sticky top-0 z-10">
        <div 
            x-data="{
                sortBy: @js($sortBy),
                get current () {
                    const order = this.$wire.get('tableSortOrder')
                    const split = order?.split(',')

                    return {
                        sortBy: split ? split[0] : null,
                        sortOrder: split ? split[1] : null,
                    }
                },
                get isSorted () {
                    return this.sortBy && this.current.sortBy === this.sortBy
                },
                sort () {
                    if (!this.sortBy) return

                    if (this.isSorted) {
                        if (this.current.sortOrder === 'asc') this.$wire.set('tableSortOrder', this.sortBy+',desc')
                        else if (this.current.sortOrder === 'desc') this.$wire.call('resetTableSortOrder')
                    }
                    else this.$wire.set('tableSortOrder', this.sortBy+',asc')
                },
            }"
            x-on:click="sort"
            x-bind:class="isSorted && 'bg-gray-200 rounded'"
            {{ $attributes->class([
                'py-1 px-2 whitespace-nowrap', 
                $sortBy ? 'cursor-pointer text-black font-semibold' : 'text-gray-500',
                $attributes->get('class', 'text-left'),
            ])->except(['label', 'sort']) }}
            id="{{ str()->slug('th-'.$label) }}"
        >
            <span class="inline-flex items-center gap-2">
                {!! str(__($label))->upper() !!}
                @if ($sortBy) 
                    <x-icon x-show="isSorted && current.sortOrder === 'desc'" name="chevron-up sm" class="shrink-0" size="10"/> 
                    <x-icon x-show="isSorted && current.sortOrder === 'asc'" name="chevron-down sm" class="shrink-0" size="10"/>
                    <x-icon x-show="!isSorted" name="sort sm" class="shrink-0" size="10"/>
                @endif
            </span>
        </div>
    </th>
@endif
