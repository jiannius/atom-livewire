<x-button
    type="submit"
    c="green"
    :icon="$attributes->get('icon', 'check')"
    :label="$attributes->get('label', 'Save')"
    {{ $attributes->except('c', 'icon', 'label') }}
/>
