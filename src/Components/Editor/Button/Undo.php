<?php

namespace Jiannius\Atom\Components\Editor\Button;

use Illuminate\View\Component;

class Undo extends Component
{
    public function render()
    {
        return view('atom::components.editor.button.undo');
    }
}