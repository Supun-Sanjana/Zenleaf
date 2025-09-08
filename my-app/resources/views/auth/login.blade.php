<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center  p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transition-all duration-300 hover:shadow-2xl">
            
            <!-- Header -->
            <div class="bg-gradient-to-r from-[#00a8a3] to-[#8582f4] px-8 py-10 text-center">
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4 backdrop-blur-sm">
                    <!-- Optional logo icon -->
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">Welcome Back</h1>
                <p class="text-[#a0f0ed] text-sm">Please sign in to your account</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="p-8">
                @csrf

                <div class="space-y-6">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <div class="relative">
                            <input type="email" id="email" name="email" placeholder="you@example.com" required
                                class="pl-10 pr-4 py-3 w-full border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#00a8a3] focus:border-transparent transition-all duration-200">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-6.75h.75m-4.5 0h.75m4.5 0h-.75m-4.5 0h-.75" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <a href="#" class="text-sm font-medium text-[#00a8a3] hover:text-[#00b6af] transition-colors duration-200">Forgot?</a>
                        </div>
                        <div class="relative">
                            <input type="password" id="password" name="password" placeholder="••••••••" required
                                class="pl-10 pr-4 py-3 w-full border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#00a8a3] focus:border-transparent transition-all duration-200">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember-me" name="remember" type="checkbox" class="h-4 w-4 text-[#00a8a3] focus:ring-[#00a8a3] border-gray-300 rounded">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-700">Remember me</label>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" class="w-full bg-gradient-to-r from-[#00a8a3] to-[#8582f4] text-white py-3 px-4 rounded-lg font-medium hover:from-[#00b6af] hover:to-[#9a92f6] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#00a8a3] transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98] shadow-md hover:shadow-lg">
                            Sign in
                        </button>
                    </div>
                </div>
            </form>

            <!-- Footer -->
            <div class="px-8 py-6 bg-gray-50 text-center border-t border-gray-100">
                <p class="text-sm text-gray-600">
                    Don't have an account? 
                    <a href="register" class="font-medium text-[#00a8a3] hover:text-[#00b6af] transition-colors duration-200">Sign up</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
