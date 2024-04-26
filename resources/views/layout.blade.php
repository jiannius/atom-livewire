<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->currentLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<x-html-meta :noindex="isset($indexing) ? !$indexing : true"/>

@if ($favicon = collect(['ico', 'png', 'svg', 'jpg'])
    ->filter(fn($ext) => file_exists(storage_path('app/public/img/favicon.'.$ext)))
    ->map(fn($ext) => url('/storage/img/favicon.'.$ext))
    ->first())
<link rel="shortcut icon" href="{{ $favicon }}">
@endif

@if ($enabledAnalytics = $analytics ?? false)
<x-analytics.fathom/>
<x-analytics.gtm/>
<x-analytics.ga/>
<x-analytics.fbpixel/>
@endif

<x-cdn-scripts :libs="array_filter($cdn ?? [])"/>

@stack('assets')
<script src="{{ basset('https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/js/all.min.js') }}"></script>
<link href="{{ basset('https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/css/fontawesome.min.css') }}">
<script src="{{ basset('https://cdn.jsdelivr.net/npm/@floating-ui/core@1.6.0/dist/floating-ui.core.umd.min.js') }}"></script>
<script src="{{ basset('https://cdn.jsdelivr.net/npm/@floating-ui/dom@1.6.3/dist/floating-ui.dom.umd.min.js') }}"></script>

@section('gfont')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family={{ str(app()->currentLocale())->is('zh*') ? 'Noto+Sans+SC' : 'Inter' }}:wght@100;300;400;500;700;900&display=swap">
@show

@vite($vite ?? [
    'resources/css/app.css',
    'resources/js/app.js',
])

@stack('alpine')
<script src="{{ basset('https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.13.10/dist/cdn.min.js') }}" defer></script>
<script src="{{ basset('https://cdn.jsdelivr.net/npm/alpinejs@3.13.10/dist/cdn.min.js') }}" defer></script>

@livewireScripts
@livewireStyles

@stack('scripts')
</head>

<body class="font-{{ $fontTheme ?? 'sans' }} antialiased {{ $class ?? '' }}">
@stack('noscripts')

@if ($enabled = $analytics ?? false)
    <x-analytics.gtm noscript/>
    <x-analytics.fbpixel noscript/>
@endif

<x-notify.alert/>
<x-notify.confirm/>
<x-notify.toast/>
<x-loader/>

@yield('content')
</body>
</html>