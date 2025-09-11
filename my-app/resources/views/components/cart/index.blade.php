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
    <x-discover.discover-header class="mb-20" />

    <h1 class="mt-20 text-emerald-500 text-2xl font-semibold mb-2 px-4">Your Cart</h1>

    @if(count($cart) > 0)
        @foreach($cart as $id => $item)
            <div class="mx-5 my-5 bg-gray-200 rounded-lg flex-shrink-0 overflow-hidden">
                <div class="p-4 flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl">{{ $item['name'] }}</h3>
                     <h3 class="text-md">${{ $item['price'] }}</h3>
                    </div>
                    

                    <div>
                        <form action="{{ route('cart.update', $id) }}" method="POST">
                            @csrf
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                class="border border-gray-300 rounded-md px-2 py-2 mr-2">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
                        </form>
                    </div>
                   

                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Remove</button>
                    </form>
                </div>
            </div>
        @endforeach

        <div class="flex justify-end mx-4 mt-4">
            <div>
                <h2 class="text-2xl mb-2">Total: ${{ $total }}</h2>

            <form action="{{ route('cart.checkout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Checkout</button>
            </form>
            </div>
            
        </div>


    @else
        <p>Your cart is empty.</p>
    @endif

</body>

</html>