<?php

namespace Jiannius\Atom\Components\Form;

use Illuminate\View\Component;

class Date extends Component
{
    public function render()
    {
        return view('atom::components.form.date');
    }
}