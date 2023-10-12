@php
    $files = $attributes->get('files');
    $accept = $attributes->get('accept');
    $multiple = $attributes->get('multiple');
    $sortable = $attributes->get('sortable');
    $model = $attributes->wire('model')->value();
    $value = data_get($this, $model);
    $files = $value ? model('file')->whereIn('id', (array) $value)->get() : null;
@endphp

@if ($files && $files->count())
    <div wire:key="file-input-listing"
        x-data="{
            value: @entangle($model),
            multiple: @js($multiple),
            sortable: @js($sortable),
            checkboxes: [],
            init () {
                if (this.sortable) new Sortable(this.$refs.sortable, { onSort: () => this.sorted() })
            },
            select (id) {
                const index = this.checkboxes.indexOf(id)
                if (index > -1) this.checkboxes.splice(index, 1)
                else this.checkboxes.push(id)
            },
            remove (id = null) {
                if (id) {
                    const index = this.value.indexOf(id)
                    this.value.splice(index, 1)
                }
                else if (this.multiple) {
                    this.checkboxes.forEach((id) => this.remove(id))
                    this.checkboxes = []
                }
                else this.value = null
            },
            sorted () {
                const data = Array.from(this.$refs.sortable.children)
                    .map(child => (child.getAttribute('data-sortable-id')))
                this.$dispatch('sorted', data)
            }
        }"
        class="flex flex-col divide-y">
        <div x-show="checkboxes.length" class="p-3 flex items-center gap-2 flex-wrap">
            <div class="grow flex items-center gap-2">
                <x-button size="sm" color="gray" label="Select All"
                    x-on:click="checkboxes = {{ $files->pluck('id')->toJson() }}"/>

                <x-button size="sm" color="gray" label="Clear"
                    x-on:click="checkboxes = []"/>
            </div>

            <div class="shrink-0">
                <x-button.confirm size="sm" color="red" label="Remove" inverted
                    x-on:click="$dispatch('confirm', {
                        title: '{{ __('atom::form.file.confirm.remove.title') }}',
                        message: '{{ __('atom::form.file.confirm.remove.message') }}',
                        type: 'error',
                        onConfirmed: () => remove(),
                    })"/>
            </div>
        </div>

        @if ($accept === 'image/*')
            <div x-ref="sortable" class="flex items-center gap-4 flex-wrap p-4 bg-white max-h-[400px] overflow-auto">
                @foreach ($files as $file)
                    <div class="rounded-lg" data-sortable-id="{{ $file->id }}">
                        <x-thumbnail :file="$file" wire:click="$emit('updateFile', {{ $file->id }})">
                            <x-slot:buttons>
                                @if ($multiple)
                                    <div 
                                        x-on:click.stop="select(@js($file->id))"
                                        x-bind:class="checkboxes.includes(@js($file->id)) ? 'text-green-500' : 'text-white'" 
                                        class="cursor-pointer">
                                        <x-icon name="circle-check"/>
                                    </div>
                                @else
                                    <div x-on:click.stop="remove()" class="cursor-pointer text-white">
                                        <x-icon name="remove"/>
                                    </div>
                                @endif
                            </x-slot:buttons>
                        </x-thumbnail>
                    </div>
                @endforeach
            </div>
        @else
            <div x-ref="sortable" class="flex flex-col divide-y bg-white max-h-[400px] overflow-auto">
                @foreach ($files as $file)
                    <div class="p-3 flex items-center gap-3" data-sortable-id="{{ $file->id }}">
                        @if ($multiple)
                            <div x-on:click="select(@js($file->id))" class="shrink-0 cursor-pointer">
                                <div
                                    x-bind:class="checkboxes.includes(@js($file->id)) ? 'border-theme' : 'border-gray-300'"
                                    class="w-4 h-4 p-0.5 border rounded shadow bg-white">
                                    <div x-show="checkboxes.includes(@js($file->id))" class="bg-theme w-full h-full"></div>
                                </div>
                            </div>
                        @endif

                        <figure class="shrink-0 w-6 h-6 rounded-lg bg-white flex items-center justify-center overflow-hidden">
                            @if ($file->is_image) <img src="{{ $file->url }}" class="w-full h-full object-cover">
                            @else <x-icon name="file" class="text-gray-400"/>
                            @endif
                        </figure>

                        <div class="grow truncate cursor-pointer font-medium"
                            wire:click="$emit('updateFile', {{ $file->id }})">
                            {{ $file->name }}
                        </div>

                        @if ($multiple)
                            <div class="shrink-0" x-on:click.stop="$dispatch('confirm', {
                                title: '{{ __('atom::form.file.confirm.remove.title') }}',
                                message: '{{ __('atom::form.file.confirm.remove.message') }}',
                                type: 'error',
                                onConfirmed: () => remove({{ $file->id }}),    
                            })">
                                <x-close color="red"/>
                            </div>
                        @else
                            <div class="shrink-0" x-on:click.stop="remove()">
                                <x-close color="red"/>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endif