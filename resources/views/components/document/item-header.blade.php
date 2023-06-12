@props([
    'columns' => $attributes->get('columns') ?? [
        'item', 'qty', 'amount', 'total'
    ],
])

<div {{ $attributes->class([
    'hidden text-gray-500 font-semibold text-sm md:flex md:flex-row',
    $attributes->get('class', 'py-2 px-4'),
]) }}>
    @foreach ($columns as $i => $col)
        @if ($i === array_key_first($columns)) 
            <div class="grow">{{ __(str()->upper($col)) }}</div>
        @elseif ($i === array_key_last($columns))
            <div class="md:w-3/12 text-right">{{ __(str()->upper($col)) }}</div>
        @else
            <div class="md:w-2/12 text-right">{{ __(str()->upper($col)) }}</div>
        @endif
    @endforeach
</div>
