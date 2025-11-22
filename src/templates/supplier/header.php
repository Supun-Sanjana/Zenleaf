<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="bg-gray-800 p-4 shadow-lg flex justify-between items-center">
    <div class="flex items-center space-x-4">
        <a href="./index.php" class="text-2xl font-bold text-emerald-400">
            <h1 class="text-2xl font-bold text-emerald-400 mr-20">ZenLeaf</h1>
        </a>
        <a href="./sales_dashboard.php" class="text-gray-300 hover:text-white px-3 py-2 rounded-md transition-colors bg-emerald-600">Sales Dashboard</a>
        <a href="./br_submit.php" class="text-gray-300 hover:text-white px-3 py-2 rounded-md transition-colors bg-emerald-600">Become a Supplier</a>
        <a href="./add_product.php" class="text-gray-300 hover:text-white px-3 py-2 rounded-md transition-colors bg-emerald-600">Add product</a>
        <a href="../../../shop.php" class="text-gray-300 hover:text-white px-3 py-2 rounded-md transition-colors bg-emerald-600">Shop</a>
    </div>

    <div>
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="flex space-x-4 items-center ">
                <span class="text-sm">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
            <div class="relative">
                <?php $letter = strtoupper(substr($_SESSION['user_name'], 0, 1)); ?>
                <button id="user-dropdown-toggle" onclick="document.getElementById('dropdown-menu').classList.toggle('hidden')"
                    class="flex items-center focus:outline-none" type="button">
                    <div class="w-10 h-10 flex items-center justify-center rounded-full bg-emerald-600 text-white font-bold text-lg"><?php echo $letter; ?></div>
                </button>

                <div id="dropdown-menu" class="hidden absolute right-0 mt-2 w-48 bg-gray-800 rounded-lg shadow-lg py-2 z-50">
                    <a href="../../backend/supplier/auth_logout.php" class="block px-4 py-2 text-gray-200 hover:bg-gray-700 hover:text-emerald-400">Logout</a>
                </div>
            </div>
            </div>

        <?php else: ?>
            <a href="./login.php" class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition-colors">Login</a>
        <?php endif; ?>
    </div>
</header>