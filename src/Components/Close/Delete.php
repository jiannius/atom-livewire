<?php

namespace Jiannius\Atom\Components\Close;

use Illuminate\View\Component;

class Delete extends Component
{
    /**
     * Render
     */
    public function render()
    {
        return view('atom::components.close.delete');
    }
}