<div>
    <x-table>
        <x-slot:header>
            <x-table.searchbar :total="$this->paginator->total()">
                <x-table.filters>
                    <x-form.group>
                        <x-form.select.enum label="app.label.status" enum="announcement.status" multiple
                            wire:model="filters.status"/>
                    </x-form.group>
                </x-table.filters>
            </x-table.searchbar>

            <x-table.checkbox-actions delete/>
        </x-slot:header>

        <x-slot:thead>
            <x-table.th label="app.label.title" sort="name"/>
            <x-table.th label="app.label.status" class="text-right"/>
        </x-slot:thead>

        @foreach ($this->paginator->items() as $row)
            <x-table.tr wire:click="$emit('updateAnnouncement', {{ $row->id }})">
                <x-table.td :label="$row->name" limit="100" class="font-medium"/>
                <x-table.td :status="$row->status->badge()" class="text-right"/>
            </x-table.td>
        @endforeach
    </x-table>

    {!! $this->paginator->links() !!}
</div>