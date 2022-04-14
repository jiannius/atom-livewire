<div class="grid gap-6 md:grid-cols-12">
    @if ($this->tabs->count() > 1)
        <div class="md:col-span-3">
            <x-sidenav wire:model="tab">
                @foreach ($this->tabs as $item)
                    @if ($children = data_get($item, 'tabs'))
                        <x-sidenav :group="$item['group'] ?? null">
                            @foreach ($children as $child)
                                @if ($slug = data_get($child, 'slug') ?? $child)
                                    <x-sidenav item :icon="data_get($child, 'icon')" :name="$slug">
                                        {{ data_get($child, 'label') ?? str()->headline($slug) }}
                                    </x-sidenav>
                                @endif
                            @endforeach
                        </x-sidenav>
                    @elseif ($slug = data_get($item, 'slug') ?? $item)
                        <x-sidenav item :icon="data_get($item, 'icon')" :name="$slug">
                            {{ data_get($item, 'label') ?? json_encode($slug) }}
                        </x-sidenav>
                    @endif
                @endforeach
            </x-sidenav>
        </div>
    @endif

    <div class="{{ $this->tabs->count() > 1 ? 'md:col-span-9' : 'md:col-span-12' }}">
        @if ($component = livewire_name('account/'.$tab))
            @livewire($component, key($tab))
        @endif
    </div>
</div>
