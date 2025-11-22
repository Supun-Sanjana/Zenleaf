<?php
session_start();
include("../../lib/database.php");

// Handle success and error messages
$success_message = $_SESSION['success'] ?? '';
$error_messages = $_SESSION['errors'] ?? [];
unset($_SESSION['success'], $_SESSION['errors']);

$user_id = $_SESSION['user_id'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-gray-900 ">

    <?php include "header.php" ?>
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="bg-gray-800 p-8 rounded-lg shadow-xl w-full max-w-2xl">
            <h2 class="text-3xl font-bold text-emerald-400 mb-6">Product Management 🌿</h2>

            <?php if ($success_message): ?>
                <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded mb-4">
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error_messages)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul>
                        <?php foreach ($error_messages as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="../../backend/supplier/insert_product.php" method="POST" enctype="multipart/form-data"
                class="space-y-6">

                <div>
                    <label for="name" class="block font-medium text-gray-200 mb-1">Product Name</label>
                    <input type="text" name="name" id="name"
                        class="w-full border border-gray-700 px-3 py-2 rounded bg-gray-900 text-gray-200 focus:ring-emerald-400 focus:border-emerald-400"
                        required>
                </div>

                <div>
                    <label for="description" class="block font-medium text-gray-200 mb-1">Description</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full border border-gray-700 px-3 py-2 rounded bg-gray-900 text-gray-200 focus:ring-emerald-400 focus:border-emerald-400"></textarea>
                </div>

                <div class="flex gap-4">
                    <div class="w-1/2">
                        <label for="price" class="block font-medium text-gray-200 mb-1">Price</label>
                        <input type="number" step="0.01" name="price" id="price"
                            class="w-full border border-gray-700 px-3 py-2 rounded bg-gray-900 text-gray-200 focus:ring-emerald-400 focus:border-emerald-400"
                            required>
                    </div>
                    <div class="w-1/2">
                        <label for="quantity" class="block font-medium text-gray-200 mb-1">Quantity</label>
                        <input type="number" name="quantity" id="quantity"
                            class="w-full border border-gray-700 px-3 py-2 rounded bg-gray-900 text-gray-200 focus:ring-emerald-400 focus:border-emerald-400"
                            required>
                    </div>
                </div>

                <div>
                    <label class="block font-medium text-gray-200 mb-2">Category</label>
                    <div class="space-y-2 flex gap-5">

                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="category[]" value="indoor"
                                class="form-checkbox h-4 w-4 text-emerald-400 bg-gray-900 border-gray-700 rounded focus:ring-emerald-400">
                            <span class="text-gray-200">Indoor</span>
                        </label>

                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="category[]" value="flowering"
                                class="form-checkbox h-4 w-4 text-emerald-400 bg-gray-900 border-gray-700 rounded focus:ring-emerald-400">
                            <span class="text-gray-200">Flowering</span>
                        </label>

                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="category[]" value="miniature"
                                class="form-checkbox h-4 w-4 text-emerald-400 bg-gray-900 border-gray-700 rounded focus:ring-emerald-400">
                            <span class="text-gray-200">Miniature</span>
                        </label>

                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="category[]" value="accessories"
                                class="form-checkbox h-4 w-4 text-emerald-400 bg-gray-900 border-gray-700 rounded focus:ring-emerald-400">
                            <span class="text-gray-200">Accessories</span>
                        </label>

                    </div>
                </div>


                <div>
                    <label for="image" class="block font-medium text-gray-200 mb-2">Product Image</label>
                    <div class="flex items-center justify-center w-full">
                        <label for="image"
                            class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-700 border-dashed rounded-lg cursor-pointer bg-gray-900 hover:bg-gray-700">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i class="fas fa-cloud-upload-alt text-emerald-400 text-3xl mb-2"></i>
                                <p class="text-sm text-gray-400"><span class="font-semibold text-emerald-400">Click to
                                        upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                            </div>
                            <input id="image" type="file" class="hidden" name="image" />
                        </label>
                    </div>
                </div>

                <div>
                    <button type="submit" name="submit"
                        class="w-full bg-emerald-400 text-gray-900 px-6 py-2 rounded font-medium hover:bg-emerald-500 transition-all">Add
                        Product</button>
                </div>
            </form>
        </div>
    </div>


</body>

</html>