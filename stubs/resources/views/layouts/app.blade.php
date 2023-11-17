@extends('atom::layout', [
    'indexing' => current_route('web.*', 'register'),
    'analytics' => current_route('web.*', 'register', 'app.onboarding.completed'),
    'cdn' => [
        'sortable', 
        'chartjs', 
        'clipboard',
        'swiper',
        current_route('app.settings') ? 'ckeditor' : null,
        current_route(
            'web.contact-us',
            'login',
            'register',
            'password.forgot',
        ) ? 'recaptcha' : null,
    ],
])

@section('content')
    {{-- Auth layout --}}
    @route('login', 'register', 'password.*', 'verification.*')
        <div class="min-h-screen relative bg-gray-100 px-4 py-12 md:py-20">
            <div class="max-w-md mx-auto grid gap-10">
                <a class="mx-auto" href="/">
                    <x-logo class="w-40"/>
                </a>
            
                {{ $slot }}
            </div>
        </div>

    {{-- Share layout --}}
    @elseroute('app.share')
        <div class="min-h-screen relative bg-gray-100">
            <main class="max-w-screen-xl mx-auto px-4 py-12">
                {{ $slot }}
            </main>
        </div>

    {{-- Onboarding layout --}}
    @elseroute('app.onboarding', 'app.onboarding.completed')
        <div class="min-h-screen bg-gray-100 p-6">
            {{ $slot }}
        </div>
    
    {{-- App layout --}}
    @elseroute('app.*')
        <x-admin-panel>
            <x-slot:links>
                <x-link href="/" icon="globe" label="atom::layout.go_to_site" class="text-gray-800"/>
            </x-slot:links>

            <x-slot:auth>
                <x-navbar.auth>
                    <x-navbar.dropdown.item label="atom::layout.settings" :href="route('app.settings')"/>
                </x-navbar.auth>
            </x-slot:auth>

            <x-slot:aside>
                <x-admin-panel.aside label="Dashboard" route="app.dashboard"/>                
                <x-admin-panel.aside label="Blogs" route="app.blog.listing"/>
                <x-admin-panel.aside label="Enquiries" route="app.enquiry.listing"/>
                <x-admin-panel.aside label="Sign-Ups" route="app.signup.listing"/>
                <x-admin-panel.aside label="Support Tickets" route="app.ticket.listing"/>
            </x-slot:aside>

            <x-slot:asidefoot>
                <x-admin-panel.aside label="atom::layout.settings" route="app.settings"/>
            </x-slot:asidefoot>

            @route('app.settings') {{ $slot }}
            @else <main class="p-6">{{ $slot }}</main>
            @endroute

            @livewire('app.signup.update', key('signup-update'))
            @livewire('app.settings.file.update', key('file-update'))
            @livewire('app.settings.page.update', key('page-update'))
            @livewire('app.settings.label.update', key('label-update'))
        </x-admin-panel>

    {{-- Web layout --}}
    @else
        <x-navbar>
            <x-slot:body class="justify-end">
                @module('blogs')
                    <x-navbar.item href="/blog" label="Blogs"/>
                @endmodule

                <x-navbar.item href="/contact-us?ref=landing" label="Contact Us"/>
            </x-slot:body>
        </x-navbar>
        
        {{ $slot }}

        <footer>
            <div class="bg-gray-700 px-4 py-10">
                <div class="max-w-screen-xl mx-auto">
                    <x-logo class="w-40 brightness-0 invert"/>
                </div>
            </div>
            <div class="bg-gray-900 p-4">
                <div class="max-w-screen-xl mx-auto flex items-center justify-between">
                    <div class="font-medium text-white text-xs md:text-sm">
                        © {{ date('Y') }} Jiannius. All rights reserved.
                    </div>
                </div>
            </div>
        </footer>
    @endroute
@endsection