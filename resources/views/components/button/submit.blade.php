<x-button
    :icon="$attributes->get('icon', 'check')"
    :color="$attributes->get('color', 'green')"
    :label="$attributes->get('label', 'Save')"
    {{ 
        $attributes->merge([
            'type' => 'submit',
        ])->except(['icon', 'color', 'label'])
    }}
/>
