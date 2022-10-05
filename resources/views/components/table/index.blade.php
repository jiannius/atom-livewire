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

        <div class="py-3 px-4 flex flex-wrap justify-between items-center gap-2 first-of-type:rounded-t-lg last-of-type:rounded-b-lg">
            <div class="text-gray-800 flex items-end gap-1.5">
                @if ($attributes->has('total'))
                    <div class="text-lg font-medium leading-snug">{{ $attributes->get('total') }}</div>
                    <div class="text-gray-500">{{ __('total rows') }}</div>
                @endif
            </div>

            <div x-show="!checkedCount" class="flex flex-wrap items-center gap-2">
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
                        @if (is_array($export))
                            <x-dropdown right>
                                <x-slot:anchor>
                                    <div class="p-1.5 rounded-md flex items-center justify-center text-gray-900 hover:bg-gray-100 hover:border hover:shadow">
                                        <x-icon name="download" size="18px"/>
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
                                class="p-1.5 rounded-md flex items-center justify-center text-gray-900 hover:bg-gray-100 hover:border hover:shadow"
                            >
                                <x-icon name="download" size="18px" />
                            </a>
                        @endif
                    @endif
                    
                @endif
                    
                @isset($filters)
                    <a
                        x-data
                        x-tooltip="Filters"
                        x-on:click.prevent="$dispatch('{{ $uid }}-drawer-open')"
                        class="p-1.5 rounded-md flex items-center justify-center text-gray-900 hover:bg-gray-100 hover:border hover:shadow"
                    >
                        <x-icon name="slider" size="18px" />
                    </a>
                @endif
            </div>
        </div>

        <div x-show="checkedCount" class="py-3 px-4 flex items-center justify-between first-of-type:rounded-t-lg last-of-type:rounded-b-lg">
            <div class="grid">
                <div class="flex items-center gap-1.5">
                    <div class="font-medium" x-text="checkedCount"></div>
                    <div class="text-gray-500">{{ __('selected rows') }}</div>
                </div>
                <a 
                    x-show="total > totalRows && checkedValues.includes('all')" 
                    x-on:click="selectTotal"
                    class="text-sm"
                >
                    {{ __('Select all :total rows', ['total' => $attributes->get('total')]) }}
                </a>
            </div>

            <div>
                {{ $checked ?? null }}
            </div>
        </div>

        @isset($toolbar)
            <div x-show="!checkedCount" class="py-3 px-4 flex items-center justify-between gap-2 first-of-type:rounded-t-lg last-of-type:rounded-b-lg">
                <div>
                    {{ $toolbar }}
                </div>

                @if ($toolbar->attributes->get('trashed'))
                    <x-button color="red" icon="trash-alt" inverted size="sm" x-on:click="$dispatch('confirm', {
                        title: '{{ __('Empty Trashed') }}',
                        message: '{{ __('Are you sure to clear all trashed records?') }}',
                        type: 'warning',
                        onConfirmed: () => $wire.emptyTrashed().then(() => location.reload()),
                    })">
                        Empty Trashed
                    </x-button>
                @endif
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
