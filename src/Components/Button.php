<?php

namespace Jiannius\Atom\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public $size;
    public $color;
    public $styles;
    public $inverted;
    public $outlined;

    /**
     * Contructor
     * 
     * @return void
     */
    public function __construct($color = 'theme', $size = 'sm', $inverted = false, $outlined = false)
    {
        $this->size = $size;
        $this->color = $color;
        $this->inverted = $inverted;
        $this->outlined = $outlined;
        $this->styles = $this->getStyles();
    }

    /**
     * Render component
     * 
     * @return Response
     */
    public function render()
    {
        return view('atom::components.button');
    }

    /**
     * Get the button styles
     * 
     * @return string
     */
    public function getStyles()
    {
        $styles = ['btn'];

        if ($this->size === 'sm') array_push($styles, 'btn-sm');
        else if ($this->size === 'md') array_push($styles, 'btn-md');
        else if ($this->size === 'lg') array_push($styles, 'btn-lg');

        if ($this->inverted) {
            if ($this->color === 'theme') array_push($styles, 'border-2 border-transparent hover:bg-theme-light hover:border-bg-theme-light text-theme');
            else if ($this->color === 'green') array_push($styles, 'border-2 border-transparent hover:bg-green-100 hover:border-bg-green-100 text-green-500');
            else if ($this->color === 'red') array_push($styles, 'border-2 border-transparent hover:bg-red-100 hover:border-bg-red-100 text-red-500');
            else if ($this->color === 'blue') array_push($styles, 'border-2 border-transparent hover:bg-blue-100 hover:border-bg-blue-100 text-blue-500');
            else if ($this->color === 'gray') array_push($styles, 'border-2 border-transparent hover:bg-gray-100 hover:border-bg-gray-100 text-gray-800');
        }
        else if ($this->outlined) {
            if ($this->color === 'theme') array_push($styles, 'bg-white border-2 border-theme text-theme');
            else if ($this->color === 'green') array_push($styles, 'bg-white border-2 border-green-500 text-green-500');
            else if ($this->color === 'red') array_push($styles, 'bg-white border-2 border-red-500 text-red-500');
            else if ($this->color === 'blue') array_push($styles, 'bg-white border-2 border-blue-500 text-blue-500');
            else if ($this->color === 'gray') array_push($styles, 'bg-white border-2 border-gray-800 text-gray-800');
        }
        else {
            if ($this->color === 'theme') array_push($styles, 'bg-theme border-2 border-theme text-white');
            else if ($this->color === 'green') array_push($styles, 'bg-green-500 border-2 border-green-500 text-white');
            else if ($this->color === 'red') array_push($styles, 'bg-red-500 border-2 border-red-500 text-white');
            else if ($this->color === 'blue') array_push($styles, 'bg-blue-500 border-2 border-blue-500 text-white');
            else if ($this->color === 'gray') array_push($styles, 'bg-gray-200 border-2 border-gray-200 text-gray-800');
        }

        return implode(' ', $styles);
    }
}