<?php

namespace Jiannius\Atom\Components\Dropdown;

use Illuminate\View\Component;

class Item extends Component
{
    /**
     * Render
     */
    public function render()
    {
        return view('atom::components.dropdown.item');
    }
}