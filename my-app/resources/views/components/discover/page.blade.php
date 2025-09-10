

<div class="max-w-6xl mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-6">Discover Products</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($products as $product)
            <div class="border rounded-lg p-4 shadow">
                <h2 class="text-xl font-semibold">{{ $product->name }}</h2>
                <p class="text-gray-600">{{ $product->description }}</p>
                <p class="text-green-500 font-bold mt-2">${{ $product->price }}</p>
            </div>
        @empty
            <p>No products found.</p>
        @endforelse
    </div>
</div>
