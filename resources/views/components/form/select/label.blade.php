<x-form.select
    :options="$options"
    {{ $attributes->except(['type', 'options', 'id', 'children']) }}>
    @isset($foot) {{ $foot }}
    @else
        <x-slot:foot icon="add" label="Create New"
            wire:click="$emit('createLabel', null, '{{ $type }}')"></x-slot:foot>
    @endisset
</x-form.select>