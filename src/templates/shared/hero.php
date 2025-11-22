<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indoor Oasis</title>

    <!--
      FIX: Added the Tailwind CSS script.
      This is required for all the 'bg-gray-900', 'flex', 'grid', 'text-white' etc. classes to work.
    -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        xintegrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Flowbite CSS (works with Tailwind) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />

    <style>
        /* A simple custom animation for the leaf decorations if you want them */
        .leaf-decoration {
            background-color: rgba(45, 212, 191, 0.1);
            border-radius: 9999px 0;
            animation: float 8s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(10deg);
            }

            100% {
                transform: translateY(0px) rotate(0deg);
            }
        }
    </style>
</head>

<body class="bg-gray-900">

    <section
        class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-gray-900 via-emerald-900 to-gray-800 p-4 pt-16 sm:p-6 lg:p-8">
        <!-- Background decorative elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-20 left-10 w-32 h-32 leaf-decoration opacity-30"></div>
            <div class="absolute bottom-20 right-10 w-24 h-24 leaf-decoration opacity-20 animation-delay-300"></div>
            <div class="absolute top-1/2 left-5 w-16 h-16 leaf-decoration opacity-25 animation-delay-600"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div>
                    <h1 class="text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                        Cultivate Your
                        <span class="block text-emerald-400">Indoor Oasis</span>
                    </h1>

                    <p class="text-xl text-gray-300 mb-8 leading-relaxed">
                        Transform your living space with our premium collection of indoor plants,
                        carefully selected to bring nature's tranquility into your home.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="./shop.php">
                            <button
                                class="group inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-full shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                                <span>Shop Plants</span>
                                <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform duration-200"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </button>
                        </a>

                        <a href="./care_guide.php"
                            class="group inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white bg-white/10 hover:bg-emerald-600/20 rounded-full backdrop-blur-sm border border-white/20 hover:border-emerald-400/50 transform hover:scale-105 transition-all duration-300">
                            <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Care Guide</span>
    </a>
                    </div>

                    <!-- Stats -->
                    <div class="mt-12 grid grid-cols-3 gap-8">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-emerald-400 mb-1">500+</div>
                            <div class="text-gray-400 text-sm">Happy Customers</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-emerald-400 mb-1">200+</div>
                            <div class="text-gray-400 text-sm">Plant Varieties</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-emerald-400 mb-1">5★</div>
                            <div class="text-gray-400 text-sm">Customer Rating</div>
                        </div>
                    </div>
                </div>

                <!-- Right Content - Plant Image -->
                <div>
                    <div class="relative">
                        <div class="relative bg-white/10 backdrop-blur-md rounded-3xl p-8 border border-white/20">

                            <img src="../src/templates/shared/hero.png" alt="Premium Indoor Plant"
                                class="w-full h-auto rounded-2xl shadow-2xl">

                            <!-- Floating UI elements -->
                            <div class="absolute -top-4 -right-4 bg-white rounded-2xl p-4 shadow-xl">
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                    <span class="text-sm font-medium text-gray-700">Healthy</span>
                                </div>
                            </div>

                            <div class="absolute -bottom-4 -left-4 bg-emerald-600 text-white rounded-2xl p-4 shadow-xl">
                                <div class="text-center">
                                    <div class="text-lg font-bold">$49</div>
                                    <div class="text-xs opacity-90">Best Seller</div>
                                </div>
                            </div>
                        </div>

                        <!-- Decorative elements -->
                        <div class="absolute -z-10 top-8 left-8 w-full h-full bg-emerald-600/20 rounded-3xl"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Flowbite JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>



</html>