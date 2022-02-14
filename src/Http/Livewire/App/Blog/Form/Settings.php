<?php

namespace Jiannius\Atom\Http\Livewire\App\Blog\Form;

use Livewire\Component;
use Jiannius\Atom\Models\Label;

class Settings extends Component
{
    public $blog;
    public $status;
    public $labels;
    public $labelOptions;

    protected $rules = [
        'blog.cover_id' => 'nullable',
        'blog.published_at' => 'nullable',
    ];

    /**
     * Mount event
     * 
     * @return void
     */
    public function mount($blog)
    {
        $this->blog = $blog;
        $this->status = $blog->status ?? 'draft';

        $this->labelOptions = Label::where('type', 'blog-category')
            ->orderBy('name')
            ->get()
            ->map(fn($label) => ['value' => $label->id, 'label' => $label->name]);

        $this->labels = $blog->labels ? $blog->labels->pluck('id')->toArray() : [];
    }

    /**
     * Updated status
     */
    public function updatedStatus()
    {
        if ($this->status === 'published' && !$this->blog->published_at) $this->blog->published_at = today();
        if ($this->status === 'draft') $this->blog->published_at = null;
    }

    /**
     * Save
     */
    public function save()
    {
        $this->resetValidation();
        $this->validate();

        $this->blog->cover_id = $this->blog->cover_id ?: null;
        $this->blog->save();
        $this->blog->labels()->sync($this->labels);

        $this->emitUp('saved');
    }

    /**
     * Render
     */
    public function render()
    {
        return view('atom::app.blog.form.settings');
    }
}