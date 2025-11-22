<?php
include("../../lib/database.php");
include("../../backend/admin/admin_auth.php");

checkAdmin(); // Ensure admin is logged in

$order_id = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($order_id)) {
    header("Location: sales_dashboard.php");
    exit;
}

// Update order status if form submitted
if (isset($_POST['update_status'])) {
    $new_status = $_POST['status'];
    $message = $_POST['message'];

    // Update order status
    $update_query = "UPDATE orders SET status = '$new_status' WHERE order_id = '$order_id'";
    mysqli_query($con, $update_query);

    // Add tracking entry
    $tracking_query = "INSERT INTO order_tracking (order_id, status, message, updated_by) VALUES ('$order_id', '$new_status', '$message', '{$_SESSION['user_id']}')";
    mysqli_query($con, $tracking_query);

    header("Location: order_details.php?id=$order_id&updated=1");
    exit;
}

// Get order details
$order_query = "SELECT
    o.*,
    u.first_name,
    u.last_name,
    u.email,
    u.user_name
    FROM orders o
    JOIN users u ON o.customer_id = u.user_id
    WHERE o.order_id = '$order_id'";

$order_result = mysqli_query($con, $order_query);
$order = mysqli_fetch_assoc($order_result);

if (!$order) {
    header("Location: sales_dashboard.php");
    exit;
}

// Get order items
$items_query = "SELECT
    oi.*,
    p.product_name,
    p.image,
    u.first_name as supplier_first_name,
    u.last_name as supplier_last_name,
    u.user_name as supplier_username
    FROM order_items oi
    JOIN products p ON oi.product_id = p.product_id
    JOIN users u ON oi.supplier_id = u.user_id
    WHERE oi.order_id = '$order_id'";

$items_result = mysqli_query($con, $items_query);
$order_items = [];
while ($row = mysqli_fetch_assoc($items_result)) {
    $order_items[] = $row;
}

// Get order tracking
$tracking_query = "SELECT * FROM order_tracking WHERE order_id = '$order_id' ORDER BY created_at DESC";
$tracking_result = mysqli_query($con, $tracking_query);
$tracking_history = [];
while ($row = mysqli_fetch_assoc($tracking_result)) {
    $tracking_history[] = $row;
}
?>

<?php include './header.php'; ?>

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" />

<div class="bg-gray-800 min-h-screen p-6">
    <div class="bg-gray-900 p-8 shadow-xl rounded-xl">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-3xl font-bold text-emerald-400">Order Details</h2>
                <p class="text-gray-400">Order ID: <?= $order['order_id'] ?></p>
            </div>
            <a href="sales_dashboard.php" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
            </a>
        </div>

        <?php if (isset($_GET['updated'])): ?>
        <div class="bg-green-600 text-white p-4 rounded mb-6">
            <i class="fas fa-check-circle mr-2"></i>Order status updated successfully!
        </div>
        <?php endif; ?>

        <!-- Order Summary -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Customer Info -->
            <div class="bg-gray-800 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-white mb-4">Customer Information</h3>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm text-gray-400">Name:</label>
                        <p class="text-white"><?= htmlspecialchars($order['first_name'] . ' ' . $order['last_name']) ?></p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-400">Username:</label>
                        <p class="text-white">@<?= htmlspecialchars($order['user_name']) ?></p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-400">Email:</label>
                        <p class="text-white"><?= htmlspecialchars($order['email']) ?></p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-400">Phone:</label>
                        <p class="text-white"><?= htmlspecialchars($order['phone_number']) ?></p>
                    </div>
                </div>
            </div>

            <!-- Order Info -->
            <div class="bg-gray-800 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-white mb-4">Order Information</h3>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm text-gray-400">Order Date:</label>
                        <p class="text-white"><?= date('M j, Y g:i A', strtotime($order['order_date'])) ?></p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-400">Total Amount:</label>
                        <p class="text-white text-2xl font-bold">$<?= number_format($order['total_amount'], 2) ?></p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-400">Payment Status:</label>
                        <span class="px-2 py-1 text-xs rounded-full
                            <?php
                            switch($order['payment_status']) {
                                case 'paid': echo 'bg-green-600 text-green-100'; break;
                                case 'pending': echo 'bg-yellow-600 text-yellow-100'; break;
                                case 'failed': echo 'bg-red-600 text-red-100'; break;
                                case 'refunded': echo 'bg-blue-600 text-blue-100'; break;
                                default: echo 'bg-gray-600 text-gray-100';
                            }
                            ?>">
                            <?= ucfirst($order['payment_status']) ?>
                        </span>
                    </div>
                    <div>
                        <label class="text-sm text-gray-400">Current Status:</label>
                        <span class="px-2 py-1 text-xs rounded-full
                            <?php
                            switch($order['status']) {
                                case 'delivered': echo 'bg-green-600 text-green-100'; break;
                                case 'shipped': echo 'bg-blue-600 text-blue-100'; break;
                                case 'processing': echo 'bg-yellow-600 text-yellow-100'; break;
                                case 'pending': echo 'bg-gray-600 text-gray-100'; break;
                                case 'cancelled': echo 'bg-red-600 text-red-100'; break;
                                default: echo 'bg-gray-600 text-gray-100';
                            }
                            ?>">
                            <?= ucfirst($order['status']) ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Shipping Info -->
            <div class="bg-gray-800 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-white mb-4">Shipping Information</h3>
                <div>
                    <label class="text-sm text-gray-400">Shipping Address:</label>
                    <p class="text-white"><?= htmlspecialchars($order['shipping_address']) ?></p>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-gray-800 p-6 rounded-lg mb-8">
            <h3 class="text-xl font-semibold text-white mb-4">Order Items</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Product</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Supplier</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Price</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Quantity</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        <?php foreach ($order_items as $item): ?>
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-300">
                                <div class="flex items-center">
                                    <img src="../supplier/product/<?= $item['image'] ?>" alt="Product" class="w-12 h-12 rounded mr-3 object-cover">
                                    <div>
                                        <div class="font-medium text-white"><?= htmlspecialchars($item['product_name']) ?></div>
                                        <div class="text-xs text-gray-400">ID: <?= $item['product_id'] ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-300">
                                <?= htmlspecialchars($item['supplier_first_name'] . ' ' . $item['supplier_last_name']) ?>
                                <br><span class="text-xs text-gray-500">@<?= htmlspecialchars($item['supplier_username']) ?></span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-300">$<?= number_format($item['price'], 2) ?></td>
                            <td class="px-4 py-3 text-sm text-gray-300"><?= $item['quantity'] ?></td>
                            <td class="px-4 py-3 text-sm font-medium text-white">$<?= number_format($item['total'], 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Update Status & Order Tracking -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Update Status -->
            <div class="bg-gray-800 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-white mb-4">Update Order Status</h3>
                <form method="POST">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                        <select name="status" class="w-full bg-gray-700 text-white rounded px-3 py-2" required>
                            <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="processing" <?= $order['status'] == 'processing' ? 'selected' : '' ?>>Processing</option>
                            <option value="shipped" <?= $order['status'] == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                            <option value="delivered" <?= $order['status'] == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                            <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Message (Optional)</label>
                        <textarea name="message" rows="3" class="w-full bg-gray-700 text-white rounded px-3 py-2" placeholder="Add a note about this status update..."></textarea>
                    </div>
                    <button type="submit" name="update_status" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded">
                        <i class="fas fa-save mr-2"></i>Update Status
                    </button>
                </form>
            </div>

            <!-- Order Tracking -->
            <div class="bg-gray-800 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-white mb-4">Order Tracking History</h3>
                <div class="space-y-4 max-h-96 overflow-y-auto">
                    <?php foreach ($tracking_history as $track): ?>
                    <div class="border-l-4 border-emerald-500 pl-4 pb-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-medium text-white"><?= htmlspecialchars($track['status']) ?></h4>
                                <?php if ($track['message']): ?>
                                <p class="text-sm text-gray-400 mt-1"><?= htmlspecialchars($track['message']) ?></p>
                                <?php endif; ?>
                            </div>
                            <span class="text-xs text-gray-500"><?= date('M j, Y g:i A', strtotime($track['created_at'])) ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>