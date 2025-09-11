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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>

<body>
    <x-seller.seller_header />

    <div>
        <div class="max-w-2xl mx-auto mt-20">
            <div class="mb-4">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>

            <h1 class="text-2xl font-bold mb-6">Add New Product</h1>

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block font-medium">Product Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="w-full border px-3 py-2 rounded" required>
                </div>

                <div>
                    <label for="description" class="block font-medium">Description</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full border px-3 py-2 rounded">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label for="price" class="block font-medium">Price</label>
                    <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}"
                        class="w-full border px-3 py-2 rounded" required>
                </div>

                <div>
                    <label for="category" class="block font-medium">Category</label><br>

                    <div class="flex gap-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="category[]" value="Indoor"
                                id="categoryIndoor">
                            <label class="form-check-label" for="categoryIndoor">Indoor</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="category[]" value="Flowering"
                                id="categoryFlowering">
                            <label class="form-check-label" for="categoryFlowering">Flowering</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="category[]" value="Miniature"
                                id="categoryMiniature">
                            <label class="form-check-label" for="categoryMiniature">Miniature (Desk Plants)</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="category[]" value="Accessories"
                                id="categoryAccessories">
                            <label class="form-check-label" for="categoryAccessories">Accessories</label>
                        </div>
                    </div>

                </div>

                <div>
                    <label for="quantity" class="block font-medium">Quantity</label>
                    <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}"
                        class="w-full border px-3 py-2 rounded" required>
                </div>

                <div>
                    <label for="image" class="block font-medium mb-2">Product Image</label>
                    <div class="flex items-center justify-center w-full">
                        <label for="dropzone-file"
                            class="flex flex-col items-center justify-center w-full h-34 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-200 dark:bg-gray-100  dark:border-gray-600 dark:hover:border-gray-500 ">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                        class="font-semibold">Click
                                        to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX.
                                    800x400px)
                                </p>
                            </div>
                            <input id="dropzone-file" type="file" class="hidden" name="image" id="image" />
                        </label>
                    </div>
                </div>

                {{-- Assuming the logged-in user is the product owner --}}
                <input type="hidden" name="user_id" value="{{ auth()->user()->user_id }}">

                <div>
                    <button type="submit" class="bg-emerald-500 text-white px-6 py-2 rounded hover:bg-emerald-600">Add
                        Product</button>
                </div>

            </form>

        </div>
    </div>
</body>

</html>