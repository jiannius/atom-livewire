<?php

namespace Jiannius\Atom\Components\Input;

use Illuminate\View\Component;

class State extends Component
{
    public $country;

    /**
     * Contructor
     * 
     * @return void
     */
    public function __construct($country = null)
    {
        $this->country = $country;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('atom::components.input.state');
    }
}