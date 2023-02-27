<?php

namespace Jiannius\Atom\Http\Livewire\App\User\Update;

use Livewire\Component;

class Index extends Component
{
    public $user;

    /**
     * Mount
     */
    public function mount($userId)
    {
        $this->user = model('user')->readable()->withTrashed()->findOrFail($userId);

        breadcrumbs()->push($this->user->name);
    }

    /**
     * Render
     */
    public function render()
    {
        return atom_view('app.user.update');
    }
}