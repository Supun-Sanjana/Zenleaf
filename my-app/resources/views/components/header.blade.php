<nav class="fixed top-0 w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-emerald-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                    </svg>
                </div>
                <span class="text-xl font-bold text-gray-900">ZenLeaf</span>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex space-x-8">
                <a href="#indoor" class="text-gray-700 hover:text-emerald-600 transition-colors">Indoor</a>
                <a href="#flowering" class="text-gray-700 hover:text-emerald-600 transition-colors">Flowering</a>
                <a href="#miniature" class="text-gray-700 hover:text-emerald-600 transition-colors">Miniature</a>
                <a href="#accessories" class="text-gray-700 hover:text-emerald-600 transition-colors">Plant Care</a>
                <a href="#about" class="text-gray-700 hover:text-emerald-600 transition-colors">About</a>
            </div>

            <!-- Search Bar -->
            <div class="flex items-center space-x-4">
                <div class="relative hidden sm:block">
                    <input type="text" placeholder="Search plants..."
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-full focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <div>
               <a href="{{ auth()->check()
                ? (auth()->user()->type === 'customer' ? route('shop') : route('seller'))
                : route('login') }}" class="...">
                    Login
                </a>


            </div>
        </div>
    </div>
</nav>