<atom:card>
    <atom:_form>
        <atom:_heading size="lg">Change Password</atom:_heading>
        <x-input type="password" wire:model.defer="password.current" label="Current Password"/>
        <x-input type="password" wire:model.defer="password.new" label="New Password"/>
        <x-input type="password" wire:model.defer="password.new_confirmation" label="Confirm New Password"/>
        <atom:_button action="submit">Save</atom:_button>
    </atom:_form>
</atom:card>
