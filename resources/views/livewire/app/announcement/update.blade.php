<x-form.drawer id="announcement-update" class="max-w-screen-lg w-full" wire:close="close()">
@if ($announcement)
    @if ($announcement->exists) 
        <x-slot:heading title="app.label.update-announcement"></x-slot:heading>
        <x-slot:buttons delete>
            <x-button.submit sm/>
            <x-button icon="copy" label="common.label.duplicate" sm wire:click="duplicate()"/>
        </x-slot:buttons>
    @else
        <x-slot:heading title="app.label.create-announcement"></x-slot:heading>
    @endif

    <x-form.group cols="2">
        <x-form.text label="app.label.title" wire:model.defer="announcement.name"/>
        <x-form.slug label="app.label.slug" wire:model.defer="announcement.slug"/>
        <x-form.date time label="app.label.start-date" wire:model.defer="announcement.start_at"/>
        <x-form.date time label="app.label.end-date" wire:model.defer="announcement.end_at"/>
        <x-form.color full label="app.label.bg-color" wire:model.defer="announcement.bg_color"/>
        <x-form.color full label="app.label.text-color" wire:model.defer="announcement.text_color"/>
    </x-form.group>

    <x-form.group>
        <x-form.text label="app.label.href" wire:model.defer="announcement.href"/>
        <x-form.editor label="app.label.content" wire:model.defer="announcement.content"/>
    </x-form.group>

    <x-form.group heading="SEO">
        <x-form.seo wire:model.defer="inputs.seo"/>
    </x-form.group>
@endif
</x-form.drawer>