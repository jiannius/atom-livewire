<?php

namespace Jiannius\Atom\Components\Input;

use Illuminate\View\Component;

class Seo extends Component
{
    /**
     * Contructor
     * 
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Render component
     * 
     * @return Response
     */
    public function render()
    {
        return view('atom::components.input.seo');
    }
}