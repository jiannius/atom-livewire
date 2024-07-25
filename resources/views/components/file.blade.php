@php
$file = $attributes->get('file');
$size = $attributes->size('sm');
@endphp

@if ($size === 'lg')
@else
    <div {{ $attributes->class(['flex items-center gap-3'])->except('file') }}>
        <div class="shrink-0 w-12 h-12 rounded-lg bg-gray-100 border shadow-sm flex items-center justify-center overflow-hidden">
            @if ($file->is_image)
                <img src="{{ $file->endpoint_sm }}" class="w-full h-full object-cover">
            @else
                <div class="shrink-0 text-gray-400 text-xl">
                    <x-icon :name="pick([
                        'music' => $file->type === 'audio',
                        'video' => $file->type === 'video',
                        'file-pdf' => $file->type === 'pdf',
                        'file-word' => $file->type === 'ms-word',
                        'file-excel' => $file->type === 'ms-excel',
                        'file-powerpoint' => $file->type === 'ms-ppt',
                        'file' => true,
                    ])"/>
                </div>
            @endif
        </div>

        <div class="grow grid">
            <div class="font-medium truncate">
                {{ $file->name }}
            </div>

            <div class="text-sm text-gray-500">
                {{ $file->type }}
            </div>
        </div>
    </div>
@endif
