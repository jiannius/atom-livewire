<form wire:submit.prevent="submit">
    <x-modal.drawer {{ $attributes }}>
        <x-slot:buttons>
            @isset($buttons)
                @if ($buttons->isNotEmpty()) {{ $buttons }}
                @elseif (!$buttons->attributes->get('blank')) <x-button action="submit"/>
                @endif

                @if ($buttons->attributes->get('archive', false)) <x-button action="archive"/> @endif
                @if ($buttons->attributes->get('trash', false)) <x-button action="trash" invert no-label x-tooltip.raw="{{ tr('app.label.trash') }}"/> @endif
                @if ($buttons->attributes->get('delete', false)) <x-button action="delete" invert no-label x-tooltip.raw="{{ tr('app.label.delete') }}"/> @endif
                @if ($buttons->attributes->get('restore', false)) <x-button action="restore"/> @endif
            @else
                <x-button action="submit"/>
            @endisset
        </x-slot:buttons>

        @isset($heading)
            <x-slot:heading>
                @if ($heading->attributes->get('title'))
                    <x-heading :attributes="$heading->attributes"/>
                @else
                    {{ $heading }}
                @endif
            </x-slot:heading>
        @endisset

        {{ $slot }}
    </x-modal.drawer>
</form>