<x-form.drawer id="blog-update" class="max-w-screen-xl w-full" wire:close="close()">
@if ($blog)
    @if ($blog->exists)
        <x-slot:buttons
            :trash="!$blog->trashed()"
            :delete="$blog->trashed()"
            :restore="$blog->trashed()">
            <x-button.submit sm/>
            
            @if ($blog->status === enum('blog.status', 'DRAFT')) <x-button sm icon="upload" label="app.label.publish" wire:click="publish(true)"/>
            @else <x-button sm icon="undo" label="app.label.unpublish" wire:click="publish(false)"/>
            @endif

            <x-button sm icon="eye" label="app.label.preview" :href="route('web.blog', $blog->slug)" target="_blank"/>
        </x-slot:buttons>
    @endif

    <div class="p-5 flex flex-col md:flex-row gap-4">
        <div class="md:w-8/12">
            <x-box>
                <x-form.group>
                    <input type="text" wire:model.defer="blog.name" placeholder="{{ tr('app.label.title') }}" class="transparent text-2xl font-bold">
                </x-form.group>

                <x-form.group>
                    <x-form.text wire:model.defer="blog.description" label="app.label.excerpt"/>
                    <x-form.editor wire:model="blog.content" label="app.label.content"/>
                </x-form.group>

                <x-form.group heading="SEO">
                    <x-form.seo wire:model.defer="inputs.seo"/>
                </x-form.group>
            </x-box>
        </div>

        <div class="md:w-4/12">
            <x-box>
                <x-form.group>
                    <x-form.field label="Status">
                        <x-badge :label="$blog->status->value" :color="$blog->status->color()"/>
                    </x-form.field>

                    @if ($blog->status === enum('blog.status', 'PUBLISHED'))
                        <x-form.date wire:model="blog.published_at" label="app.label.publish-date"/>
                    @endif
        
                    <x-form.select.label wire:model="inputs.labels" type="blog-category" multiple/>
                    <x-form.file wire:model="blog.cover_id" label="app.label.cover-image" accept="image/*"/>
                </x-form.group>
            </x-box>
        </div>
    </div>
@endif
</x-form.drawer>