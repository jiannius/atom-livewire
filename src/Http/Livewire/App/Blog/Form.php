<?php

namespace Jiannius\Atom\Http\Livewire\App\Blog;

use Jiannius\Atom\Traits\Livewire\WithFileInput;
use Jiannius\Atom\Traits\Livewire\WithForm;
use Livewire\Component;

class Form extends Component
{
    use WithForm;
    use WithFileInput;

    public $blog;
    public $autosavedAt;

    /**
     * Validation
     */
    protected function validation(): array
    {
        return [
            'blog.title' => [
                'required' => 'Blog title is required.',
                'string' => 'Blog title must be string.',
                'max:255' => 'Blog title too long (Max 255 characters).',
            ],
            'blog.excerpt' => ['nullable'],
            'blog.content' => ['nullable'],
        ];
    }

    /**
     * Updated blog content
     */
    public function updatedBlogContent($val): void
    {
        $this->autosavedAt = null;
        if ($val && ($this->blog->exists || $this->blog->title)) $this->autosave();
    }

    /**
     * Autosave
     */
    public function autosave(): void
    {
        $this->blog->save();
        $this->autosavedAt = now();
    }

    /**
     * Submit
     */
    public function submit(): void
    {
        $this->validateForm();

        $this->blog->save();
        
        $this->emit('submitted', $this->blog->id);
    }

    /**
     * Render
     */
    public function render(): mixed
    {
        return atom_view('app.blog.form');
    }
}