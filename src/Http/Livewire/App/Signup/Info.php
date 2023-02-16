<?php

namespace Jiannius\Atom\Http\Livewire\App\Signup;

use Livewire\Component;

class Info extends Component
{
    public $user;

    /**
     * Render
     */
    public function render()
    {
        return atom_view('app.signup.info');
    }
}