<div>
    <x-table>
        <x-slot:header>
            <x-table.searchbar :total="$this->paginator->total()">
                <x-table.filters>
                    <x-form.group>
                        <x-form.select.enum label="app.label.status" enum="enquiry.status" multiple
                            wire:model="filters.status"/>
                        <x-form.date range label="app.label.created-date" wire:model="filters.created_at"/>
                    </x-form.group>
                </x-table.filters>

                <x-table.export/>
            </x-table.searchbar>
        </x-slot:header>

        <x-slot:thead>
            <x-table.th label="app.label.date" sort="created_at"/>
            <x-table.th label="app.label.name" sort="name"/>
            <x-table.th label="app.label.phone"/>
            <x-table.th label="app.label.email"/>
            <x-table.th label="app.label.status" class="text-right"/>
        </x-slot:thead>

        @foreach ($this->paginator->items() as $enquiry)
            <x-table.tr wire:click="$emit('updateEnquiry', {{ $enquiry->id }})">
                <x-table.td :date="$enquiry->created_at"/>
                <x-table.td :label="$enquiry->name" class="font-medium"/>
                <x-table.td :label="$enquiry->phone"/>
                <x-table.td :label="$enquiry->email"/>
                <x-table.td :status="$enquiry->status->badge()" class="text-right"/>
            </x-table.tr>
        @endforeach
    </x-table>

    {!! $this->paginator->links() !!}
</div>