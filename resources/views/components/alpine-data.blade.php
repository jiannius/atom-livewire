<script>
    document.addEventListener('alpine:init', () => {
        @if (in_array('phone-input', $scripts))
            Alpine.data('phoneInput', (value, code = '+60') => ({
                value,
                code,
                flag: null,
                number: null,

                get countries () {
                    return Array.from(this.$refs.dropdown.querySelectorAll('[data-country-code]'))
                        .map(el => ({ 
                            code: el.getAttribute('data-country-code'), 
                            flag: el.getAttribute('data-country-flag'),
                        }))
                },

                get flag () {
                    if (!this.code) return 
                    return this.countries.find(country => (country.code === this.code)).flag
                },

                init () {
                    if (this.value?.startsWith('+')) {
                        const country = this.countries.find(val => (this.value.startsWith(val.code)))

                        if (country) {
                            this.code = country.code
                            this.number = this.value.replace(country.code, '')
                        }
                    }
                    else this.number = this.value || null
                },
                input () {
                    this.value = this.number ? `${this.code}${this.number}` : null
                    this.close()
                },
                open () {
                    this.$refs.dropdown.classList.remove('hidden')

                    floatPositioning(this.$refs.input, this.$refs.dropdown, {
                        placement: 'bottom',
                        flip: true,
                    })
                },
                close () {
                    this.$refs.dropdown.classList.add('hidden')
                },
            }))
        @endif

        @if (in_array('richtext-input', $scripts))
            Alpine.data('richtextInput', (toolbar, placeholder) => ({
                uid: null,
                file: false,
                loading: false,

                init () {
                    this.loading = true
                    ScriptLoader.load('/js/ckeditor5/ckeditor.js')
                        .then(() => this.createEditor())
                        .finally(() => this.loading = false)
                },

                createEditor () {
                    const defaultToolbar = [
                        'heading',
                        '|', 'bold', 'italic', 'fontSize', 'fontColor', 'link', 'bulletedList', 'numberedList',
                        '|', 'alignment', 'outdent', 'indent', 'horizontalLine',
                        '|', 'blockQuote', 'insertMedia', 'insertTable', 'undo', 'redo',
                        '|', 'sourceEditing',
                    ]

                    ClassicEditor.create(this.$refs.ckeditor, {
                        placeholder: placeholder || 'Content goes here',
                        toolbar: toolbar || defaultToolbar,
                    }).then(editor => {
                        // initial content
                        if (this.value) editor.setData(this.value)

                        // onchange update
                        editor.model.document.on('change:data', () => {
                            this.$refs.input.value = editor.getData()
                            this.$refs.input.dispatchEvent(new Event('change'))
                        })
                            
                        // insert media
                        editor.ui.view.toolbar.on('insert-media:click', () => {
                            this.$dispatch(`richtext-uploader-open`)

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
                                        const html = `<video controls class="w-full min-h-[300px]"><source src="${file.url}" type="${file.mime}"></video>`
                                        const viewFragment = editor.data.processor.toView(html)
                                        const modelFragment = editor.data.toModel(viewFragment)

                                        editor.model.insertContent(modelFragment)
                                    }
                                    else if (file.is_audio) {
                                        const html = `<audio controls class="w-full"><source src="${file.url}" type="${file.mime}"></audio>`
                                        const viewFragment = editor.data.processor.toView(html)
                                        const modelFragment = editor.data.toModel(viewFragment)

                                        editor.model.insertContent(modelFragment)
                                    }
                                    else if (file.type === 'youtube') {
                                        editor.execute('mediaEmbed', file.url)
                                    }
                                })

                                window.removeEventListener(`richtext-uploader-completed`, insert)
                            }

                            window.addEventListener(`richtext-uploader-completed`, insert)
                        })
                    })
                },
            }))
        @endif
    })
</script>