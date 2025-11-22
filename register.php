<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Account</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: "Inter", sans-serif;
            background-color: #111827;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin-top: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="bg-white rounded-2xl w-full max-w-md overflow-hidden transition-all duration-300 shadow-xl">

        <!-- Header -->
        <div class="bg-gradient-to-r from-emerald-600 to-teal-400 px-8 py-10 text-center">
            <h1 class="text-2xl font-bold text-white mb-2">Create Your Account</h1>
            <p class="text-[#a0f0ed] text-sm">Join ZenLeaf today and get started</p>
        </div>

        <!-- Form -->
        <form method="POST" action="./src/backend/customer/insert_user.php" class="p-8 space-y-4"
            enctype="multipart/form-data">
            <!-- CSRF Token, a security feature for forms. -->
            <input type="hidden" name="_token" value="your_csrf_token_here">

            <div class="flex gap-4">
                <!-- First Name -->
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                    <input id="first_name" type="text" name="first_name" value="" required autocomplete="first_name"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#00a8a3] focus:border-transparent transition-all duration-200"
                        placeholder="John">
                </div>

                <!-- Last Name -->
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                    <input id="last_name" type="text" name="last_name" value="" required autocomplete="last_name"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#00a8a3] focus:border-transparent transition-all duration-200"
                        placeholder="Doe">

                </div>
            </div>

            <!-- User Name -->
            <div>
                <label for="user_name" class="block text-sm font-medium text-gray-700 mb-2">User Name</label>
                <input id="user_name" type="text" name="user_name" value="" required autocomplete="user_name"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#00a8a3] focus:border-transparent transition-all duration-200"
                    placeholder="Doe">

            </div>

            <!-- Role Selection -->
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Register As</label>
                <div class="flex items-center gap-6 mt-2">
                    <label class="flex items-center">
                        <input type="radio" name="type" value="customer" required
                            class="text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded-full">
                        <span class="ml-2 text-gray-700">Customer</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="type" value="supplier"
                            class="text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded-full">
                        <span class="ml-2 text-gray-700">Supplier</span>
                    </label>
                </div>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <input id="email" type="email" name="email" value="" required autocomplete="username"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#00a8a3] focus:border-transparent transition-all duration-200"
                    placeholder="you@example.com">

            </div>

            <div class="flex gap-4">
                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#00a8a3] focus:border-transparent transition-all duration-200"
                        placeholder="••••••••">

                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirm Password
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        autocomplete="new-password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900
                focus:outline-none focus:ring-2 focus:ring-[#00a8a3] focus:border-transparent transition-all duration-200" placeholder="••••••••">
                </div>

            </div>


            <!-- Profile Image -->
            <div>
                <label for="profile_image" class="block text-sm font-medium text-gray-700 mb-2">
                    Upload Profile Image
                </label>
                <input id="profile_image" type="file" name="image" accept="image/*" required class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900
             focus:outline-none focus:ring-2 focus:ring-[#00a8a3] focus:border-transparent
             transition-all duration-200">
            </div>

            <!-- Preview container -->
            <div class="mt-4">
                <img id="image_preview" src="#" alt="Image Preview"
                    class="hidden w-full h-32 object-cover rounded-lg border" />
            </div>


            <script>
                const imageInput = document.getElementById('profile_image');
                const imagePreview = document.getElementById('image_preview');

                imageInput.addEventListener('change', function (e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (event) {
                            imagePreview.src = event.target.result;
                            imagePreview.classList.remove('hidden');
                        };
                        reader.readAsDataURL(file);
                    } else {
                        imagePreview.src = '#';
                        imagePreview.classList.add('hidden');
                    }
                });
            </script>

            <!-- Footer -->
            <div class="flex items-center justify-between m-8 ">
                <a href="login.php"
                    class="text-sm font-medium text-[#00a8a3] hover:text-[#00b6af] transition-colors duration-200">
                    Already registered?
                </a>
                <input type="submit" name="submit"
                    class="bg-gradient-to-r from-emerald-600 to-teal-400 text-white py-3 px-6 rounded-lg font-medium hover:from-[#00b6af] hover:to-[#9a92f6] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#00a8a3] transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98] shadow-md hover:shadow-lg"
                    value="Register" />
            </div>
        </form>
    </div>
</body>

</html>