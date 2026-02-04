
<nav class="sticky top-0 z-50 bg-white shadow-lg border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo dentro de la barra de navegación, alineado a la izquierda -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('index') }}" class="flex items-center">
                    <img src="{{ asset('front_end/images/logo.png') }}" alt="Logo" class="h-12 w-auto" />
                    <span class="ml-2 text-2xl font-extrabold tracking-tight text-blue-700">Torre de Batalla</span>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="flex items-center space-x-8">
                <x-nav-link :href="route('index')" :active="request()->routeIs('index')">
                    {{ __('Inicio') }}
                </x-nav-link>
                <x-nav-link :href="route('view_allproducts')" :active="request()->routeIs('view_allproducts')">
                    <svg class="inline w-5 h-5 mr-1 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:middle;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A1 1 0 0 0 6.6 17h10.8a1 1 0 0 0 .95-.68L21 13M7 13V6a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v7" />
                    </svg>
                    {{ __('Tienda') }}
                </x-nav-link>
                @if(auth()->user()->user_type === 'admin')
                    <x-nav-link :href="route('admin.dashboard')">
                        {{ __('Admin') }}
                    </x-nav-link>
                @endif
                <!-- Example: Add more links as needed -->
            </div>

            <!-- Right Side: Cart & User -->
            <div class="flex items-center space-x-6">
                <!-- Cart Icon -->
                <a href="{{ route('cartproducts') }}" class="relative group">
                    <svg class="w-7 h-7 text-gray-700 group-hover:text-blue-600 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A1 1 0 0 0 6.6 17h10.8a1 1 0 0 0 .95-.68L21 13M7 13V6a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v7" />
                    </svg>
                </a>
                <!-- User Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 rounded-full bg-gray-100 hover:bg-blue-100 text-gray-700 font-semibold">
                            <svg class="w-6 h-6 mr-2 text-blue-700" fill="currentColor" viewBox="0 0 20 20"><path d="M10 10a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm0 2c-4 0-7 2-7 4v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-1c0-2-3-4-7-4z" /></svg>
                            {{ Auth::user()->name }}
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Perfil
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Cerrar sesión
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>
