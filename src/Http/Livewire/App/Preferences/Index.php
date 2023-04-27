<?php

namespace Jiannius\Atom\Http\Livewire\App\Preferences;

use Livewire\Component;

class Index extends Component
{
    public $tab;

    /**
     * Mount
     */
    public function mount()
    {
        if ($this->tab) {
            $tab = tabs($this->tabs, $this->tab);
            if (!$tab || data_get($tab, 'disabled')) abort(404);
    
            $this->tab = data_get($tab, 'slug');
    
            breadcrumbs()->home($this->title);
        }
        else {
            return redirect()->route('app.preferences', [data_get(tabs($this->filteredTabs)->first(), 'slug')]);
        }
    }

    /**
     * Get title propert
     */
    public function getTitleProperty(): string
    {
        return 'Preferences';
    }

    /**
     * Get filtered tabs property
     */
    public function getFilteredTabsProperty(): array
    {
        return collect($this->tabs)
            ->filter(fn($tab) => data_get($tab, 'disabled') !== true)
            ->filter(fn($tab) => data_get($tab, 'hidden') !== true)
            ->values()
            ->map(fn($tab) => ($children = data_get($tab, 'tabs'))
                ? array_merge($tab, [
                    'tabs' => collect($children)
                        ->filter(fn($tab) => data_get($tab, 'disabled') !== true)
                        ->filter(fn($tab) => data_get($tab, 'hidden') !== true)
                        ->values()
                        ->all(),
                ])
                : $tab
            )
            ->all();
    }

    /**
     * Get tabs property
     */
    public function getTabsProperty(): array
    {
        return [
            ['group' => 'General', 'tabs' => [
                ['slug' => 'blog-category', 'label' => 'Blog Categories', 'livewire' => [
                    'name' => 'app.label.listing',
                    'data' => ['type' => 'blog-category'],
                ]],
            ]],
        ];
    }

    /**
     * Render
     */
    public function render(): mixed
    {
        return atom_view('app.preferences');
    }
}