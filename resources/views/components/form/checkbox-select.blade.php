<x-form.field {{ $attributes->only(['error', 'required', 'caption']) }}>
    @if ($label = $attributes->get('label'))
        <x-slot:label>{{ $label }}</x-slot:label>
    @endif

    <div 
        x-data="{
            value: @js($attributes->get('value')) || @entangle($attributes->wire('model')),
        }"
        class="{{ $attributes->get('class', 'grid gap-2 md:grid-cols-3') }}"
    >
        @foreach ($attributes->get('options') as $opt)
            <div
                id="checkbox-select-{{ data_get($opt, 'value') }}"
                x-data="{
                    get selected() {
                        return this.value === @js(__(data_get($opt, 'value')))
                    },
                }"
                x-on:click="value = @js(data_get($opt, 'value'))"
                x-bind:class="!selected && 'opacity-60 cursor-pointer'"
                class="bg-white border shadow rounded-lg p-4 flex flex-col gap-1"
            >
                <div class="flex items-center gap-2">
                    <x-icon x-show="!selected" name="circle-check" size="16px" class="text-gray-400"/>
                    <x-icon x-show="selected" name="circle-check" size="16px" class="text-green-500"/>
                    <div class="font-semibold">
                        {{ __(data_get($opt, 'label')) }}
                    </div>
                </div>

                @if ($desc = data_get($opt, 'description'))
                    <div class="text-sm text-gray-500 font-medium">
                        {{ __($desc) }}
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</x-form.field>