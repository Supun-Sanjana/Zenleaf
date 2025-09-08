<x-guest-layout>
    <div class="bg-white rounded-2xl  w-full max-w-md overflow-hidden transition-all duration-300 ">

        <!-- Header -->
        <div class="bg-gradient-to-r from-[#00a8a3] to-[#8582f4] px-8 py-10 text-center">
            <h1 class="text-2xl font-bold text-white mb-2">Create Your Account</h1>
            <p class="text-[#a0f0ed] text-sm">Join ZenLeaf today and get started</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('register') }}" class="p-8 space-y-6">
            @csrf

            <!-- First Name -->
            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus autocomplete="first_name"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#00a8a3] focus:border-transparent transition-all duration-200"
                    placeholder="John Doe">
                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
            </div>

             <!-- Last Name -->
            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required autofocus autocomplete="last_name"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#00a8a3] focus:border-transparent transition-all duration-200"
                    placeholder="John Doe">
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#00a8a3] focus:border-transparent transition-all duration-200"
                    placeholder="you@example.com">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Role Selection -->
            <div class="mt-4">
                <x-input-label for="role" :value="__('Register As')" />
                <div class="flex items-center gap-6 mt-2">
                    <label class="flex items-center">
                        <input type="radio" name="type" value="customer" class="text-indigo-600 focus:ring-indigo-500 border-gray-300" checked>
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Customer</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="type" value="seller" class="text-indigo-600 focus:ring-indigo-500 border-gray-300">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Seller</span>
                    </label>
                </div>
                <x-input-error :messages="$errors->get('type')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#00a8a3] focus:border-transparent transition-all duration-200"
                    placeholder="••••••••">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#00a8a3] focus:border-transparent transition-all duration-200"
                    placeholder="••••••••">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-between">
                <a href="{{ route('login') }}" class="text-sm font-medium text-[#00a8a3] hover:text-[#00b6af] transition-colors duration-200">
                    Already registered?
                </a>
                <button type="submit"
                    class="bg-gradient-to-r from-[#00a8a3] to-[#8582f4] text-white py-3 px-6 rounded-lg font-medium hover:from-[#00b6af] hover:to-[#9a92f6] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#00a8a3] transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98] shadow-md hover:shadow-lg">
                    Register
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
