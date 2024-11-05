<?php

namespace Jiannius\Atom\Services;

class Color
{
    public $input;
    public $options;
    public $variation;

    // contructor
    public function __construct($input = null)
    {
        $this->input = $input ? str($input)->lower()->toString() : null;
        $this->options = collect(json_decode(file_get_contents(atom_path('resources/json/colors.json')), true));
    }

    // to string
    public function __toString() : string
    {
        return $this->value() ?? '';
    }

    // set variation to inverted
    public function inverted() : mixed
    {
        $this->variation = 'inverted';
        
        return $this;
    }

    // set variation to light
    public function light() : mixed
    {
        $this->variation = 'light';

        return $this;
    }

    // set variation to dark
    public function dark() : mixed
    {
        $this->variation = 'dark';

        return $this;
    }

    // check input is hex
    public function isHex() : bool
    {
        $validator = validator(['color' => $this->input], ['color' => 'hex_color']);

        return $validator->passes();
    }

    // get value
    public function value() : mixed
    {
        if (!$this->isHex()) $this->convertInputToHex();
        if ($this->isHex() && $this->variation) return $this->getVariationValue();

        return $this->input;
    }

    // get value from position
    public function pos($pos) : mixed
    {
        return data_get($this->options, $this->input.'.'.$pos);
    }

    // get all options
    public function all() : array
    {
        return $this->options->collapse()->values()->all();
    }

    public function minimal()
    {
        $options = $this->options;

        return $options->keys()->map(fn ($key) => get($options->get($key), 5))->filter();
    }

    // convert input to hex
    public function convertInputToHex() : void
    {
        if ($this->input === 'black') $this->input = '#000000';
        if ($this->input === 'white') $this->input = '#ffffff';
        if (in_array($this->input, ['gray', 'zinc', 'neutral'])) $this->input = 'slate';

        if ($hex = data_get($this->options, $this->input.'.4')) $this->input = $hex;
    }

    // get variation value
    public function getVariationValue() : mixed
    {
        if ($group = $this->options->where(fn($val) => in_array($this->input, $val))->first()) {
            $len = count($group);
            $pos = collect($group)->search($this->input);

            if ($this->variation === 'inverted') {
                if ($this->input === '#000000') return '#ffffff';
                elseif ($this->input === '#ffffff') return '#000000';
                else {
                    if ($pos <= 3) return '#ffffff';

                    $pos = $pos - 4;

                    if ($pos < 0) $pos = 0;

                    return $group[$pos];
                }
            }
            elseif ($this->variation === 'light') {
                if ($pos <= 3) return $this->input;
    
                return $group[$pos - 2];
            }
            elseif ($this->variation === 'dark') {
                $pos = $pos + 4;
                
                if ($pos > $len - 1) $pos = $len - 1;
                
                return $group[$pos];
            }
        }

        return null;
    }
}