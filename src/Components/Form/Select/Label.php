<?php

namespace Jiannius\Atom\Components\Form\Select;

use Illuminate\View\Component;

class Label extends Component
{
    public function render()
    {
        return view('atom::components.form.select.label');
    }
}