<?php

namespace Jiannius\Atom\Components\Form;

use Illuminate\View\Component;

class Email extends Component
{
    public function render()
    {
        return view('atom::components.form.email');
    }
}