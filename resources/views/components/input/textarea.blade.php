<x-input.field {{ $attributes->filter(fn($val, $key) => in_array($key, ['error', 'required', 'caption'])) }}>
    @if ($slot->isNotEmpty())
        <x-slot name="label">{{ $slot }}</x-slot>
    @endif

    <textarea {{ 
        $attributes->merge([
            'class' => 'form-input w-full',
            'rows' => 5,
        ])
    }}></textarea>
</x-input.field>