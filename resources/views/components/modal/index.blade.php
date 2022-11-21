@props([
    'el' => $attributes->get('form') ? 'form' : 'div',
    'bgclose' => $attributes->get('bgclose', true),
])

<div
    x-data="{
        show: false,
        bgclose: @js($bgclose),
        open () { this.show = true },
        close () { this.show = false },
    }"
    x-on:{{ $uid }}-open.window="open()"
    x-on:{{ $uid }}-close.window="close()"
    x-cloak
>
    <div 
        x-show="show" 
        x-transition.opacity 
        class="fixed inset-0 z-50 overflow-auto"
    >
        <div
            x-on:click="bgclose && $dispatch('{{ $uid }}-close')"
            class="fixed inset-0 bg-black/80">
        </div>

        <div class="absolute left-1/2 -translate-x-1/2 px-6 py-10 w-full mx-auto {{ $attributes->get('class', 'max-w-lg') }}">
            <{{ $el }} {{ 
                $attributes->merge([
                    'class' => 'bg-white rounded-xl border shadow-lg',
                    'wire:submit.prevent' => $el === 'form' ? 'submit' : null,
                ])->except(['uid', 'header', 'form']) 
            }}>
                <div class="p-4 flex items-center justify-between border-b">
                    @isset($header)
                        <div class="font-semibold text-lg">{{ $header }}</div>
                    @elseif ($header = $attributes->get('header'))
                        <div class="flex items-center gap-3">
                            @if ($icon = $attributes->get('icon')) <x-icon :name="$icon" class="text-gray-400"/> @endif
                            <div class="font-semibold text-lg">{{ __($header) }}</div>
                        </div>
                    @endif

                    <x-close x-on:click="$dispatch('{{ $uid }}-close')"/>
                </div>

                <div class="p-6">
                    {{ $slot }}
                </div>

                @isset($foot)
                    <div class="p-4 bg-gray-100 rounded-b-xl">
                        {{ $foot }}
                    </div>
                @endisset
            </{{ $el }}>
        </div>
    </div>
</div>

