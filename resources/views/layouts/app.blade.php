<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} | TailAdmin - Laravel Tailwind CSS Admin Dashboard Template</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- App Store -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('sidebar', {
                // Initialize based on screen size
                isExpanded: window.innerWidth >= 1280, // true for desktop, false for mobile
                isMobileOpen: false,
                isHovered: false,

                toggleExpanded() {
                    this.isExpanded = !this.isExpanded;
                    // When toggling desktop sidebar, ensure mobile menu is closed
                    this.isMobileOpen = false;
                },

                toggleMobileOpen() {
                    this.isMobileOpen = !this.isMobileOpen;
                    // Don't modify isExpanded when toggling mobile menu
                },

                setMobileOpen(val) {
                    this.isMobileOpen = val;
                },

                setHovered(val) {
                    // Only allow hover effects on desktop when sidebar is collapsed
                    if (window.innerWidth >= 1280 && !this.isExpanded) {
                        this.isHovered = val;
                    }
                }
            });
        });
    </script>

    <!-- Force light mode. Dark mode is intentionally disabled. -->
    <script>
        (function() {
            localStorage.removeItem('theme');
            document.documentElement.classList.remove('dark');
            document.documentElement.style.colorScheme = 'light';
        })();
    </script>
    
</head>

<body
    x-data="{ 'loaded': true}"
    x-init="$store.sidebar.isExpanded = window.innerWidth >= 1280;
    const checkMobile = () => {
        if (window.innerWidth < 1280) {
            $store.sidebar.setMobileOpen(false);
            $store.sidebar.isExpanded = false;
        } else {
            $store.sidebar.isMobileOpen = false;
            $store.sidebar.isExpanded = true;
        }
    };
    window.addEventListener('resize', checkMobile);">

    {{-- preloader --}}
    <x-common.preloader/>
    {{-- preloader end --}}

    <div class="min-h-screen bg-slate-50 xl:flex">
        @include('layouts.backdrop')
        @include('layouts.sidebar')

        <div class="flex-1 transition-all duration-300 ease-in-out"
            :class="{
                'xl:ml-[290px]': $store.sidebar.isExpanded || $store.sidebar.isHovered,
                'xl:ml-[90px]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered,
                'ml-0': $store.sidebar.isMobileOpen
            }">
            <!-- app header start -->
            @include('layouts.app-header')
            <!-- app header end -->
            <main class="app-main mx-auto w-full max-w-(--breakpoint-2xl) px-3 py-4 sm:px-4 md:px-6 lg:px-8">
                @yield('content')
            </main>
        </div>

    </div>

    @if (session('success'))
    <div 
     x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition
        class="fixed right-5 top-5 z-50 flex items-center gap-3
           rounded-lg bg-green-600 px-5 py-3 text-white shadow-lg"
>
    <!-- icon -->
    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
         viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
    </svg>

    <span class="text-sm font-medium">
        {{ session('success') }}
    </span>
    
    </div>
    @endif

</body>

@stack('scripts')

</html>
