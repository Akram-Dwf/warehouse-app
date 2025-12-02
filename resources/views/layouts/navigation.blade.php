<nav x-data="{ open: false }" class="bg-blue-600 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center mr-6">
                    <a href="{{ route('dashboard') }}" class="text-white font-extrabold text-2xl flex items-center gap-2 tracking-tight hover:opacity-90 transition">
                        <i class="fas fa-boxes text-2xl"></i>
                        <span>INVENTRA</span>
                    </a>
                </div>

                <div class="hidden space-x-2 sm:-my-px sm:flex items-center">
                    @php
                    $navClass = "px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out";
                    $activeClass = "bg-blue-800 text-white shadow-inner";
                    $inactiveClass = "text-blue-100 hover:bg-blue-500 hover:text-white";
                    @endphp

                    <a href="{{ route('dashboard') }}"
                        class="{{ request()->routeIs('dashboard') ? $activeClass : $inactiveClass }} {{ $navClass }}">
                        Dashboard
                    </a>

                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                    <a href="{{ route('categories.index') }}"
                        class="{{ request()->routeIs('categories.*') ? $activeClass : $inactiveClass }} {{ $navClass }}">
                        Kategori
                    </a>
                    <a href="{{ route('products.index') }}"
                        class="{{ request()->routeIs('products.*') ? $activeClass : $inactiveClass }} {{ $navClass }}">
                        Produk
                    </a>
                    @endif

                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'manager' || Auth::user()->role == 'staff')
                    <a href="{{ route('transactions.index') }}"
                        class="{{ request()->routeIs('transactions.*') ? $activeClass : $inactiveClass }} {{ $navClass }}">
                        Transaksi
                    </a>
                    @endif

                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'manager' || Auth::user()->role == 'supplier')
                    <a href="{{ route('restocks.index') }}"
                        class="{{ request()->routeIs('restocks.*') ? $activeClass : $inactiveClass }} {{ $navClass }}">
                        Restock
                    </a>
                    @endif

                    @if(Auth::user()->role == 'admin')
                    <a href="{{ route('users.index') }}"
                        class="{{ request()->routeIs('users.*') ? $activeClass : $inactiveClass }} {{ $navClass }}">
                        Users
                    </a>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white hover:bg-blue-500 focus:outline-none transition ease-in-out duration-150">
                            <div class="flex flex-col items-end leading-tight mr-2">
                                <span class="font-bold">{{ Auth::user()->name }}</span>
                                <span class="text-xs text-blue-200 font-normal">{{ ucfirst(Auth::user()->role) }}</span>
                            </div>

                            <div class="h-8 w-8 rounded-full bg-blue-800 flex items-center justify-center text-xs font-bold border-2 border-blue-400">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <i class="fas fa-user mr-2 text-gray-400"></i> {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt mr-2 text-red-400"></i> {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-blue-100 hover:text-white hover:bg-blue-500 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-blue-800 border-t border-blue-900">
        <div class="pt-2 pb-3 space-y-1 px-2">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-blue-100 hover:bg-blue-700 hover:text-white rounded-md">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
            <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')" class="text-blue-100 hover:bg-blue-700 hover:text-white rounded-md">
                {{ __('Kategori') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')" class="text-blue-100 hover:bg-blue-700 hover:text-white rounded-md">
                {{ __('Produk') }}
            </x-responsive-nav-link>
            @endif

            @if(Auth::user()->role == 'admin' || Auth::user()->role == 'manager' || Auth::user()->role == 'staff')
            <x-responsive-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.*')" class="text-blue-100 hover:bg-blue-700 hover:text-white rounded-md">
                {{ __('Transaksi') }}
            </x-responsive-nav-link>
            @endif

            @if(Auth::user()->role == 'admin' || Auth::user()->role == 'manager' || Auth::user()->role == 'supplier')
            <x-responsive-nav-link :href="route('restocks.index')" :active="request()->routeIs('restocks.*')" class="text-blue-100 hover:bg-blue-700 hover:text-white rounded-md">
                {{ __('Restock') }}
            </x-responsive-nav-link>
            @endif

            @if(Auth::user()->role == 'admin')
            <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')" class="text-blue-100 hover:bg-blue-700 hover:text-white rounded-md">
                {{ __('Users') }}
            </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-4 border-t border-blue-900 bg-blue-900">
            <div class="px-4 flex items-center gap-3">
                <div class="h-10 w-10 rounded-full bg-blue-700 flex items-center justify-center text-white font-bold border border-blue-500">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-blue-300">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1 px-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();" class="text-blue-200 hover:text-white hover:bg-red-600 rounded-md">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>