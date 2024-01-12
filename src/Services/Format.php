<?php

namespace Jiannius\Atom\Services;

class Format
{
    // constructor
    public function __construct(
        public $value,
        public $options = null,
    ) {
        //
    }

    // to string
    public function __toString()
    {
        return $this->value('');
    }

    // shorthand for value
    public function val($default = null) : mixed
    {
        return $this->value($default);
    }

    // get value
    public function value($default = null) : mixed
    {
        return $this->date()
            ?? $this->excerpt()
            ?? $this->value
            ?? $default;
    }

    // format date
    public function date() : mixed
    {
        if ($carbon = $this->carbon()) {
            if ($this->options === 'human') return $carbon->diffForHumans();
            if ($this->options === 'datetime') return $carbon->format('d M Y g:iA');
            if ($this->options === 'datetime-24') return $carbon->format('d M Y H:i:s');
            if ($this->options === 'time') return $carbon->format('g:i A');
            if ($this->options === 'time-24') return $carbon->format('H:i:s');
            if ($this->options) return $carbon->format($this->options);

            return $carbon->format('d M Y');
        }

        return null;
    }

    // carbon
    public function carbon() : mixed
    {
        if ($this->value instanceof \Carbon\Carbon) return $this->value;
        if (validator(['value' => $this->value], ['value' => 'date'])->fails()) return null;

        $carbon = \Carbon\Carbon::parse($this->value);

        if ($tz = user('pref.timezone') ?? config('atom.timezone')) $carbon->timezone($tz);

        return $carbon;
    }

    // excerpt
    public function excerpt($len = 80) : mixed
    {
        if (!is_string($this->value)) return null;

        return str(strip_tags($this->value))->words($len);
    }
}