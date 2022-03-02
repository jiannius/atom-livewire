<?php

namespace Jiannius\Atom\Components\Input;

use Illuminate\View\Component;

class Currency extends Component
{
    public $countries;

    /**
     * Constructor
     * 
     * @return void
     */
    public function __construct()
    {
        $this->countries = collect(metadata()->countries())->filter(fn($cn) => !is_null($cn['currency_code']))->values()->all();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('atom::components.input.currency');
    }
}