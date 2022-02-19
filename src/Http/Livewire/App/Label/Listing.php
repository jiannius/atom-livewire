<?php

namespace Jiannius\Atom\Http\Livewire\App\Label;

use Livewire\Component;
use Jiannius\Atom\Models\Label;

class Listing extends Component
{
    public $type;

    /**
     * Mount
     */
    public function mount()
    {
        if (!$this->type) return redirect()->route('label.listing', [$this->types[0]]);

        breadcrumb_home('Labels');
    }

    /**
     * Get types property
     */
    public function getTypesProperty()
    {
        return config('atom.features.labels') ?? [];
    }

    /**
     * Get labels property
     */
    public function getLabelsProperty()
    {
        return Label::query()
            ->where('type', $this->type)
            ->orderBy('seq')
            ->orderBy('name');
    }

    /**
     * Updated labels
     */
    public function updatedLabels($labels)
    {
        foreach ($labels as $index => $label) {
            Label::where('id', $label['id'])->update(['seq' => $index + 1]);
        }
    }

    /**
     * Render
     */
    public function render()
    {
        return view('atom::app.label.listing', [
            'types' => $this->types,
            'labels' => $this->labels->get(),
        ]);
    }
}