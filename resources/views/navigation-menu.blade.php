<nav x-data="{ open: false }"
    class="flex items-center justify-between py-3 px-6 border-b border-gray-200 text-2xl shadow-lg">
    <div id="nav-left" class="flex items-center ">
        <a href="{{ route('home') }}" :active="request()->routeIs('home')"
            class="flex items-center font-semibold rounded-tl-3xl">
            <img src="{{ asset('images/TBI_logo.jpg') }}" alt="Icon" class="w-16 h-auto rounded-full">
            <h1 class="h-16 flex items-center text-blue-950 md:flex hidden">&nbsp;TBI-</h1><span
                class="md:flex hidden">Activities</span>
        </a>
        @auth
        <div class="top-menu ml-10 hidden md:flex">
            <div class="flex space-x-4">
                <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                    <span class="text-lg">{{ __('Latest') }}</span>
                </x-nav-link>
            </div>
        </div>
        <div class="top-menu ml-10 hidden md:flex">
            <div class="flex space-x-4">
                <x-nav-link href="{{ route('posts.index') }}" :active="request()->routeIs('posts.index')">
                    <span class="text-lg">{{ __('Other Activities') }}</span>
                </x-nav-link>
            </div>
        </div>
        {{-- <div class="top-menu ml-10 hidden md:flex">
            <div class="flex space-x-4">
                <x-nav-link href="{{ route('events.index') }}" :active="request()->routeIs('events.index')">
                    <span class="text-lg">{{ __('Event') }}</span>
                </x-nav-link>
            </div>
        </div> --}}
        <div class="top-menu ml-10 hidden md:flex">
            <div class="flex space-x-4">
                @can('generate-report', \App\Models\User::class)
                <x-nav-link href="{{ route('posts.report') }}" :active="request()->routeIs('posts.report')">
                    <span class="text-lg">{{ __('Generate Report') }}</span>
                </x-nav-link>
                @endcan
            </div>
        </div>
    </div>
    <div id="nav-right" class="flex items-center md:space-x-6">
        <div class="md:hidden">
            <button @click="open = !open"
                class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-black focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                aria-controls="mobile-menu" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <!-- Icon when menu is closed -->
                <svg x-show="!open" class="block h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
                <!-- Icon when menu is open -->
                <svg x-show="open" class="block h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            @endauth
        </div>
        <div x-show="open && @auth true @else false @endauth" @click.away="open = false" class="md:hidden">
            <!-- Your mobile menu items go here -->
            <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')"
                class="block px-4 py-2 text-gray-500 hover:text-black">Latest</x-nav-link>
            <x-nav-link href="{{ route('posts.index') }}" :active="request()->routeIs('posts.index')"
                class="block px-4 py-2 text-gray-500 hover:text-black">Other Activities</x-nav-link>
            <x-nav-link href="{{ route('posts.report') }}" :active="request()->routeIs('posts.report')"
                class="block px-4 py-2 text-gray-500 hover:text-black">Generate Report</x-nav-link>
        </div>
        @auth()
        @include('layouts.partials.header-right-auth')
        @else
        @include('layouts.partials.header-right-guest')
        @endauth
    </div>
</nav>