<?php

namespace Jiannius\Atom\Components;

use Illuminate\View\Component;

class FileDropzone extends Component
{
    public function render()
    {
        return view('atom::components.file-dropzone');
    }
}