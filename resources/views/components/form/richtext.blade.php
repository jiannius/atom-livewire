<x-form.field {{ $attributes->only(['error', 'required', 'caption']) }}>
    @if ($label = $attributes->get('label'))
        <x-slot:label>{{ $label }}</x-slot:label>
    @endif

    <div 
        wire:ignore 
        x-data="{
            uid: @js($uid),
            file: false,
            value: @js($attributes->get('value')) || @entangle($attributes->wire('model')),
            loading: false,
            toolbar: @js($toolbar),
            placeholder: @js($attributes->get('placeholder') ?? __('Your content...')),

            init () {
                ClassicEditor
                .create(this.$refs.ckeditor, { placeholder: this.placeholder, toolbar: this.toolbar })
                .then(editor => {
                    // initial content
                    if (this.value) editor.setData(this.value)

                    // onchange update
                    editor.model.document.on('change:data', () => {
                        this.value = editor.getData()
                        this.$nextTick(() => this.$refs.input.dispatchEvent(new Event('input', { bubble: true })))
                    })
                    
                    // insert media
                    editor.ui.view.toolbar.on('insert-media:click', () => {
                        this.$dispatch(`${this.uid}-uploader-open`)

                        const insert = (event) => {
                            const files = event.detail

                            files.forEach(file => {
                                if (file.is_image) {
                                    editor.model.change(writer => {
                                        const imageElement = writer.createElement('imageBlock', { src: file.url })
                                        editor.model.insertContent(imageElement, editor.model.document.selection);
                                    })
                                }
                                else if (file.is_video) {
                                    const html = `{{ '<video controls class="w-full min-h-[300px]"><source src="${file.url}" type="${file.mime}"></video>' }}`
                                    const viewFragment = editor.data.processor.toView(html)
                                    const modelFragment = editor.data.toModel(viewFragment)

                                    editor.model.insertContent(modelFragment)
                                }
                                else if (file.is_audio) {
                                    const html = `{{ '<audio controls class="w-full"><source src="${file.url}" type="${file.mime}"></audio>' }}`
                                    const viewFragment = editor.data.processor.toView(html)
                                    const modelFragment = editor.data.toModel(viewFragment)

                                    editor.model.insertContent(modelFragment)
                                }
                                else if (file.type === 'youtube') {
                                    editor.execute('mediaEmbed', file.url)
                                }
                            })

                            window.removeEventListener(`${this.uid}-uploader-completed`, insert)
                        }

                        window.addEventListener(`${this.uid}-uploader-completed`, insert)
                    })
                })
            },
        }"
        class="{{ $attributes->get('class') }}"
    >
        <div x-ref="ckeditor" x-show="!loading"></div>

        @livewire('atom.app.file.uploader', [
            'uid' => $uid.'-uploader',
            'title' => 'Insert Media',
            'accept' => ['image', 'video', 'audio', 'youtube'],
            'sources' => ['device', 'web-image', 'youtube', 'library'],
        ], key($uid.'-uploader'))
    </div>
</x-form.field>
