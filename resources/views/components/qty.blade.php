@php
$readonly = $attributes->get('readonly', false);
$disabled = $attributes->get('disabled', false);
$placeholder = $attributes->get('placeholder', 'app.label.qty');
$wiremodel = $attributes->wire('model')->value();
@endphp

<x-input {{ $attributes }}>
    <span
        x-data="{
            value: @if ($wiremodel) @entangle($wiremodel) @else null @endif,
            readonly: @js($readonly),

            get min () {
                return +this.$refs.number.getAttribute('min')
            },

            get max () {
                return +this.$refs.number.getAttribute('max')
            },

            get step () {
                return +this.$refs.number.getAttribute('step')
            },

            init () {
                this.$nextTick(() => this.validate())
                this.$watch('value', (value, old) => { if (value !== old) this.validate() })
            },

            spin (action) {
                if (action === 'up') this.$refs.number.stepUp()
                if (action === 'down') this.$refs.number.stepDown()
                this.$refs.number.focus()
                this.$refs.number.select()
                this.$refs.number.dispatchEvent(new Event('input', { bubbles: true }))
            },

            validate () {
                if (this.value === null) {
                    this.value = this.min
                }
                else {
                    this.value = +this.value
                    this.value = this.value.round(this.step.decimalPlaces())
                    if (this.value > this.max) this.value = this.max
                    if (this.value < this.min) this.value = this.min
                }
            },
        }"
        x-modelable="value"
        class="inline-flex items-center h-full"
        {{ $attributes->whereStartsWith('x-') }}>
        @if (!$readonly && !$disabled)
            <button type="button" class="flex py-1.5 px-3" x-on:click.stop="spin('down')">
                <x-icon name="minus" class="m-auto"/>
            </button>
        @endif

        <input type="number"
            @readonly($readonly)
            @disabled($disabled)
            class="grow appearance-none bg-transparent min-w-[4rem] text-center no-spinner"
            placeholder="{!! tr($placeholder) !!}"
            x-ref="number"
            x-model{{ $attributes->modifier() }}="value"
            {{ $attributes->merge([
                'min' => 1,
                'max' => 9999,
                'step' => 1,
            ])->only(['min', 'max', 'step']) }}>

        @if (!$readonly && !$disabled)
            <button type="button" class="flex py-1.5 px-3" x-on:click.stop="spin('up')">
                <x-icon name="plus" class="m-auto"/>
            </button>
        @endif
    </span>
</x-input>