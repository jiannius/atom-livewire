<div class="max-w-screen-md mx-auto">
    <x-page-header title="Users">
        <x-button icon="plus" href="{{ route('user.create') }}">
            New User
        </x-button>
    </x-page-header>

    <x-table :total="$users->total()" :links="$users->links()">
        <x-slot name="head">
            <x-table.head sort="name">Name</x-table.head>
            <x-table.head align="right">Role</x-table.head>
        </x-slot>

        <x-slot name="body">
        @foreach ($users as $user)
            <x-table.row>
                <x-table.cell>
                    <a href="{{ route('user.update', [$user->id]) }}">
                        {{ $user->name }}
                    </a>
                    <div class="text-xs text-gray-500">
                        {{ $user->email }}
                    </div>
                </x-table.cell>
                
                <x-table.cell class="text-right">
                    {{ $user->role->name ?? null }}
                </x-table.cell>
            </x-table.row>
        @endforeach
        </x-slot>

        <x-slot name="empty">
            <x-empty-state title="No Users" subtitle="User list is empty"/>
        </x-slot>
    </x-table>
</div>