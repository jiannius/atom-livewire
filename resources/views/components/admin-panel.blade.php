{{-- aside item --}}
@if ($attributes->has('aside'))
    @if (
        ($attributes->has('can') && auth()->user() && auth()->user()->can($attributes->get('can')))
        || !$attributes->has('can')
    )
        @if ($href || ($route && Route::has($route)))
            <a href="{{ $href ?: route($route, $params) }}" class="pl-2" {{ $isActive ? 'data-active' : '' }}>
                <div
                    class="
                        flex items-center gap-2 rounded-l-md px-4 py-2.5 text-white
                        {{ $isActive ? 'font-semibold bg-white/20 border-r-8 border-theme' : 'font-medium hover:bg-white/10' }}
                    "
                >
                    @if ($attributes->get('icon'))
                        <x-icon name="{{ $attributes->get('icon') }}" type="{{ $attributes->get('icon-type') ?? 'regular' }}" size="20px"/>
                    @endif

                    <div class="truncate">{{ $slot }}</div>
                </div>
            </a>
        @elseif (!$href && !$route)
            <div
                x-data="{ active: false, open: false }"
                x-init="active = $refs.subitems.querySelectorAll('[data-active]').length > 0"
            >
                <div x-on:click="open = true" class="cursor-pointer pl-2">
                    <div
                        x-bind:class="active && 'bg-white/10'"
                        class="flex items-center gap-2 rounded-l-md px-4 py-2.5 text-white"
                    >
                        @if ($attributes->get('icon'))
                            <x-icon name="{{ $attributes->get('icon') }}" type="{{ $attributes->get('icon-type') ?? 'regular' }}" size="20px"/>
                        @endif

                        <div class="flex-grow truncate">{{ $slot }}</div>
                        <x-icon name="chevron-down"/>
                    </div>
                </div>

                @if (isset($subitems) && $subitems->isNotEmpty())
                    <div
                        x-ref="subitems"
                        x-show="active || open"
                        x-on:click.away="open = false" 
                        class="bg-gray-900 text-gray-300 grid py-1.5 pl-4"
                    >
                        {{ $subitems }}
                    </div>
                @endif
            </div>
        @endif
    @endif

{{-- admin panel --}}
@else
    <x-notify.alert/>
    <x-notify.toast/>
    <x-notify.confirm/>
    <x-fullscreen-loader/>

    <div 
        class="min-h-screen bg-gray-50 text-sm" 
        x-data="{ toggled: false, animate: false }"
        @if ($flash)
            x-init="$dispatch('toast', { message: '{{ $flash->message }}', type: '{{ $flash->type }}' })"
        @endif
    >
        <div
            x-ref="void"
            class="opacity-0"
            :class="{
                'transition-0 duration-100 ease-in-out': animate,
                'fixed inset-0 z-20 bg-black opacity-80 lg:hidden': toggled,
            }"
            @click="toggled = false"
        >
        </div>

        <aside 
            x-ref="aside"
            class="fixed left-0 top-0 bottom-0 z-20 overflow-hidden bg-gray-800"
            :class="{
                'transition-0 duration-100 ease-in-out': animate,
                'w-56 lg:w-0': toggled,
                'w-0 lg:w-56': !toggled,
            }"
        >
            <div class="flex flex-col h-full">
                <div class="flex-shrink-0 py-3 px-5">
                    @isset($brand)
                        {{ $brand }}
                    @else    
                        <a href="{{ route('app.dashboard') }}" class="flex-shrink-0 flex items-center gap-2">
                            <div class="w-8 h-8">
                                <x-atom-logo small/>
                            </div>
                            <div class="text-white text-lg tracking-wider">
                                <span class="font-bold">Atom</span><span class="font-light">CMS</span>
                            </div>
                        </a>
                    @endisset
                </div>

                <div class="flex-grow overflow-y-auto overflow-x-hidden">
                    <div class="text-xs text-gray-500 py-2 px-6">
                        NAVIGATION
                    </div>

                    <div class="grid pb-10">
                        {{ $aside }}
                    </div>
                </div>
            </div>
        </aside>

        <main
            x-ref="container"
            class="w-full"
            :class="{
                'transition-0 duration-100 ease-in-out': animate,
                'lg:pl-0': toggled,
                'lg:pl-56': !toggled,
            }"
        >
            <x-builder.navbar class="bg-white py-2 px-4 shadow" breadcrumbs>
                <x-slot name="logo">
                    <div class="flex items-center gap-2">
                        <div class="h-[40px] md:hidden">
                            <x-atom-logo small/>
                        </div>

                        <a class="flex-shrink-0 text-gray-800 flex items-center justify-center" @click="toggled = !toggled; animate = true">
                            <x-icon name="dots-vertical"/>
                        </a>
                    </div>
                </x-slot>

                {{ $links }}
            </x-builder.navbar>

            <x-breadcrumbs class="bg-white py-1 px-4 shadow"/>
        
            @if ($unverified)
                <div class="py-3 px-4 bg-yellow-100 shadow" x-data>
                    <div class="md:flex md:items-center md:space-x-2">
                        <x-icon name="error" class="flex-shrink-0 text-yellow-400"/>
                        <div class="flex-grow font-medium text-yellow-600">
                            We have sent a verification link to <span class="font-semibold">{{ request()->user()->email }}</span>, please click on the link to verify it.
                        </div>
                    </div>
                    <a href="{{ route('verification.send') }}" class="text-xs md:ml-8">
                        Resend verification link
                    </a>
                </div> 
            @endif

            <div class="px-5 pt-5 pb-20 md:px-8 md:pt-8">
                {{ $slot }}
            </div>
        </main>
    </div>
@endif
