<?php

namespace Jiannius\Atom\Components\Form\File;

use Illuminate\View\Component;

class Uploader extends Component
{
    public function render()
    {
        return view('atom::components.form.file.uploader');
    }

}