<?php

namespace Jiannius\Atom\Components\Form\File;

use Illuminate\View\Component;

class Preview extends Component
{
    /**
     * Render
     */
    public function render()
    {
        return view('atom::components.form.file.preview');
    }
}