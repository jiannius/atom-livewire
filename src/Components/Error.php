<?php

namespace Jiannius\Atom\Components;

use Illuminate\View\Component;

class Error extends Component
{
    public function render()
    {
        return view('atom::components.error');
    }
}