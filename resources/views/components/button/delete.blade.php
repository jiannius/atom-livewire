<x-button 
    icon="trash" 
    color="red"
    x-on:click="$dispatch('confirm', {
        title: '{{ __($attributes->get('title') ?? 'Delete') }}',
        message: '{{ __($attributes->get('message') ?? 'Are you sure?') }}',
        type: 'error',
        onConfirmed: () => $wire.delete({{ json_encode($attributes->get('params') ?? null) }}),
    })"
    :label="$attributes->get('label') ?? 'Delete'"
    {{ $attributes->only(['inverted', 'size']) }}
/>
