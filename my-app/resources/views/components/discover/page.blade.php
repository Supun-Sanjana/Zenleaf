<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-1h6G3D..." crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>

    <div class="max-w-6xl mx-5 mt-10">
        <h1 class="text-2xl font-bold mb-6 mt-20">Discover Products</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif


        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($products as $product)

                <div
                    class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                    <div class="h-64 bg-gradient-to-br from-pink-100 to-pink-200 flex items-center justify-center">
                        <img src="{{ Storage::url($product->image) }}" alt="Premium Indoor Plant"
                            class="w-full h-full object-cover ">
                    </div>
                    <div class="p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $product->name }}</h4>
                        <p class="text-gray-600 text-sm mb-4">{{ $product->description }}</p>


                        {{-- Display badges dynamically --}}
                        <div class="mb-4">
                            @php
                                $categories = explode(',', $product->category); // Convert comma string to array
                                $colors = [
                                    'Indoor' => 'bg-green-100 text-green-800',
                                    'Flowering' => 'bg-pink-100 text-pink-800',
                                    'Miniature' => 'bg-blue-100 text-blue-800',
                                    'Accessories' => 'bg-orange-100 text-orange-800',
                                ];
                            @endphp

                            @foreach($categories as $cat)
                                <span
                                    class="inline-block {{ $colors[trim($cat)] ?? 'bg-gray-100 text-gray-800' }} text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                                    {{ $cat }}
                                </span>
                            @endforeach
                        </div>

                        <!-- <div class="flex gap-2 my-4 justify-between">
                                <span class="text-2xl font-bold text-green-600">${{ $product->price }}</span>
                                <div>
                                    <span>Qty</span>
                                    <input type="number" name="quantity" value="1" min="1" class=" px-2 w-16 h-7 py-2 rounded">
                                </div>
                            </div> -->

                        <!-- <div>
                                    <button
                                    type="submit"
                                        class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                                        <i class="fas fa-cart-plus mr-1"></i> Add
                                    </button>
                                </div> -->

                        <form action="{{ route('cart.add', $product->product_id) }}" method="POST">
                            @csrf
                            <div class="flex gap-2 my-4 justify-between">
                                <span class="text-2xl font-bold text-green-600">${{ $product->price }}</span>
                                <div>
                                    <span>Qty</span>
                                    <input type="number" name="quantity" value="1" min="1"
                                        class="px-2 w-16 h-7 py-2 rounded">
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                                <i class="fas fa-cart-plus mr-1"></i> Add
                            </button>
                        </form>

                    </div>
                </div>
            @empty
                <p>No products found.</p>
            @endforelse
        </div>
    </div>

</body>

</html>