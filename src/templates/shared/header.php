<?php
// header.php
session_start();

// Cart data from session
$cart = $_SESSION['cart'] ?? [];

// Compute totals and total items
$total = 0.0;
$itemCount = 0;
foreach ($cart as $item) {
  $qty = isset($item['quantity']) ? (int) $item['quantity'] : 1;
  $price = isset($item['price']) ? (float) $item['price'] : 0.0;
  $total += $qty * $price;
  $itemCount += $qty;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ZenLeaf</title>
  <link rel="icon" type="image/x-icon" href="favicon.png">
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">

  <!-- NAVBAR -->
  <nav class="fixed top-0 w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">

        <div class="flex gap-8 justify-center items-center">
          <a href="./index.php" class="flex items-center space-x-2">
            <div class="w-8 h-8 bg-emerald-600 rounded-lg flex items-center justify-center">
              <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path
                  d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
              </svg>
            </div>
            <span class="text-xl font-bold text-gray-900">ZenLeaf</span>
          </a>
          <?php
          if (isset($_SESSION['user_id'])) {
            echo '<a href="./shop.php" class="px-6 bg-emerald-600 px-3 py-2 rounded-md text-white hover:text-emerald-100 transition-colors">Shop</a>';
          }
          ?>

        </div>

        <!-- Right: Cart & User -->
        <div class="relative flex items-center space-x-8">
          <?php if (isset($_SESSION['user_id'])): ?>
            <!-- CART BUTTON -->
            <button id="cart-btn" class="relative text-gray-700 hover:text-emerald-600" type="button">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart">
                <circle cx="8" cy="21" r="1" />
                <circle cx="19" cy="21" r="1" />
                <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
              </svg>
              <?php if ($itemCount > 0): ?>
                <span
                  class="absolute -top-2 -right-2 bg-emerald-500 text-white text-xs px-1 rounded-full"><?= $itemCount ?></span>
              <?php endif; ?>
            </button>

            <!-- USER DROPDOWN -->

            <div class="relative">
              <?php $userName = $_SESSION['user_name'] ?? 'U';
              $letter = strtoupper(substr($userName, 0, 1)); ?>
              <button id="user-toggle" onclick="document.getElementById('dropdown').classList.toggle('hidden')"
                class="w-10 h-10 flex items-center justify-center rounded-full bg-emerald-600 text-white font-bold text-lg">
                <?= $letter ?>
              </button>
              <div id="dropdown" class="hidden absolute right-0 mt-2 w-48 bg-gray-800 rounded-lg shadow-lg py-2 z-50">
                <a href="./auth_logout.php"
                  class="block px-4 py-2 text-gray-200 hover:bg-gray-700 hover:text-emerald-400">Logout</a>
              </div>
            </div>
          <?php else: ?>
            <a href="./login.php"
              class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition-colors">Login</a>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </nav>

  <!-- Overlay -->
  <div id="overlay" class="fixed inset-0 bg-black/50 hidden z-40"></div>

  <!-- CART PANEL -->
  <aside id="cart-panel"
    class="fixed top-0 right-0 h-full w-80 bg-white shadow-xl transform translate-x-full transition-transform duration-300 z-50 flex flex-col">
    <div class="flex justify-between items-center p-4 border-b">
      <h2 class="text-lg font-semibold text-emerald-600">Shopping Cart</h2>
      <button id="close-cart" class="text-gray-600 hover:text-red-500" type="button">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
          stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <div class="flex-1 overflow-y-auto p-4 space-y-4">
      <?php if (!empty($cart)): ?>
        <?php foreach ($cart as $id => $item):
          $qty = (int) ($item['quantity'] ?? 1);
          $price = (float) ($item['price'] ?? 0);
          ?>
          <div class="flex justify-between items-center border-b pb-2">
            <div>
              <p class="font-medium"><?= htmlspecialchars($item['name']) ?></p>
              <p class="text-sm text-gray-600">$<?= number_format($price, 2) ?> × <?= $qty ?></p>
            </div>
            <div class="flex items-center space-x-2">
              <span class="font-semibold">$<?= number_format($price * $qty, 2) ?></span>
              <form action="./src/templates/shared/remove_from_cart.php" method="POST">
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($id) ?>">
                <button type="submit" class="text-red-500 hover:text-red-700">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </form>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-center text-gray-500">Your cart is empty.</p>
      <?php endif; ?>
    </div>

    <?php if (!empty($cart)): ?>
      <div class="p-4 border-t">
        <p class="flex justify-between text-lg font-semibold">
          <span>Total:</span> <span>$<?= number_format($total, 2) ?></span>
        </p>
        <a href="./src/templates/shared/checkout.php"
          class="block text-center w-full mt-4 bg-emerald-500 hover:bg-emerald-600 text-white py-2 rounded-lg font-medium transition-colors">
          Proceed to Checkout</a>
      </div>
      <!--  ---->
    <?php endif; ?>
  </aside>

  <div class="pt-16"><!-- page content --></div>

  <script>
    (function () {
      const cartBtn = document.getElementById('cart-btn');
      const cartPanel = document.getElementById('cart-panel');
      const overlay = document.getElementById('overlay');
      const closeBtn = document.getElementById('close-cart');
      const userToggle = document.getElementById('user-toggle');
      const dropdown = document.getElementById('dropdown');

      function openCart() {
        cartPanel.classList.remove('translate-x-full');
        overlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
      }
      function closeCart() {
        cartPanel.classList.add('translate-x-full');
        overlay.classList.add('hidden');
        document.body.style.overflow = '';
      }
      if (cartBtn) cartBtn.addEventListener('click', openCart);
      if (closeBtn) closeBtn.addEventListener('click', closeCart);
      if (overlay) overlay.addEventListener('click', closeCart);

      document.addEventListener('click', e => {
        if (dropdown && !dropdown.contains(e.target) && !(userToggle && userToggle.contains(e.target))) {
          dropdown.classList.add('hidden');
        }
      });
    })();
  </script>

</body>

</html>