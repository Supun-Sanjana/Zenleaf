

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Shopping Cart</title>
  @vite('resources/css/app.css')
  @vite('resources/js/app.js')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-1h6G3D..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-1h6G3D..." crossorigin="anonymous" referrerpolicy="no-referrer" />


</head>

<body class="bg-gray-50 text-gray-800">

  <!-- Header -->
  <x-discover.discover-header class="mb-12" />

  <!-- Back to Shop -->
  <div class="max-w-5xl mx-auto px-4 ">
    <a href="{{ route('discover') }}"
      class="inline-flex items-center bg-emerald-100 px-3 py-2 rounded  text-emerald-600 font-medium hover:text-emerald-700 transition-colors">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
        class="lucide lucide-chevron-left mr-2">
        <path d="m15 18-6-6 6-6" />
      </svg>
      Continue Shopping
    </a>

    <h1 class="mt-6 text-3xl font-semibold text-emerald-500">Shopping Cart</h1>
    <hr class="mt-4 border-gray-300" />

    @if(count($cart) > 0)
      @foreach($cart as $id => $item)
        <div class="mt-6 bg-white shadow rounded-xl p-6 flex flex-col sm:flex-row sm:items-center justify-between hover:shadow-lg transition-shadow">
          <div>
            <h3 class="text-lg font-semibold">{{ $item['name'] }}</h3>
            <p class="text-gray-600">${{ $item['price'] }}</p>
          </div>

          <div class="mt-4 sm:mt-0 flex items-center gap-3">
            <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center gap-2">
              @csrf
              <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                class="w-20 border border-gray-300 rounded-lg px-2 py-1 focus:ring-2 focus:ring-emerald-400 focus:outline-none">
              <button type="submit"
                class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg transition-colors">Update</button>
            </form>

            <form action="{{ route('cart.remove', $id) }}" method="POST">
              @csrf
              <button type="submit"
                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors">Remove</button>
            </form>
          </div>
        </div>
      @endforeach

      <!-- Total and Checkout -->
      <div class="mt-10 flex justify-end">
        <div class="bg-white shadow rounded-xl p-6 w-full max-w-sm">
          <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
          <p class="text-lg mb-6">Total: <span class="font-bold">${{ $total }}</span></p>
          <form action="{{ route('cart.checkout') }}" method="POST">
            @csrf
            <button type="submit"
              class="w-full bg-emerald-500 hover:bg-emerald-600 text-white py-3 rounded-lg font-medium transition-colors">
              Proceed to Checkout
            </button>
          </form>
        </div>
      </div>

    @else
      <p class="mt-6 text-center text-gray-500">Your cart is empty.</p>
    @endif
  </div>
</body>

</html>
