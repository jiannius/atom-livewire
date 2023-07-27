@props([
    'id' => $attributes->get('id', 'page-overlay'),
    'close' => $attributes->get('close', false),
])

<div 
    x-cloak
    x-data="{
        show: false,
        get isAdminPanel () {
            return !empty(document.querySelector('#admin-panel'))
        },
        open () { 
            this.show = true 
            if (this.isAdminPanel) document.body.style.overflow = 'hidden'
        },
        close () { 
            this.show = false
            if (this.isAdminPanel) document.body.style.overflow = 'auto'
        },
    }"
    x-show="show"
    x-transition.opacity
    x-on:{{ $id }}-open.window="open"
    x-on:{{ $id }}-close.window="close"
    x-on:open="open"
    x-on:close="close"
    x-bind:class="isAdminPanel
        ? 'top-0 bottom-0 right-0 left-0 lg:left-56'
        : 'inset-0'"
    class="page-overlay fixed z-40 overflow-auto {{ $attributes->get('bg', 'bg-slate-50') }}"
    id="{{ $id }}"
>
    <div {{ $attributes->class([
        'flex flex-col gap-4',
        $attributes->get('class', 'px-6 py-10')
    ]) }}>
        @if ($close)
            <div class="flex justify-end">
                <x-close x-on:click="$dispatch('close')" class="text-2xl"/>
            </div>
        @endif

        <div>{{ $slot }}</div>
    </div>
</div>