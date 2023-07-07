<div class="max-w-screen-md mx-auto">
    <x-page-header :title="$this->label->locale('name')" back>
        <x-button.delete inverted
            title="Delete Label"
            message="Are you sure to DELETE this label?"
        />
    </x-page-header>

    @livewire(atom_lw('app.label.form'), compact('label'))
</div>