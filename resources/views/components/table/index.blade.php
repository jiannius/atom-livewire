@props([
    'header' => $header ?? $attributes->get('header'),
    'search' => $attributes->get('search', 'filters.search'),
])

<div class="relative flex flex-col gap-4">
    <div 
        x-data="{
            name: @js($uid),
            total: @js($attributes->get('total', 0)),
            checkedValues: [],
            get totalRows () {
                return $el.querySelectorAll('table tbody tr').length
            },
            get checkedCount () {
                if (this.checkedValues.includes('all')) return this.totalRows
                else if (this.checkedValues.includes('everything')) return this.total
                else return this.checkedValues.length
            },
            selectTotal () {
                const data = { name: this.name, value: 'everything' }
                this.$dispatch('table-checkbox-check', data)
                this.$wire && this.$wire.emit('table-checkbox-check', data)
            },
        }"
        x-on:table-checkbox-checked.window="checkedValues = $event.detail"
        class="relative shadow rounded-lg border bg-white flex flex-col divide-y"
    >
        @if ($header || isset($headerButtons))
            <div class="flex flex-wrap items-center gap-3 p-4 first-of-type:rounded-t-lg last-of-type:rounded-b-lg">
                @if ($header)
                    <div class="grow font-bold text-lg">
                        {{ is_string($header) ? __($header) : $header }}
                    </div>
                @endif

                @isset($headerButtons)
                    <div class="shrink-0">
                        {{ $headerButtons }}
                    </div>
                @endisset
            </div>
        @endif

        <div class="py-3 px-4 first-of-type:rounded-t-lg last-of-type:rounded-b-lg">
            <div x-show="checkedCount" class="flex flex-wrap justify-between items-center gap-3">
                <div class="shrink-0 flex items-center gap-2">
                    <div class="flex items-center gap-2 py-1 px-3 rounded-full text-sm bg-gray-200">
                        <x-icon name="check" class="text-green-500"/>
                        <div class="flex items-center gap-1 font-medium">
                            <div x-text="checkedCount"></div>
                            <div>{{ __('Selected Rows') }}</div>
                        </div>
                    </div>

                    @if ($attributes->get('allow-select-everything', true))
                        <a 
                            x-show="total > totalRows && checkedValues.includes('all')" 
                            x-on:click="selectTotal"
                            class="text-sm"
                        >
                            {{ __('Select all :total rows', ['total' => $attributes->get('total')]) }}
                        </a>
                    @endif
                </div>

                @isset($checked) {{ $checked }} @endisset
            </div>

            <div x-show="!checkedCount" class="flex flex-wrap justify-between items-center gap-3">
                <div class="text-gray-800 flex items-end gap-1.5">
                    @if ($attributes->has('total'))
                        <div class="text-lg font-medium leading-snug">{{ $attributes->get('total') }}</div>
                        <div class="text-gray-500">{{ __('total rows') }}</div>
                    @endif
                </div>

                <div class="shrink-0 flex items-center gap-2">
                    @if ($search !== false)
                        <x-form.text placeholder="Search"
                            wire:model.debounce.400ms="{{ $search }}"
                            prefix="icon:search"
                        >
                            <x-slot:postfix>
                                <x-close
                                    x-show="$wire.get('{{ $search }}')"
                                    x-on:click="$wire.set('{{ $search }}', null)"
                                />
                            </x-slot:postfix>
                        </x-form.text>
                    @endif
    
                    @if ($attributes->get('total'))
                        @if ($export = $attributes->get('export'))
                            <div class="shrink-0">
                                @if (is_array($export))
                                    <x-dropdown right>
                                        <x-slot:anchor>
                                            <div class="p-2 rounded-full flex text-gray-500 hover:text-gray-800 hover:bg-gray-200">
                                                <x-icon name="export" class="m-auto"/>
                                            </div>
                                        </x-slot:anchor>
        
                                        @foreach ($export as $val)
                                            <x-dropdown.item
                                                :label="data_get($val, 'label')"
                                                wire:click="export('{{ data_get($val, 'value') }}')"
                                            />
                                        @endforeach
                                    </x-dropdown>
                                @else
                                    <a
                                        x-data
                                        x-tooltip="Export"
                                        wire:click.prevent="export"
                                        class="p-2 rounded-full flex text-gray-500 hover:text-gray-800 hover:bg-gray-200"
                                    >
                                        <x-icon name="export" class="m-auto"/>
                                    </a>
                                @endif
                            </div>
                        @endif
                    @endif
                        
                    @isset($filters)
                        <div class="shrink-0">
                            <a
                                x-data
                                x-tooltip="Filters"
                                x-on:click.prevent="$dispatch('{{ $uid }}-drawer-open')"
                                class="p-2 rounded-full flex text-gray-500 hover:text-gray-800 hover:bg-gray-200"
                            >
                                <x-icon name="sliders" class="m-auto"/>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @isset($toolbar)
            <div x-show="!checkedCount" class="py-3 px-4 first-of-type:rounded-t-lg last-of-type:rounded-b-lg">
                {{ $toolbar }}
            </div>
        @endisset
    
        @if ($attributes->get('total'))
            <div class="w-full overflow-auto max-h-screen first-of-type:rounded-t-lg last-of-type:rounded-b-lg">
                <table class="w-max divide-y divide-gray-200 md:w-full md:max-w-full" uid="{{ $uid }}">
                    @isset($head)
                        <thead>
                            <tr>
                                {{ $head }}
                            </tr>
                        </thead>
                    @endisset

                    @isset($body)
                        <tbody class="bg-white">
                            {{ $body }}
                        </tbody>
                    @endisset

                    @isset($foot)
                        <tfoot>
                            {{ $foot }}
                        </tfoot>
                    @endisset
                </table>
            </div>
        @else
            @isset($empty)
                {{ $empty }}
            @else
                <x-empty-state/>
            @endisset
        @endif
    </div>
    
    {!! $attributes->get('links') !!}
</div>

@isset($filters)
    <x-drawer uid="{{ $uid }}-drawer">
        <x-slot name="title">{{ __('Filters') }}</x-slot>

        <div class="grid gap-8">
            <div class="grid gap-6">
                {{ $filters }}
            </div>

            <div class="flex items-center justify-between gap-4">
                <x-button color="gray" icon="refresh" wire:click="resetFilters">
                    {{ __('Reset') }}
                </x-button>
            </div>
        </div>
    </x-drawer>
@endisset
