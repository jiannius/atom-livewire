@props([
    'label' => $attributes->get('label', 'Delete'),
    'title' => $attributes->get('title')
        ? __($attributes->get('title'))
        : __('atom::popup.confirm.delete.title'),
    'message' => $attributes->get('message')
        ? __($attributes->get('message'))
        : __('atom::popup.confirm.delete.message'),
    'callback' => $attributes->get('callback', 'delete'),
    'params' => $attributes->get('params'),
    'reload' => $attributes->get('reload', false),
    'inverted' => $attributes->get('inverted', true),
])


<x-button c="red" icon="trash-can" :label="$label" :inverted="$inverted" x-on:click="$dispatch('confirm', {
    title: '{{ $title }}',
    message: '{{ $message }}',
    type: 'error',
    onConfirmed: () => {
        $wire.call('{{ $callback }}', {{ json_encode($params) }})
            .then(() => {{ json_encode($reload) }} && location.reload())
    },
})" {{ $attributes->except([
    'c', 
    'icon', 
    'label', 
    'title', 
    'message', 
    'callback', 
    'params', 
    'reload',
    'x-on:click',
]) }}/>
