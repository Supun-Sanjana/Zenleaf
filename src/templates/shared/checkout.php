<?php
session_start();

// If cart is empty
$cart = $_SESSION['cart'] ?? [];
$total = 0;

// Calculate initial total
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}


$email = $_SESSION['email'];
$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name']

    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <div class="flex justify-between">
            <h1 class="text-2xl font-bold text-emerald-700 mb-6">Your Cart 🛒</h1>
            <a href="../../../shop.php" class="text-emerald-600 underline">Continue Shopping</a>
        </div>


        <?php if (empty($cart)): ?>
            <p class="text-gray-600">Your cart is empty.</p>

        <?php else: ?>
            <form id="checkout-form" action="../../backend/update_cart.php" method="POST">
                <table class="w-full border-collapse mb-6">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2 text-left">Product</th>
                            <th class="py-2">Price</th>
                            <th class="py-2">Quantity</th>
                            <th class="py-2">Subtotal</th>
                            <th class="py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody id="cart-items">
                        <?php foreach ($cart as $id => $item):
                            $subtotal = $item['price'] * $item['quantity'];
                            ?>
                            <tr class="border-b cart-row" data-product-id="<?= htmlspecialchars($id) ?>">
                                <td class="py-2 flex items-center gap-3">
                                    <img src="../supplier/product/<?= htmlspecialchars($item['image']) ?>"
                                        class="w-12 h-12 object-cover rounded" alt="<?= htmlspecialchars($item['name']) ?>">
                                    <span class="product-name"><?= htmlspecialchars($item['name']) ?></span>
                                </td>
                                <td class="text-center">
                                    $<span class="product-price"
                                        data-price="<?= $item['price'] ?>"><?= number_format($item['price'], 2) ?></span>
                                </td>
                                <td class="text-center">
                                    <input type="number" name="quantity[<?= $id ?>]" value="<?= $item['quantity'] ?>" min="1"
                                        max="99" class="quantity-input w-16 border rounded px-2 py-1 text-center"
                                        data-product-id="<?= htmlspecialchars($id) ?>" data-price="<?= $item['price'] ?>">
                                </td>
                                <td class="text-center">
                                    $<span class="subtotal"><?= number_format($subtotal, 2) ?></span>
                                </td>
                                <td class="text-center">
                                    <button type="button"
                                        class="remove-item bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm"
                                        data-product-id="<?= htmlspecialchars($id) ?>">
                                        Remove
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </form>

            <div class="">
                <h3 class="text-2xl font-semibold text-gray-800 mb-6 pt-8 ">
                    Billing Details
                </h3>
                <form class="space-y-4" action="../../backend/customer/save_billing.php" method="post">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" value="<?= $first_name ?> <?= $last_name ?>" name="full_name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" value="<?= $email ?>" name="email"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="tel" placeholder="+94 71 234 5678" required name="phone"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Billing Address</label>
                        <input type="text" placeholder="123 Main Street" required name="address"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                            <input type="text" placeholder="Colombo" required name="city"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                            <input type="text" placeholder="10100" required name="postal_code"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                        </div>
                    </div>

                    <button type="submit" name="submit"
                        class="w-full mt-4 bg-indigo-600 text-white font-semibold py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                        Save Billing Details
                    </button>
                </form>
            </div>

            <div class="flex justify-end items-center">
                <!-- <div>
                    <a href="../../../shop.php" class="ml-4 text-emerald-600 underline">Continue Shopping</a>
                </div> -->
                <div class="text-right">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Subtotal: $<span
                                id="cart-subtotal"><?= number_format($total, 2) ?></span></p>
                        <p class="text-sm text-gray-600">Shipphing: $<span
                                id="cart-tax"><?= number_format(15, 2) ?></span></p>
                        <hr class="my-2">
                        <p class="text-lg font-semibold">Total: $<span
                                id="cart-total"><?= number_format($total + 15, 2) ?></span></p>
                    </div>
                    <button type="button" id="checkout-btn"
                        class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 w-full">
                        Proceed to Checkout
                    </button>
                </div>
            </div>

            <!-- Checkout Modal -->
            <div id="checkout-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div class="bg-white rounded-lg p-6 w-full max-w-md">
                        <h2 class="text-xl font-bold mb-4">Checkout Summary</h2>
                        <div id="checkout-summary" class="mb-4">
                            <!-- Summary will be populated by JavaScript -->
                        </div>
                        <div class="flex gap-3">
                            <button id="confirm-checkout"
                                class="flex-1 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                Confirm Order
                            </button>
                            <button id="cancel-checkout"
                                class="flex-1 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        class CheckoutManager {
            constructor() {
                this.taxRate = 0.08;
                this.init();
            }

            init() {
                // Add event listeners for quantity changes
                document.querySelectorAll('.quantity-input').forEach(input => {
                    input.addEventListener('input', (e) => this.updateQuantity(e));
                    input.addEventListener('change', (e) => this.updateQuantity(e));
                });

                // Add event listeners for remove buttons
                document.querySelectorAll('.remove-item').forEach(button => {
                    button.addEventListener('click', (e) => this.removeItem(e));
                });

                // Add checkout button listener
                const checkoutBtn = document.getElementById('checkout-btn');
                if (checkoutBtn) {
                    checkoutBtn.addEventListener('click', () => this.showCheckoutModal());
                }

                // Modal event listeners
                const confirmBtn = document.getElementById('confirm-checkout');
                const cancelBtn = document.getElementById('cancel-checkout');
                const modal = document.getElementById('checkout-modal');

                if (confirmBtn) {
                    confirmBtn.addEventListener('click', () => this.processCheckout());
                }

                if (cancelBtn) {
                    cancelBtn.addEventListener('click', () => this.hideCheckoutModal());
                }

                // Close modal when clicking outside
                if (modal) {
                    modal.addEventListener('click', (e) => {
                        if (e.target === modal) {
                            this.hideCheckoutModal();
                        }
                    });
                }
            }

            updateQuantity(event) {
                const input = event.target;
                const productId = input.dataset.productId;
                const price = parseFloat(input.dataset.price);
                const quantity = parseInt(input.value) || 1;

                // Ensure minimum quantity is 1
                if (quantity < 1) {
                    input.value = 1;
                    return;
                }

                // Update the subtotal for this item
                const row = input.closest('.cart-row');
                const subtotalElement = row.querySelector('.subtotal');
                const newSubtotal = price * quantity;

                subtotalElement.textContent = this.formatPrice(newSubtotal);

                // Update the total
                this.updateCartTotal();

                // Add visual feedback
                row.classList.add('bg-yellow-50');
                setTimeout(() => {
                    row.classList.remove('bg-yellow-50');
                }, 300);
            }

            removeItem(event) {
                const button = event.target;
                const productId = button.dataset.productId;
                const row = button.closest('.cart-row');

                // Add fade out animation
                row.style.transition = 'opacity 0.3s ease';
                row.style.opacity = '0.5';

                // Confirm removal
                if (confirm('Are you sure you want to remove this item from your cart?')) {
                    // Remove the row
                    row.remove();

                    // Update totals
                    this.updateCartTotal();

                    // Send AJAX request to remove from session
                    this.removeFromSession(productId);

                    // Check if cart is empty
                    this.checkEmptyCart();
                } else {
                    // Restore opacity if cancelled
                    row.style.opacity = '1';
                }
            }

            updateCartTotal() {
                let subtotal = 0;

                document.querySelectorAll('.cart-row').forEach(row => {
                    const quantityInput = row.querySelector('.quantity-input');
                    const price = parseFloat(quantityInput.dataset.price);
                    const quantity = parseInt(quantityInput.value) || 1;
                    subtotal += price * quantity;
                });

                const tax = subtotal * this.taxRate;
                const total = subtotal + tax;

                // Update display
                document.getElementById('cart-subtotal').textContent = this.formatPrice(subtotal);
                document.getElementById('cart-tax').textContent = this.formatPrice(tax);
                document.getElementById('cart-total').textContent = this.formatPrice(total);
            }

            formatPrice(amount) {
                return new Intl.NumberFormat('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(amount);
            }

            removeFromSession(productId) {
                // Send AJAX request to remove item from session
                fetch('../cart/remove_from_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `product_id=${encodeURIComponent(productId)}`
                }).catch(error => {
                    console.error('Error removing item:', error);
                });
            }

            checkEmptyCart() {
                const cartItems = document.querySelectorAll('.cart-row');
                if (cartItems.length === 0) {
                    const container = document.querySelector('.max-w-4xl');
                    container.innerHTML = `
                        <h1 class="text-2xl font-bold text-emerald-700 mb-6">Your Cart 🛒</h1>
                        <p class="text-gray-600">Your cart is empty.</p>
                        <a href="../../../shop.php" class="text-emerald-600 underline">Continue Shopping</a>
                    `;
                }
            }

            showCheckoutModal() {
                const modal = document.getElementById('checkout-modal');
                const summary = document.getElementById('checkout-summary');

                // Generate checkout summary
                let summaryHTML = '<div class="space-y-2">';

                document.querySelectorAll('.cart-row').forEach(row => {
                    const name = row.querySelector('.product-name').textContent;
                    const quantity = row.querySelector('.quantity-input').value;
                    const subtotal = row.querySelector('.subtotal').textContent;

                    summaryHTML += `
                        <div class="flex justify-between text-sm">
                            <span>${name} (${quantity}x)</span>
                            <span>$${subtotal}</span>
                        </div>
                    `;
                });

                const totalAmount = document.getElementById('cart-total').textContent;
                summaryHTML += `
                    </div>
                    <hr class="my-3">
                    <div class="flex justify-between font-bold">
                        <span>Total Amount:</span>
                        <span>$${totalAmount}</span>
                    </div>
                `;

                summary.innerHTML = summaryHTML;
                modal.classList.remove('hidden');
            }

            hideCheckoutModal() {
                const modal = document.getElementById('checkout-modal');
                modal.classList.add('hidden');
            }

            processCheckout() {
                // Here you would typically redirect to payment gateway
                // For now, we'll redirect to the PayHere integration
                window.location.href = './Payhere/index.php';
            }
        }

        // Initialize the checkout manager when the page loads
        document.addEventListener('DOMContentLoaded', () => {
            new CheckoutManager();
        });
    </script>
</body>

</html>