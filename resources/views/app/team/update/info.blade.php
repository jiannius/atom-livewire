<x-form header="Team Information">
    <x-form.text 
        label="Team Name"
        wire:model.defer="team.name" 
        :error="$errors->first('team.name')" 
        required
    />

    <x-form.textarea 
        label="Description"
        wire:model.defer="team.description"
    />

    <x-slot:foot>
        <x-button.submit/>
    </x-slot:foot>
</x-form>
