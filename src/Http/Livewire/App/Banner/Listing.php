<?php

namespace Jiannius\Atom\Http\Livewire\App\Banner;

use Illuminate\Database\Eloquent\Builder;
use Jiannius\Atom\Traits\Livewire\WithPopupNotify;
use Jiannius\Atom\Traits\Livewire\WithTable;
use Livewire\Component;

class Listing extends Component
{
    use WithTable;
    use WithPopupNotify;

    public $filters = [
        'search' => null,
    ];

    /**
     * Mount
     */
    public function mount()
    {
        breadcrumbs()->home('Banners');
    }

    /**
     * Get query property
     */
    public function getQueryProperty(): Builder
    {
        return model('banner')->filter($this->filters)->oldest('seq')->latest('id');
    }

    /**
     * Get table columns
     */
    public function getTableColumns($query): array
    {
        return [
            [
                'name' => 'Name',
                'sort' => 'name',
                'label' => $query->name,
                'image' => $query->image->url,
                'href' => route('app.banner.update', [$query->id]),
                'sortable_id' => $query->id,
            ],
            [
                'name' => 'Type',
                'sort' => 'type',
                'label' => $query->type,
            ],
            [
                'name' => 'Status',
                'status' => $query->is_active ? 'active' : 'inactive',
            ],
        ];
    }

    /**
     * Sort
     */
    public function sort($data): void
    {
        foreach ($data as $seq => $id) {
            model('banner')->find($id)->fill(['seq' => $seq])->save();
        }
    }

    /**
     * Delete
     */
    public function delete()
    {
        if ($this->checkboxes) {
            model('banner')->whereIn('id', $this->checkboxes)->delete();
        }
    }

    /**
     * Render
     */
    public function render(): mixed
    {
        return atom_view('app.banner.listing');
    }
}