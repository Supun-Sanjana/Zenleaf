<?php
session_start();

$cart = $_SESSION['cart'] ?? [];
$total = 0;
$totalItems = 0;
foreach ($cart as $it) {
  $q = isset($it['quantity']) ? intval($it['quantity']) : 0;
  $total += ($it['price'] * $q);
  $totalItems += $q;
}
?>

<!-- badge -->
<?php if ($totalItems > 0): ?>
  <span class="absolute -top-2 -right-2 bg-emerald-500 text-white text-xs px-1 rounded-full">
    <?= $totalItems ?>
  </span>
<?php endif; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ZenLeaf Cart Panel</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    crossorigin="anonymous" referrerpolicy="no-referrer" />


</head>

<body class="bg-gray-50">
  <nav class="p-4 bg-white shadow flex justify-between">
    <h1 class="text-xl font-bold text-emerald-600">ZenLeaf</h1>
    <!-- Cart Icon -->
    <button id="cart-btn" class="relative text-gray-700 hover:text-emerald-600">
      <i class="fa-solid fa-cart-shopping text-2xl"></i>
      <?php if ($totalItems > 0): ?>
        <span class="absolute -top-2 -right-2 bg-emerald-500 text-white text-xs px-1 rounded-full">
          <?php echo $totalItems; ?>
        </span>
      <?php endif; ?>
    </button>
  </nav>

  <!-- Overlay -->
  <div id="overlay" class="fixed inset-0 bg-black/50 hidden z-40"></div>

  <!-- Cart Side Panel -->
  <div id="cart-panel"
    class="fixed top-0 right-0 h-full w-80 bg-white shadow-xl transform translate-x-full transition-transform duration-300 z-50 flex flex-col">
    <div class="flex justify-between items-center p-4 border-b">
      <h2 class="text-lg font-semibold text-emerald-600">Shopping Cart 1</h2>
      <button id="close-cart" class="text-gray-600 hover:text-red-500">
        <i class="fa-solid fa-xmark text-xl"></i>
      </button>
      <button type="submit" class="text-red-500 hover:text-red-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
          stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <div class="flex-1 overflow-y-auto p-4 space-y-4">
      <?php if (count($cart) > 0): ?>
        <?php foreach ($cart as $id => $item): ?>
          <div class="flex justify-between items-center border-b pb-2">
            <div>
              <p class="font-medium"><?php echo htmlspecialchars($item['name']); ?></p>
              <p class="text-sm text-gray-600">
                $<?php echo htmlspecialchars($item['price']); ?> ×
                <?php echo htmlspecialchars($item['quantity']); ?>
              </p>
            </div>
            <div class="flex items-center space-x-2 ">
              <span class="font-semibold">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>

              <!-- Remove button -->
              <form action="remove_from_cart.php" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $id; ?>">
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


  </div>

  <script>
    const cartBtn = document.getElementById('cart-btn');
    const cartPanel = document.getElementById('cart-panel');
    const overlay = document.getElementById('overlay');
    const closeBtn = document.getElementById('close-cart');

    function openCart() {
      cartPanel.classList.remove('translate-x-full');
      overlay.classList.remove('hidden');
    }

    function closeCart() {
      cartPanel.classList.add('translate-x-full');
      overlay.classList.add('hidden');
    }

    cartBtn.addEventListener('click', openCart);
    closeBtn.addEventListener('click', closeCart);
    overlay.addEventListener('click', closeCart);
  </script>
</body>

</html>