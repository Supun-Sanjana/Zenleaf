<?php
session_start(); // ensure this is at the top
$cart = $_SESSION['cart'] ?? [];
$total = 0;
foreach ($cart as $id => $item) {
  $qty = isset($item['quantity']) ? intval($item['quantity']) : 0;
  $total += $item['price'] * $qty;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Shopping Cart</title>
  <link rel="stylesheet" href="resources/css/app.css">
  <script src="resources/js/app.js" defer></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-1h6G3D..." crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-gray-50 text-gray-800">

  <!-- Header -->
  <?php include '../shared/header.php'; ?> <!-- Replace with your header include -->

  <!-- Back to Shop -->
  <div class="max-w-5xl mx-auto px-4 ">
    <a href="../../shop.php"
      class="inline-flex items-center bg-emerald-100 px-3 py-2 rounded  text-emerald-600 font-medium hover:text-emerald-700 transition-colors">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
        class="lucide lucide-chevron-left mr-2">
        <path d="m15 18-6-6 6-6" />
      </svg>
      Continue Shopping
    </a>

    <h1 class="mt-6 text-3xl font-semibold text-emerald-500">Shopping Cart</h1>
    <hr class="mt-4 border-gray-300" />

    <?php if (count($cart) > 0): ?>
      <?php foreach ($cart as $id => $item): ?>
        <div
          class="mt-6 bg-white shadow rounded-xl p-6 flex flex-col sm:flex-row sm:items-center justify-between hover:shadow-lg transition-shadow">

          <!-- Product Image and Details -->
          <div class="flex items-center gap-4">
            <?php if (isset($item['image']) && !empty($item['image'])): ?>
              <img src="../../uploads/<?php echo htmlspecialchars($item['image']); ?>"
                alt="<?php echo htmlspecialchars($item['name']); ?>"
                class="w-20 h-20 object-cover rounded-lg border border-gray-200">
            <?php else: ?>
              <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                  </path>
                </svg>
              </div>
            <?php endif; ?>

            <div>
              <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($item['name']); ?></h3>
              <p class="text-gray-600">$<?php echo htmlspecialchars($item['price']); ?></p>
              <p class="text-sm text-gray-500">Quantity: <?php echo htmlspecialchars($item['quantity']); ?></p>
            </div>
          </div>

          <div class="mt-4 sm:mt-0 flex items-center gap-3">
            <form action="cart-update.php?id=<?php echo urlencode($id); ?>" method="POST" class="flex items-center gap-2">
              <input type="number" name="quantity" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="1"
                class="w-20 border border-gray-300 rounded-lg px-2 py-1 focus:ring-2 focus:ring-emerald-400 focus:outline-none">
              <button type="submit"
                class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg transition-colors">Update</button>
            </form>

            <form action="cart-remove.php?id=<?php echo urlencode($id); ?>" method="POST">
              <button type="submit"
                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors">Remove</button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>

      <!-- Total and Checkout -->
      <div class="mt-10 flex justify-end">
        <div class="bg-white shadow rounded-xl p-6 w-full max-w-sm">
          <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
          <p class="text-lg mb-6">Total: <span class="font-bold">$<?php echo htmlspecialchars($total); ?></span></p>
          <form action="checkout.php" method="POST">
            <button type="submit"
              class="w-full bg-emerald-500 hover:bg-emerald-600 text-white py-3 rounded-lg font-medium transition-colors">
              Proceed to Checkout
            </button>
          </form>
        </div>
      </div>

    <?php else: ?>
      <p class="mt-6 text-center text-gray-500">Your cart is empty.</p>
    <?php endif; ?>
  </div>
</body>

</html>