@extends('atom::layout')

@section('content')
    <x-popup/>
    <x-loader/>

    <div class="bg-gray-100 p-5 min-h-screen">
        <main class="max-w-screen-lg mx-auto grid gap-6">
            <div>
                <a href="{{ app_route() }}" class="inline-flex items-center gap-1 text-gray-500 font-medium">
                    <x-icon name="left-arrow-alt"/> Back
                </a>
            </div>

            <div>
                {{ $slot }}
            </div>
        </main>
    </div>
@endsection