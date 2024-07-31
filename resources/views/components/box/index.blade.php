@php
$icon = $attributes->get('icon');
$href = $attributes->get('href');
$target = $attributes->get('target', '_self');
$rel = $attributes->get('rel', 'noopener noreferrer nofollow');
$hasSubmitAction = $attributes->hasLike('wire:submit*', 'x-on:submit*', 'x-recaptcha:submit*') || is_string($attributes->get('submit'));
$element = pick([
    'a' => !empty($href),
    'form' => $attributes->get('form') || $attributes->get('submit') || $hasSubmitAction,
    'div' => true,
]);
$heading = $heading ?? $title ?? $attributes->get('heading') ?? $attributes->get('title');
$except = ['cover', 'title', 'heading', 'href', 'target', 'rel', 'submit', 'class'];
@endphp

<{{ $element }}
    @if ($element === 'a')
    href="{{ $href }}"
    target="{{ $target }}"
    rel="{{ $rel }}"
    @elseif ($element === 'form' && !$hasSubmitAction)
    wire:submit.prevent="submit"
    @elseif ($element === 'form' && $hasSubmitAction)
    wire:submit.prevent="{{ $attributes->get('submit') }}"
    @endif
    class="box group/box relative bg-white rounded-xl border shadow-sm w-full"
    {{ $attributes->except($except) }}>
    <div class="absolute top-4 right-4 hidden group-[.is-loading]/box:block">
        <x-spinner size="20" class="text-theme"/>
    </div>

    @if ($heading instanceof \Illuminate\View\ComponentSlot)
        <x-heading class="p-4 mb-0" :attributes="$heading->attributes">
            {{ $heading }}
        </x-heading>
    @elseif ($heading)
        <x-heading class="p-4 mb-0" :title="$heading" :icon="$icon"/>
    @endif

    @isset ($figure)
        <div class="first:rounded-t-lg last:rounded-b-lg overflow-hidden">
            <figure {{ $figure->attributes->class([
                'h-72 bg-gray-200 flex items-center justify-center',
                'group-hover/box:scale-105 transition-transform duration-200',
            ]) }}>
                @if ($figure->isNotEmpty())
                    {{ $figure }}
                @else
                    <x-icon name="image" class="text-gray-300 text-xl"/>
                @endif
            </figure>
        </div>
    @endisset

    @if ($slot->isNotEmpty())
        <div {{ $attributes->only('class') }}>
            {{ $slot }}
        </div>
    @endif

    @isset ($foot)
        <div {{ $foot->attributes->merge(['class' => 'py-3 px-4 bg-slate-100 rounded-b-xl']) }}>
            {{ $foot }}
        </div>
    @endisset
</{{ $element }}>
