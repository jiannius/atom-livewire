@php
$id = $attributes->get('id') ?? $this->getName() ?? $this->id;
$locked = $attributes->get('locked', false);
$heading = $heading ?? $attributes->getAny('title', 'heading');
@endphp

<div
    x-cloak
    x-data="overlay({{ Js::from($id) }})"
    x-show="show"
    x-transition.opacity.duration.200
    x-on:keydown.escape.window.stop="close()"
    class="overlay dialog fixed inset-0 overflow-auto z-50"
    {{ $attributes->merge(['id' => $id])->except('class') }}>
    <div
        @if (!$locked) x-on:click="close()" @endif
        class="bg-black/80 fixed inset-0">
    </div>

    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white shadow-lg flex flex-col max-h-[95%] h-max w-full md:rounded-xl {{
        $attributes->get('class', 'md:max-w-[95%]')
    }}">
        @if ($heading)
            <div class="shrink-0 bg-slate-50 md:rounded-t-xl">
                @if ($heading instanceof \Illuminate\View\ComponentSlot)
                    @if ($heading->isEmpty())
                        <x-heading class="p-4 mb-0" :attributes="$heading->attributes" lg/>
                    @else
                        {{ $heading }}
                    @endif
                @else
                    <x-heading class="p-5 mb-0" :title="$heading" lg/>
                @endif

                <div class="absolute top-4 right-4">
                    <button type="button"
                        x-on:click="close()"
                        class="flex items-center justify-center p-2 text-xl text-gray-400 hover:text-black">
                        <x-icon name="close"/>
                    </button>
                </div>
            </div>
        @endif

        <div class="grow overflow-auto">
            {{ $slot }}
        </div>

        @if (isset($foot) && $foot->isNotEmpty())
            <div class="shrink-0 bg-gray-100 p-4 md:rounded-b-xl">
                {{ $foot }}
            </div>
        @endif
    </div>
</div>