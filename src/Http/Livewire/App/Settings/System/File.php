<?php

namespace Jiannius\Atom\Http\Livewire\App\Settings\System;

use Jiannius\Atom\Traits\Livewire\WithFile;
use Jiannius\Atom\Traits\Livewire\WithPopupNotify;
use Livewire\Component;
use Livewire\WithPagination;

class File extends Component
{
    use WithFile;
    use WithPagination;
    use WithPopupNotify;

    public $selected = [];
    public $sortBy = 'created_at';
    public $sortOrder = 'desc';
    public $filters = [
        'type' => null,
        'search' => null,
    ];

    protected $listeners = ['refresh' => '$refresh'];

    /**
     * Get files property
     */
    public function getFilesProperty()
    {
        return model('file')
            ->when(
                model('file')->enabledBelongsToAccount,
                fn($q) => $q->belongsToAccount(),
            )
            ->filter($this->filters)
            ->orderBy($this->sortBy, $this->sortOrder)
            ->paginate(120);
    }

    /**
     * Updated filters
     */
    public function updatedFilters()
    {
        $this->resetPage();
    }

    /**
     * Select
     */
    public function select($id)
    {
        if ($id === '*') {
            $this->selected = count($this->selected) === count($this->files->items())
                ? []
                : collect($this->files->items())->pluck('id')->toArray();
        }
        else if (in_array($id, $this->selected)) {
            $this->selected = collect($this->selected)->reject(fn($val) => $val === $id)->values()->all();
        }
        else {
            array_push($this->selected, $id);
        }
    }

    /**
     * Edit
     */
    public function edit($id)
    {
        $this->emitTo(lw('app.settings.system.file-form-modal'), 'open', $id);
    }

    /**
     * Delete file
     */
    public function delete()
    {
        if (!$this->selected) return;

        model('file')->whereIn('id', $this->selected)->get()->each(fn($q) => $q->delete());

        $this->popup(count($this->selected).' Files Deleted');
        $this->reset('selected');
    }

    /**
     * Render
     */
    public function render()
    {
        return atom_view('app.settings.system.file');
    }
}