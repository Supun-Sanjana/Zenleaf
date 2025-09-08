<nav class="fixed top-0 w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-emerald-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
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


                <div>
                <!-- @php
                $firstLetter = strtoupper(substr(Auth::user()->first_name, 0, 1));
                @endphp

                <div class="w-10 h-10 rounded-full bg-gray-400 flex items-center justify-center text-white font-bold text-lg">
                    {{ $firstLetter }}
                </div> -->

            @php
            $colors = ['bg-red-500', 'bg-blue-500', 'bg-green-500', 'bg-purple-500'];
            $colorClass = $colors[ord(substr(Auth::user()->first_name,0,1)) % count($colors)];
            @endphp

            <div class="w-10 h-10 rounded-full {{ $colorClass }} flex items-center justify-center text-white font-bold text-lg">
                {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}
            </div>


                </div>
            </div>
        </div>
    </nav>