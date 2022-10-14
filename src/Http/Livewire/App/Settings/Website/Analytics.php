<?php

namespace Jiannius\Atom\Http\Livewire\App\Settings\Website;

use Jiannius\Atom\Traits\Livewire\WithPopupNotify;
use Livewire\Component;

class Analytics extends Component
{
    use WithPopupNotify;

    public $settings;

    /**
     * Mount
     */
    public function mount()
    {
        model('site_setting')->group('analytics')->get()->each(function($setting) {
            $this->settings[$setting->name] = $setting->value;
        });
    }

    /**
     * Submit
     */
    public function submit()
    {
        site_settings($this->settings);
        $this->popup('Website Analytics Updated.');
    }

    /**
     * Render
     */
    public function render()
    {
        return atom_view('app.settings.website.analytics');
    }
}