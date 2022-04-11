@extends('atom::layout', ['noindex' => true, 'tracking' => false])

@push('scripts')
    <script src="{{ mix('js/web.js') }}" defer></script>
@endpush

@section('content')
    <x-alpine-data/>
    <x-notify/>
    <x-loader/>

    <div class="bg-gray-100 p-5 min-h-screen">
        <main class="max-w-screen-lg mx-auto">
            <x-builder.navbar class="py-2" class.logo="h-[30px]"/>

            <div class="py-6">
                <h1 class="text-2xl font-bold">
                    {{ __('Billing Management') }}
                </h1>
            </div>
            
            {{ $slot }}
        </main>
    </div>
@endsection