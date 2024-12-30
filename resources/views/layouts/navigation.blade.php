<nav x-data="{ open: false }" class="bg-gradient-to-r from-pink-100 to-pink-200 border-b border-pink-300 shadow-md">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('articulos.index') }}" class="transform hover:scale-110 transition-transform duration-300">
                        <img width="90px" src="/img/pixelcut-export__1_-removebg-preview.png" alt="Logo">
                    </a>
                </div>
            </div>

            <!-- Brand Name -->
            <div class="hidden sm:flex sm:items-center">
                <h1 class="text-4xl font-bold text-pink-600 font-cursive transition-all duration-300 hover:text-pink-700 hover:scale-110 hover:text-shadow" style="font-family: 'Dancing Script', cursive; text-shadow: 2px 2px 4px rgba(0,0,0,0.1);">
                    Curiosidades Rochi
                </h1>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-6 py-3 border-2 border-pink-300 text-base leading-4 font-medium rounded-full text-pink-600 bg-white hover:bg-pink-50 hover:text-pink-700 hover:border-pink-400 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-pink-300 transition-all duration-300 ease-in-out">
                            <div class="font-semibold">{{ Auth::user()->name }}</div>
                            <div class="ms-2">
                                <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                    class="hover:bg-pink-50 text-pink-600 hover:text-pink-700 text-lg font-medium transition-colors duration-300">
                                {{ __('Cerrar sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-pink-500 hover:text-pink-600 hover:bg-pink-100 hover:shadow-md focus:outline-none focus:bg-pink-100 focus:text-pink-600 transition-all duration-300 ease-in-out">
                    <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                class="text-pink-600 hover:bg-pink-50 text-lg transition-all duration-300 hover:pl-6">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-pink-200 bg-pink-50">
            <div class="px-4">
                <div class="font-medium text-lg text-pink-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-base text-pink-600">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" 
                    class="text-pink-600 hover:bg-pink-100 text-lg transition-all duration-300 hover:pl-6">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();"
                            class="text-pink-600 hover:bg-pink-100 text-lg transition-all duration-300 hover:pl-6">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Add this in your layout's head section -->

<!-- Add this custom CSS to your stylesheet -->
<style>
    .text-shadow {
        text-shadow: 3px 3px 6px rgba(219, 39, 119, 0.2);
    }
    
    /* Optional: Add a subtle animation for the main title */
    @keyframes gentle-bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
    
    .hover\:text-shadow:hover {
        user-select: none;
        animation: gentle-bounce 2s ease-in-out infinite;
    }
</style>