<div class="max-w-screen-xl mx-auto">
    <x-page-header :title="$this->title"/>

    <div class="grid gap-6 md:grid-cols-12">
        <div class="md:col-span-3">
            <x-sidenav wire:model="tab">
                @foreach (array_filter($this->tabs) as $item)
                    @if ($children = data_get($item, 'tabs'))
                        @if ($group = data_get($item, 'group'))
                            <x-sidenav.group :label="$group"/>
                        @endif

                        @foreach (array_filter($children) as $child)
                            <x-sidenav.item
                                :icon="data_get($child, 'icon')"
                                :href="data_get($child, 'href') ?? route('app.settings', [data_get($child, 'slug')])"
                                :label="data_get($child, 'label')"
                            />
                        @endforeach
                    @else
                        <x-sidenav.item
                            :icon="data_get($item, 'icon')"
                            :href="data_get($item, 'href') ?? route('app.settings', [data_get($item, 'slug')])"
                            :label="data_get($item, 'label')"
                        />
                    @endif
                @endforeach
            </x-sidenav>
        </div>

        <div class="md:col-span-9">
            @livewire($livewire, key($tab))
        </div>
    </div>
</div>