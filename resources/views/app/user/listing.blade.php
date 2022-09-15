<div class="max-w-screen-lg mx-auto">
    <x-table 
        header="Users"
        :total="$this->users->total()" 
        :links="$this->users->links()"
    >
        <x-slot:header-buttons>
            <x-button size="sm"
                label="New User" 
                :href="route('app.user.create', [
                    'account' => optional($account)->id,
                    'role' => optional($role)->id,
                ])"
            />
        </x-slot:header>

        @if (count($this->tabs) > 1)
            <x-slot:toolbar :trashed="data_get($filters, 'status') === 'trashed'">
                <x-tab wire:model="filters.status">
                    @foreach ($this->tabs as $item)
                        <x-tab.item 
                            :name="data_get($item, 'slug')" 
                            :label="data_get($item, 'label')"
                            :count="data_get($item, 'count')"
                        />
                    @endforeach
                </x-tab>
            </x-slot:toolbar>
        @endif

        <x-slot:head>
            <x-table.th label="Name" sort="name"/>
            @module('roles') <x-table.th label="Role" class="text-right"/> @endmodule
            <x-table.th label="Created Date" class="text-right"/>
            <x-table.th/>
        </x-slot:head>

        <x-slot:body>
            @foreach ($this->users as $user)
                <x-table.tr>
                    <x-table.td>
                        @if ($user->id === auth()->id())
                            <span>{{ $user->name }} ({{ __('You') }})</span>
                        @else
                            <div>
                                <a href="{{ route('app.user.update', [$user->id]) }}">
                                    {{ $user->name }}
                                </a>
                                <div class="text-gray-500">
                                    {{ $user->email }}
                                </div>
                            </div>
                        @endif
                    </x-table.td>

                    @module('roles')
                        <x-table.td :label="data_get($user->role, 'name')" class="text-right"/>
                    @endmodule

                    <x-table.td :date="$user->created_at" class="text-right"/>
                    <x-table.td :status="$user->status" class="text-right"/>
                </x-table.tr>
            @endforeach
        </x-slot:body>

        <x-slot:empty>
            <x-empty-state title="No Users" subtitle="User list is empty"/>
        </x-slot:empty>
    </x-table>
</div>