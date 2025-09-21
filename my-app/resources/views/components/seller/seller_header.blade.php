<nav class="fixed top-0 w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-emerald-600 rounded-lg flex items-center justify-center shadow-md">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                    </svg>
                </div>
                <span class="text-xl font-bold text-gray-900">ZenLeaf</span>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center gap-3 ">
                <a href="{{ route('dashboard') }}"
                    class="text-gray-700 hover:text-emerald-600 transition-colors bg-emerald-100 font-semibold rounded-md py-2 px-4 shadow-sm hover:shadow-md">
                    Dashboard
                </a>
                <a href="{{ route('discover') }}"
                    class="text-gray-700 hover:text-emerald-600 transition-colors bg-emerald-100 font-semibold rounded-md py-2 px-4 shadow-sm hover:shadow-md">
                    Shop
                </a>
                <a href="{{ route('products.create') }}"
                    class="text-gray-700 hover:text-emerald-600 transition-colors bg-emerald-100 font-semibold rounded-md py-2 px-4 shadow-sm hover:shadow-md">
                    Add Product
                </a>
                <button
                    class="text-gray-700 hover:text-emerald-600 transition-colors bg-emerald-100 font-semibold rounded-md py-2 px-4 shadow-sm hover:shadow-md">
                    Submit BR
                </button>
            </div>

            <!-- Avatar Dropdown -->
            <div class="relative ml-4" x-data="{ open: false }">
                @php
                    $colors = ['bg-red-500', 'bg-blue-500', 'bg-green-500', 'bg-purple-500'];
                    $colorClass = $colors[ord(substr(Auth::user()->first_name, 0, 1)) % count($colors)];
                @endphp

                <button @click="open = !open"
                    class="w-10 h-10 rounded-full {{ $colorClass }} flex items-center justify-center text-white font-bold text-lg shadow-md hover:shadow-lg transition">
                    {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}
                </button>

                <div x-show="open" @click.away="open = false"
                    class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg overflow-hidden border ring-1 ring-gray-200"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Mobile Hamburger Menu -->
            <div class="md:hidden ml-3" x-data="{ open: false }">
                <button @click="open = !open" class="text-gray-700 hover:text-emerald-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <!-- Mobile Menu -->
                <div x-show="open" @click.away="open = false"
                    class="absolute right-4 top-16 bg-white w-48 rounded-lg shadow-lg border flex flex-col py-2"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95">
                    <a href="{{ route('dashboard') }}"
                        class="px-4 py-2 hover:bg-emerald-100 rounded-md">Dashboard</a>
                    <a href="{{ route('discover') }}"
                        class="px-4 py-2 hover:bg-emerald-100 rounded-md">Shop</a>
                    <a href="{{ route('products.create') }}"
                        class="px-4 py-2 hover:bg-emerald-100 rounded-md">Add Product</a>
                    <button class="px-4 py-2 hover:bg-emerald-100 rounded-md text-left w-full">Submit BR</button>
                </div>
            </div>

        </div>
    </div>
</nav>

<div class="h-20"></div> <!-- Spacer for fixed navbar -->
