<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZenLeaf Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background-color: #111827;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">

    <div
        class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transition-all duration-300 hover:shadow-2xl">

        <div class="bg-gradient-to-r from-emerald-600 to-teal-400 px-8 py-10 text-center">
            <div
                class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4 backdrop-blur-sm">
                <i class="fas fa-seedling text-white text-3xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-white mb-2">ZenLeaf Admin</h1>
            <p class="text-gray-200 text-sm">Please sign in to your account</p>
        </div>
        <?php
        $error_message = '';
        if (isset($_GET['error'])) {
            switch ($_GET['error']) {
                case 'user_not_found':
                    $error_message = 'No account found with that email.';
                    break;
                case 'wrong_password':
                    $error_message = 'Incorrect password. Please try again.';
                    break;
                case 'invalid_type':
                    $error_message = 'Invalid user type.';
                    break;
                case 'not_logged_in':
                    $error_message = 'You must log in to access that page.';
                    break;
                case 'access_denied':
                    $error_message = 'Access denied. Admins only.';
                    break;
                case 'pass_error':
                    $error_message = 'Passwords do not match.';
                    break;
                default:
                    $error_message = 'Something went wrong. Please try again.';
            }
        }
        ?>

        <?php if (!empty($error_message)): ?>
            <div class="m-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php echo htmlspecialchars($error_message); ?>
            </div>

        <?php endif; ?>


        <form method="POST" action="../../backend/admin/admin_auth.php" class="p-8">

            <div class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <div class="relative">
                        <input type="email" id="email" name="email" placeholder="you@example.com" required
                            class="pl-10 pr-4 py-3 w-full border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition-all duration-200">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    </div>
                    <div class="relative">
                        <input type="password" id="password" name="password" placeholder="••••••••" required
                            class="pl-10 pr-4 py-3 w-full border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition-all duration-200">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <div class="flex items-center">
                    <input id="remember-me" name="remember" type="checkbox"
                        class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                    <label for="remember-me" class="ml-2 block text-sm text-gray-700">Remember me</label>
                </div>

                <div>
                    <button type="submit" name="submit"
                        class="w-full bg-gradient-to-r from-emerald-600 to-teal-400 text-white py-3 px-4 rounded-lg font-medium hover:from-emerald-700 hover:to-teal-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-600 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98] shadow-md hover:shadow-lg">
                        Sign in
                    </button>
                </div>
            </div>
        </form>

    </div>
</body>

</html>