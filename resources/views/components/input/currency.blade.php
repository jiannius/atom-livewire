<x-input.field {{ $attributes->filter(fn($val, $key) => in_array($key, ['error', 'required', 'caption'])) }}>
    <x-slot name="label">
        {{ $slot }}
    </x-slot>

    <select {{ $attributes->class(['form-input w-full disabled:cursor-not-allowed disabled:bg-gray-100']) }}>
        <option value="" selected> -- {{ $attributes->get('placeholder') ?? 'Please Select' }} -- </option>
        @foreach ($countries as $country)
            <option value="{{ $country->currency->code }}">
                {{ $country->currency->code }} - {{ implode(', ', array_filter([$country->name, $country->currency->name])) }}
            </option>
        @endforeach
    </select>
</x-input.field>