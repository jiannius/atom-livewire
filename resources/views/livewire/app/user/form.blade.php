<x-form id="user-form" :header="optional($user)->exists ? 'Update User' : 'Create User'" drawer>
    @if ($user)
        <x-slot:buttons>
            <x-button.submit size="sm"/>

            @if ($user->exists) 
                <x-button.delete inverted size="sm" :label="false"
                    title="Delete User"
                    message="Are you sure to DELETE this user?"
                /> 
            @endif
        </x-slot:buttons>

        <x-form.group>
            <x-form.text wire:model.defer="user.name" label="Login Name"/>
            <x-form.email wire:model.defer="user.email" label="Login Email"/>
            <x-form.select.role wire:model="user.role_id"/>
            <x-form.select.team wire:model="inputs.teams" multiple/>
            <x-form.checkbox wire:model="inputs.is_blocked" label="Blocked"/>
        </x-form.group>

        @if ($user->exists)
            <x-form.group label="Additional Information" cols="2">
                <x-form.field label="Last Login" :value="format_date($user->login_at, 'datetime') ?? '--'"/>
                <x-form.field label="Last Active" :value="format_date($user->last_active_at, 'datetime') ?? '--'"/>
                @if ($user->blocked_at)
                    <x-form.field label="Blocked At" :value="format_date($user->blocked_at, 'datetime')"/>
                @endif
            </x-form.group>
        @endif
    @endif
</x-form>
