<?php

namespace Jiannius\Atom\Http\Livewire\App\Role;

use Livewire\Component;

class Create extends Component
{
    public $role;

    protected $listeners = ['saved'];

    /**
     * Mount
     */
    public function mount()
    {
        breadcrumb('Create Role');
        $this->role = model('role');
    }

    /**
     * Saved
     */
    public function saved($id)
    {
        return redirect()->route('role.update', [$id]);
    }

    /**
     * Render
     */
    public function render()
    {
        return view('atom::app.role.create');
    }
}