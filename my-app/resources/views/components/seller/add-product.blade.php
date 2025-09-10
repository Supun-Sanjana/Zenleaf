<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-1h6G3D..." crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
    <x-seller.seller_header />
    
<div class="max-w-2xl mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-6">Add New Product</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block font-medium">Product Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div>
            <label for="description" class="block font-medium">Description</label>
            <textarea name="description" id="description" rows="3" class="w-full border px-3 py-2 rounded">{{ old('description') }}</textarea>
        </div>

        <div>
            <label for="price" class="block font-medium">Price</label>
            <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div>
            <label for="quantity" class="block font-medium">Quantity</label>
            <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div>
            <label for="image" class="block font-medium">Product Image</label>
            <input type="file" name="image" id="image" class="w-full border px-3 py-2 rounded">
        </div>

        {{-- Assuming the logged-in user is the product owner --}}
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

        <div>
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">Add Product</button>
        </div>
    </form>
</div>

</body>
</html>