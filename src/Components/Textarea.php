<?php

namespace Jiannius\Atom\Components;

use Illuminate\View\Component;

class Textarea extends Component
{
    public function render()
    {
        return view('atom::components.textarea');
    }
}