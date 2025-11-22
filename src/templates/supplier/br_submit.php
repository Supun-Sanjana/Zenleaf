<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
    </style>
</head>

<body class="bg-gray-900 ">
<?php include "header.php" ?>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl p-8 md:p-10">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Business Registration</h2>
                <p class="text-gray-600">Please fill out the form to register your business.</p>
            </div>

            <form action="../../backend/supplier/insert_br.php" method="POST" class="space-y-6" enctype="multipart/form-data">
                <!-- Business Name -->
                <div>
                    <label for="business-name" class="block text-sm font-medium text-gray-700 mb-1">Business
                        Name</label>
                    <input type="text" name="business-name" id="business-name" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition duration-150 ease-in-out"
                        placeholder="e.g., ZenLeaf Inc.">
                </div>

                <!-- Business Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Business Address</label>
                    <input type="text" name="address" id="address" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition duration-150 ease-in-out"
                        placeholder="Street, City, Zip">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Contact Person -->
                    <div>
                        <label for="full-name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" name="full-name" id="full-name" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition duration-150 ease-in-out"
                            placeholder="Full Name">
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" id="email" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition duration-150 ease-in-out"
                            placeholder="email@example.com">
                    </div>
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <input type="tel" name="phone" id="phone" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition duration-150 ease-in-out"
                        placeholder="+1 (555) 555-5555">
                </div>

                <!-- File Upload -->
                <div>
                    <label for="br-file" class="block text-sm font-medium text-gray-700 mb-1">Government Registered
                        Business File</label>
                    <input type="file" name="br-file" id="br-file" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-gray-700 focus:ring-emerald-500 focus:border-emerald-500 transition duration-150 ease-in-out">
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition duration-200 ease-in-out">
                        Register Business
                    </button>
                </div>
            </form>
        </div>
    </div>



</body>

</html>
