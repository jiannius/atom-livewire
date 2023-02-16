<x-form>
    @if ($role->exists && in_array($role->slug, ['admin', 'administrator']))
        <x-form.field label="Role Name">
            {{ $role->name }}
        </x-form.field>
    @else
        <x-form.text
            label="Role Name"
            wire:model.defer="role.name"
            :error="$errors->first('role.name')"
            required
        />

        <x-slot:foot>
            <x-button.submit/>
        </x-slot:foot>
    @endif
</x-form>