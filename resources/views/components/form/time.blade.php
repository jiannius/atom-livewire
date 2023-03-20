@props([
    'placeholder' => $attributes->get('placeholder')
        ? __($attributes->get('placeholder'))
        : __('Select').' '.component_label($attributes, 'Time'),
    'config' => $attributes->get('config', []),
])

<x-form.field {{ $attributes }}>
    <div
        x-data="{
            focus: false,
            picker: null,
            time: null,
            value: @entangle($attributes->wire('model')),
            config: @js($config),
            get placeholder () {
                if (this.time) return formatDate(`1970-01-01 ${this.time}`, 'time')
                else return @js($placeholder)
            },
            init () {
                this.time = this.value
                this.$watch('value', () => this.time = this.value)
            },
            setFocus (bool) {
                this.focus = bool

                if (bool) {
                    this.$nextTick(() => {
                        floatDropdown(this.$refs.anchor, this.$refs.dd)
                        if (!this.time) this.time = '12:00:00'
                        this.setPicker()
                    })
                }
                else {
                    if (this.time !== this.value) this.value = this.time
                    if (this.picker) {
                        this.$nextTick(() => {
                            this.picker.destroy()
                            this.picker = null
                        })
                    }
                }
            },
            clear () {
                this.time = this.value = null
            },
            setPicker () {
                if (!this.picker) {
                    this.picker = flatpickr(this.$refs.timepicker, {
                        inline: true,
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: 'H:i:S',
                        onClose: () => this.setFocus(false),
                        onChange: (selectedDate, dateStr) => this.time = dateStr,
                        ...this.config,
                    })
                }

                this.picker.setDate(this.time)
            }
        }"
        x-on:click.away="setFocus(false)"
        class="relative cursor-pointer"
    >
        <div
            x-ref="anchor" 
            x-on:click="setFocus(true)"
            x-bind:class="{
                'active': focus,
                'select': !time,
            }"
            class="flex items-center gap-2 form-input w-full {{
                component_error(optional($errors), $attributes) ? 'error' : null
            }}"
        >
            <x-icon name="clock" class="shrink-0 text-gray-400"/>
            <div x-text="placeholder" x-bind:class="time ? 'grow' : 'grow text-gray-400'"></div>
            <x-close x-show="time" x-on:click.stop="clear()" class="shrink-0"/>
        </div>

        <div x-ref="dd" x-show="focus" x-transition.opacity class="absolute z-20">
            <div x-ref="timepicker"></div>
        </div>
    </div>
</x-form.field>

