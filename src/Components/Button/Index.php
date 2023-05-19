<?php

namespace Jiannius\Atom\Components\Button;

use Illuminate\View\Component;

class Index extends Component
{
    public $mode;
    public $icon;
    public $size;
    public $label;
    public $block;
    public $color;
    public $renderable;
    public $config;

    /**
     * Contructor
     * 
     * @return void
     */
    public function __construct(
        $icon = null,
        $label = null,
        $size = 'base',
        $color = 'theme',
        $block = false,
        $inverted = false, 
        $outlined = false,
        $hide = null,
        $can = null
    ) {
        $this->renderable = !$hide && (!$can || ($can && user()->can($can)));
        $this->icon = $icon;
        $this->label = $label;
        $this->size = $size;
        $this->color = $color;
        $this->block = $block;

        $this->mode = head(array_filter([
            $inverted ? 'inverted' : null,
            $outlined ? 'outlined' : null,
            !$inverted && !$outlined ? 'normal' : null,
        ]));

        $this->config = $this->getConfig();
    }

    /**
     * Get config
     */
    public function getConfig()
    {
        $color = [
            'theme' => [
                'normal' => 'bg-theme border-2 border-theme text-theme-inverted',
                'inverted' => 'text-theme hover:bg-theme hover:text-theme-inverted hover:border-2 hover:border-theme',
                'outlined' => 'bg-white border-2 border-theme text-theme',
            ],
            'theme-light' => [
                'normal' => 'bg-theme-light border-2 border-theme-light text-theme-inverted-light',
                'inverted' => 'text-theme-light hover:bg-theme-light hover:text-theme-inverted-light hover:border-2 hover:border-theme-light',
                'outlined' => 'bg-white border-2 border-theme-light text-theme-light',
            ],
            'theme-dark' => [
                'normal' => 'bg-theme-dark border-2 border-theme-dark text-theme-inverted-dark',
                'inverted' => 'text-theme-dark hover:bg-theme-dark hover:text-theme-inverted-dark hover:border-2 hover:border-theme-dark',
                'outlined' => 'bg-white border-2 border-theme-dark text-theme-dark',
            ],
            'green' => [
                'normal' => 'bg-green-500 border-2 border-green-500 text-white',
                'inverted' => 'border-2 border-transparent hover:bg-green-100 hover:border-green-100 text-green-500',
                'outlined' => 'bg-white border-2 border-green-500 text-green-500',
            ],
            'red' => [
                'normal' => 'bg-red-500 border-2 border-red-500 text-white',
                'inverted' => 'border-2 border-transparent hover:bg-red-100 hover:border-red-100 text-red-500',
                'outlined' => 'bg-white border-2 border-red-500 text-red-500',
            ],
            'blue' => [
                'normal' => 'bg-blue-500 border-2 border-blue-500 text-white',
                'inverted' => 'border-2 border-transparent hover:bg-blue-100 hover:border-blue-100 text-blue-500',
                'outlined' => 'bg-white border-2 border-blue-500 text-blue-500',
            ],
            'yellow' => [
                'normal' => 'bg-yellow-200 border-2 border-yellow-200 text-orange-700',
                'inverted' => 'border-2 border-transparent hover:bg-yellow-200 hover:border-yellow-200 text-orange-800',
                'outlined' => 'bg-white border-2 border-yellow-600 text-yellow-600',
            ],
            'amber' => [
                'normal' => 'bg-amber-400 border-2 border-amber-400 text-white',
                'inverted' => 'border-2 border-transparent hover:bg-amber-400 hover:border-amber-400 text-amber-400',
                'outlined' => 'bg-white border-2 border-amber-400 text-amber-400',
            ],
            'gray' => [
                'normal' => 'bg-gray-200 border-2 border-gray-200 text-gray-800',
                'inverted' => 'border-2 border-transparent hover:bg-gray-100 hover:border-gray-100 text-gray-800',
                'outlined' => 'bg-white border border-gray-300 text-gray-800',
            ],
            'black' => [
                'normal' => 'bg-black border-2 border-black text-white',
                'inverted' => 'border-2 border-transparent hover:bg-black hover:border-black text-black',
                'outlined' => 'bg-white border-2 border-black text-black',
            ],
        ];

        return json_decode(json_encode([
            'styles' => [
                'size' => [
                    'xs' => 'btn btn-xs',
                    'sm' => 'btn btn-sm',
                    'base' => 'btn btn-base',
                    'md' => 'btn btn-md',
                    'lg' => 'btn btn-lg',
                ][$this->size],

                'color' => $color[$this->color][$this->mode],
            ],
            'icon' => [
                'name' => str($this->icon)->is('*:*')
                    ? last(explode(':', $this->icon))
                    : ($this->icon ?? $this->label),
                'size' => [
                    'xs' => '10',
                    'sm' => '12',
                    'base' => '14',
                    'md' => '18',
                    'lg' => '20',
                ][$this->size],
                'position' => str($this->icon)->is('postfix:*') ? 'right' : 'left',
            ],
        ]));
    }

    /**
     * Render component
     * 
     * @return Response
     */
    public function render()
    {
        return view('atom::components.button.index');
    }
}