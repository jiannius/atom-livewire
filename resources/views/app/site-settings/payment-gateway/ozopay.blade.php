<form wire:submit.prevent="submit">
    <x-box>
        <x-slot name="header">Ozopay Settings</x-slot>
        
        <div class="p-5">
            <x-input.text wire:model.defer="settings.ozopay_tid" :error="$errors->first('settings.ozopay_tid')" required>
                {{ __('Ozopay Terminal ID') }}
            </x-input.text>
        
            <x-input.text wire:model.defer="settings.ozopay_secret" :error="$errors->first('settings.ozopay_secret')" required>
                {{ __('Ozopay Secret') }}
            </x-input.text>
        
            <x-input.text wire:model.defer="settings.ozopay_url" :error="$errors->first('settings.ozopay_url')" required>
                {{ __('Ozopay URL') }}
            </x-input.text>
        
            <x-input.text wire:model.defer="settings.ozopay_sandbox_url">
                {{ __('Ozopay Sandbox URL') }}
            </x-input.text>
        </div>

        <x-slot name="buttons">
            <x-button type="submit" color="green" icon="check">
                Save
            </x-button>
        </x-slot>
    </x-box>
</form>