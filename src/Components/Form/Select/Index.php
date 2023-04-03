<?php

namespace Jiannius\Atom\Components\Form\Select;

use Illuminate\View\Component;

class Index extends Component
{
    public $options;

    /**
     * Constructor
     */
    public function __construct($options = [])
    {
        $this->options = collect($options)->map(function($opt) {
            if (is_string($opt)) return ['value' => $opt, 'label' => $opt];
            else {
                $value = data_get($opt, 'value') ?? data_get($opt, 'id') ?? data_get($opt, 'code');
                $label = data_get($opt, 'label') ?? data_get($opt, 'name') ?? data_get($opt, 'title') ?? data_get($opt, 'value') ?? data_get($opt, 'id') ?? data_get($opt, 'code');
                $small = data_get($opt, 'small') ?? data_get($opt, 'description') ?? data_get($opt, 'caption');
                $remark = data_get($opt, 'remark');
    
                return [
                    'value' => $value,
                    'label' => $label,
                    'small' => $small,
                    'remark' => $remark,
                    'status' => data_get($opt, 'status'),
                    'is_group' => data_get($opt, 'is_group'),
                    'avatar' => data_get($opt, 'avatar'),
                    'avatar_placeholder' => data_get($opt, 'avatar_placeholder'),
                    'image' => data_get($opt, 'image'),
                    'flag' => data_get($opt, 'flag'),
                    'searchable' => str()->slug(collect([$value, $label, $small, $remark])->filter()->join('-')),
                ];
            }
        })->toArray();
    }

    /**
     * Render
     */
    public function render()
    {
        return view('atom::components.form.select.index');
    }
}