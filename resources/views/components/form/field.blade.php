@props([
    'field' => $attributes->get('name') ?? $attributes->wire('model')->value() ?? null,
    'wirekey' => $attributes->get('wire:key') ?? $attributes->wire('model')->value(),
])

<div wire:key="{{ $wirekey }}" 
    {{ $attributes->class(['flex flex-col gap-1'])->only('class') }}>
    @if (isset($label) || component_label($attributes))
        <label class="flex items-center gap-2 font-medium leading-5 text-gray-400 text-sm">
            <span>
                @if (isset($label)) {{ $label }}
                @else {{ str(__(component_label($attributes, '', false)))->upper() }}
                @endif
            </span>

            @if ($tag = $attributes->get('tag'))
                <span class="bg-blue-100 text-blue-500 font-medium text-xs px-1 rounded-md">
                    {{ __($tag) }}
                </span>
            @endif

            @if ($attributes->has('required'))
                @if ($attributes->get('required')) <x-icon name="asterisk" size="10" class="text-red-400"/> @endif
            @elseif ($field)
                <div 
                    x-data="{ required: false }" 
                    x-init="required = ($wire.get('form.required') || [])[@js($field)]"
                    x-show="required" 
                    class="flex"
                >
                    <x-icon name="asterisk" size="10" class="text-red-400 m-auto"/>
                </div>
            @endif
        </label>
    @endif

    <div>
        @if ($slot->isNotEmpty())
            {{ $slot }}
        @elseif ($value = $attributes->get('value'))
            @if ($href = $attributes->get('href'))
                <x-link :label="$value" :href="$href" :target="$attributes->get('target', '_self')"/>
            @else
                {!! $value !!}
            @endif
        @elseif ($href = $attributes->get('href'))
            <x-link :href="$href" :target="$attributes->get('target', '_self')"/>
        @elseif ($badge = $attributes->get('badge'))
            @if (is_string($badge)) <x-badge :label="$badge"/>
            @else
                @foreach ($badge as $key => $val)
                    <x-badge :label="$val" :color="$key"/>
                @endforeach
            @endif
        @elseif ($address = $attributes->get('address'))
            @if (is_string($address)) {{ $address }}
            @else
                <div class="text-sm">
                    @if ($name = data_get($address, 'name')) {{ $name }}<br> @endif
                    @if ($company = data_get($address, 'company')) {{ $company }}<br> @endif
                    @if ($address = data_get($address, 'address')) {{ $address }} @endif
                </div>
            @endif
        @endif
    </div>

    @if ($caption = $attributes->get('caption'))
        <div class="text-sm text-gray-700">
            {{ __($caption) }}
        </div>
    @endif

    @if ($error = $errors->first($field))
        <div 
            x-init="$el.parentNode
                .querySelectorAll('.form-input:not(.transparent)')
                .forEach(node => node.classList.add('error'))"
            wire:key="{{ uniqid() }}"
            class="text-sm text-red-500 font-medium">
            {{ __($error) }}
        </div>
    @endif
</div>
