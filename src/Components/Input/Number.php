<?php

namespace Jiannius\Atom\Components\Input;

use Illuminate\View\Component;

class Number extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('atom::components.input.number');
    }
}