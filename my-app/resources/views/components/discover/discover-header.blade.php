<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZenLeaf</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <style>
        .material-symbols-outlined {
            font-variation-settings:
                'FILL' 0,
                'wght' 400,
                'GRAD' 0,
                'opsz' 24;
        }
    </style>
</head>

<body class="bg-gray-50">

    <nav class="fixed top-0 w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

                <!-- Logo + Home -->
                <div class="flex items-center space-x-6">
                    <!-- Logo Icon -->
                    <div class="w-10 h-10 bg-emerald-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                        </svg>
                    </div>

                    <!-- Brand Name + Home -->
                    <div class="flex items-center space-x-4">
                        <span class="text-xl font-bold text-gray-900">ZenLeaf</span>
                        <a href="{{ auth()->check() && trim(auth()->user()->type) === 'seller' ? route('seller') : route('shop') }}"
                            class="text-gray-700 hover:text-emerald-600 transition-colors bg-emerald-100 border border-transparent font-semibold rounded-md py-2 px-4 shadow-sm hover:shadow-md">
                            Home
                        </a>
                    </div>
                </div>

                <!-- Cart + User Avatar -->
                <div class="flex items-center gap-4">
                    <!-- Cart Button -->
                    <a href="{{ route('cart.index') }}">
                        <div
                            class="flex items-center gap-2 cursor-pointer bg-emerald-100 hover:bg-emerald-200 text-emerald-600 font-bold py-2 px-4 rounded-lg transition-all shadow-sm hover:shadow-md">
                            <span class="material-symbols-outlined">
                                shopping_cart
                            </span>
                            <span>Cart</span>
                        </div>
                    </a>

                    <!-- User Avatar Dropdown -->
                    <div class="relative" x-data="{ open: false }">
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
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </nav>

    <div class="h-20"></div> <!-- Spacer for fixed navbar -->
</body>

</html>
