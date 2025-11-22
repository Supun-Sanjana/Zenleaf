<?php
session_start();
include("../../lib/database.php");

// Check if supplier is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['type'] !== 'supplier') {
    header("Location: ../../../login.php");
    exit;
}

if (isset($_POST['update_status'])) {
    $order_id = trim($_POST['order_id']);
    $new_status = trim($_POST['status']);

    $allowed_statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
    if (in_array($new_status, $allowed_statuses)) {
        $update_sql = "UPDATE orders SET status = ? WHERE order_id = ?";
        $stmt = $con->prepare($update_sql);
        $stmt->bind_param("ss", $new_status, $order_id);
        $stmt->execute();
        $stmt->close();

        // Refresh the page to show updated status
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit;
    }
}




$supplier_id = $_SESSION['user_id'];

// Get date range from query parameters
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01'); // First day of current month
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d'); // Today

// Supplier's Total Sales Query
$total_sales_query = "SELECT
    COUNT(DISTINCT oi.order_id) as total_orders,
    SUM(oi.total) as total_revenue,
    AVG(oi.total) as avg_order_value,
    SUM(oi.quantity) as total_items_sold
    FROM order_items oi
    JOIN orders o ON oi.order_id = o.order_id
    WHERE oi.supplier_id = '$supplier_id'
    AND o.order_date BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'
    AND o.payment_status = 'paid'";

$total_sales_result = mysqli_query($con, $total_sales_query);
$total_sales = mysqli_fetch_assoc($total_sales_result);

// Sales by Status for this supplier
$status_query = "SELECT
    o.status,
    COUNT(DISTINCT oi.order_id) as count,
    SUM(oi.total) as revenue
    FROM order_items oi
    JOIN orders o ON oi.order_id = o.order_id
    WHERE oi.supplier_id = '$supplier_id'
    AND o.order_date BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'
    GROUP BY o.status
    ORDER BY count DESC";

$status_result = mysqli_query($con, $status_query);
$status_data = [];
while ($row = mysqli_fetch_assoc($status_result)) {
    $status_data[] = $row;
}

// Supplier's Top Products
$top_products_query = "SELECT
    p.product_name,
    p.image,
    p.price,
    SUM(oi.quantity) as total_sold,
    SUM(oi.total) as revenue,
    COUNT(DISTINCT oi.order_id) as orders_count
    FROM order_items oi
    JOIN products p ON oi.product_id = p.product_id
    JOIN orders o ON oi.order_id = o.order_id
    WHERE oi.supplier_id = '$supplier_id'
    AND o.order_date BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'
    AND o.payment_status = 'paid'
    GROUP BY oi.product_id
    ORDER BY total_sold DESC
    LIMIT 10";

$top_products_result = mysqli_query($con, $top_products_query);
$top_products = [];
while ($row = mysqli_fetch_assoc($top_products_result)) {
    $top_products[] = $row;
}

// Daily Sales for Chart
$daily_sales_query = "SELECT
    DATE(o.order_date) as date,
    COUNT(DISTINCT oi.order_id) as orders,
    SUM(oi.total) as revenue
    FROM order_items oi
    JOIN orders o ON oi.order_id = o.order_id
    WHERE oi.supplier_id = '$supplier_id'
    AND o.order_date BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'
    AND o.payment_status = 'paid'
    GROUP BY DATE(o.order_date)
    ORDER BY date";

$daily_sales_result = mysqli_query($con, $daily_sales_query);
$daily_sales = [];
while ($row = mysqli_fetch_assoc($daily_sales_result)) {
    $daily_sales[] = $row;
}

// Recent Orders for this supplier
$recent_orders_query = "SELECT
    o.order_id,
    oi.total as item_total,
    oi.quantity,
    o.status,
    o.order_date,
    u.first_name,
    u.last_name,
    p.product_name
    FROM order_items oi
    JOIN orders o ON oi.order_id = o.order_id
    JOIN users u ON o.customer_id = u.user_id
    JOIN products p ON oi.product_id = p.product_id
    WHERE oi.supplier_id = '$supplier_id'
    AND o.order_date BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'
    ORDER BY o.order_date DESC
    LIMIT 20";

$recent_orders_result = mysqli_query($con, $recent_orders_query);
$recent_orders = [];
while ($row = mysqli_fetch_assoc($recent_orders_result)) {
    $recent_orders[] = $row;
}

// Monthly comparison
$last_month_start = date('Y-m-01', strtotime('-1 month'));
$last_month_end = date('Y-m-t', strtotime('-1 month'));

$last_month_query = "SELECT
    COUNT(DISTINCT oi.order_id) as total_orders,
    SUM(oi.total) as total_revenue
    FROM order_items oi
    JOIN orders o ON oi.order_id = o.order_id
    WHERE oi.supplier_id = '$supplier_id'
    AND o.order_date BETWEEN '$last_month_start 00:00:00' AND '$last_month_end 23:59:59'
    AND o.payment_status = 'paid'";

$last_month_result = mysqli_query($con, $last_month_query);
$last_month_data = mysqli_fetch_assoc($last_month_result);
?>

<?php include './header.php'; ?>

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    crossorigin="anonymous" />

<div class="bg-gray-900 min-h-screen p-6">
    <div class="bg-gray-800 p-8 shadow-xl rounded-xl">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-emerald-400">My Sales Dashboard 📈</h2>

            <!-- Date Filter -->
            <form method="GET" class="flex space-x-4 items-center">
                <div>
                    <label class="text-sm text-gray-300">From:</label>
                    <input type="date" name="start_date" value="<?= $start_date ?>"
                        class="bg-gray-700 text-white rounded px-3 py-1 text-sm">
                </div>
                <div>
                    <label class="text-sm text-gray-300">To:</label>
                    <input type="date" name="end_date" value="<?= $end_date ?>"
                        class="bg-gray-700 text-white rounded px-3 py-1 text-sm">
                </div>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-1 rounded text-sm">
                    <i class="fas fa-filter mr-1"></i>Filter
                </button>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-6 rounded-lg text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm">Orders</p>
                        <p class="text-3xl font-bold"><?= $total_sales['total_orders'] ?: 0 ?></p>
                        <?php
                        $orders_change = $total_sales['total_orders'] - ($last_month_data['total_orders'] ?: 0);
                        $orders_percent = $last_month_data['total_orders'] > 0 ? round(($orders_change / $last_month_data['total_orders']) * 100, 1) : 0;
                        ?>
                        <p class="text-xs text-blue-200">
                            <?= $orders_change >= 0 ? '+' : '' ?><?= $orders_change ?> from last month
                        </p>
                    </div>
                    <i class="fas fa-shopping-cart text-4xl text-blue-200"></i>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-600 to-green-700 p-6 rounded-lg text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm">Revenue</p>
                        <p class="text-3xl font-bold">$<?= number_format($total_sales['total_revenue'] ?: 0, 2) ?></p>
                        <?php
                        $revenue_change = $total_sales['total_revenue'] - ($last_month_data['total_revenue'] ?: 0);
                        ?>
                        <p class="text-xs text-green-200">
                            <?= $revenue_change >= 0 ? '+' : '' ?>$<?= number_format($revenue_change, 2) ?> from last
                            month
                        </p>
                    </div>
                    <i class="fas fa-dollar-sign text-4xl text-green-200"></i>
                </div>
            </div>

            <div class="bg-gradient-to-r from-purple-600 to-purple-700 p-6 rounded-lg text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm">Avg Order</p>
                        <p class="text-3xl font-bold">$<?= number_format($total_sales['avg_order_value'] ?: 0, 2) ?></p>
                    </div>
                    <i class="fas fa-chart-line text-4xl text-purple-200"></i>
                </div>
            </div>

            <div class="bg-gradient-to-r from-orange-600 to-orange-700 p-6 rounded-lg text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm">Items Sold</p>
                        <p class="text-3xl font-bold"><?= $total_sales['total_items_sold'] ?: 0 ?></p>
                    </div>
                    <i class="fas fa-box text-4xl text-orange-200"></i>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Daily Sales Chart -->
            <div class="bg-gray-700 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-white mb-4">Daily Sales Trend</h3>
                <canvas id="dailySalesChart" width="400" height="200"></canvas>
            </div>

            <!-- Order Status Chart -->
            <div class="bg-gray-700 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-white mb-4">Orders by Status</h3>
                <canvas id="statusChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Top Products -->
        <div class="bg-gray-700 p-6 rounded-lg mb-8">
            <h3 class="text-xl font-semibold text-white mb-4">My Top Selling Products</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-600">
                    <thead class="bg-gray-600">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Product</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Price</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Sold</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Orders</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-600">
                        <?php if (empty($top_products)): ?>
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                                    <i class="fas fa-inbox text-4xl mb-2"></i>
                                    <p>No sales data found for the selected period.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($top_products as $product): ?>
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-300">
                                        <div class="flex items-center">
                                            <img src="./product/<?= $product['image'] ?>" alt="Product"
                                                class="w-10 h-10 rounded mr-3 object-cover">
                                            <div>
                                                <div class="font-medium">
                                                    <?= htmlspecialchars(substr($product['product_name'], 0, 40)) ?>
                                                    <?= strlen($product['product_name']) > 40 ? '...' : '' ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-300">$<?= number_format($product['price'], 2) ?></td>
                                    <td class="px-4 py-3 text-sm text-gray-300"><?= $product['total_sold'] ?></td>
                                    <td class="px-4 py-3 text-sm text-gray-300"><?= $product['orders_count'] ?></td>
                                    <td class="px-4 py-3 text-sm text-gray-300">$<?= number_format($product['revenue'], 2) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-gray-700 p-6 rounded-lg">
            <h3 class="text-xl font-semibold text-white mb-4">Recent Orders</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-600">
                    <thead class="bg-gray-600">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Order ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Product</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Qty</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Action</th>

                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-600">
                        <?php if (empty($recent_orders)): ?>
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-gray-400">
                                    <i class="fas fa-inbox text-4xl mb-2"></i>
                                    <p>No orders found for the selected period.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($recent_orders as $order): ?>
                                <tr>
                                    <td class="px-4 py-3 text-sm font-medium text-white"><?= $order['order_id'] ?></td>
                                    <td class="px-4 py-3 text-sm text-gray-300">
                                        <?= htmlspecialchars(substr($order['product_name'], 0, 30)) ?>...
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-300">
                                        <?= htmlspecialchars($order['first_name'] . ' ' . $order['last_name']) ?>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-300"><?= $order['quantity'] ?></td>
                                    <td class="px-4 py-3 text-sm text-gray-300">$<?= number_format($order['item_total'], 2) ?>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="px-2 py-1 text-xs rounded-full
                                        <?php
                                        switch ($order['status']) {
                                            case 'delivered':
                                                echo 'bg-green-600 text-green-100';
                                                break;
                                            case 'shipped':
                                                echo 'bg-blue-600 text-blue-100';
                                                break;
                                            case 'processing':
                                                echo 'bg-yellow-600 text-yellow-100';
                                                break;
                                            case 'pending':
                                                echo 'bg-gray-600 text-gray-100';
                                                break;
                                            case 'cancelled':
                                                echo 'bg-red-600 text-red-100';
                                                break;
                                            default:
                                                echo 'bg-gray-600 text-gray-100';
                                        }
                                        ?>">
                                            <?= ucfirst($order['status']) ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-300">
                                        <?= date('M j, Y', strtotime($order['order_date'])) ?>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-300">
                                        <form method="POST" action="">
                                            <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                            <select name="status" class="bg-gray-700 text-white rounded px-2 py-1 text-sm">
                                                <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>
                                                    Pending</option>
                                                <option value="processing" <?= $order['status'] == 'processing' ? 'selected' : '' ?>>Processing</option>
                                                <option value="shipped" <?= $order['status'] == 'shipped' ? 'selected' : '' ?>>
                                                    Shipped</option>
                                                <option value="delivered" <?= $order['status'] == 'delivered' ? 'selected' : '' ?>>
                                                    Delivered</option>
                                                <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>
                                                    Cancelled</option>
                                            </select>
                                            <button type="submit" name="update_status"
                                                class="ml-2 bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-xs">Update</button>
                                        </form>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // Daily Sales Chart
    const dailySalesCtx = document.getElementById('dailySalesChart').getContext('2d');
    const dailySalesData = <?= json_encode($daily_sales) ?>;

    new Chart(dailySalesCtx, {
        type: 'line',
        data: {
            labels: dailySalesData.map(item => item.date),
            datasets: [{
                label: 'Revenue',
                data: dailySalesData.map(item => item.revenue),
                borderColor: 'rgb(34, 197, 94)',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                tension: 0.1,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: {
                        color: 'white'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: 'white',
                        callback: function (value) {
                            return '$' + value;
                        }
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    }
                },
                x: {
                    ticks: {
                        color: 'white'
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    }
                }
            }
        }
    });

    // Status Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusData = <?= json_encode($status_data) ?>;

    if (statusData.length > 0) {
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: statusData.map(item => item.status.charAt(0).toUpperCase() + item.status.slice(1)),
                datasets: [{
                    data: statusData.map(item => item.count),
                    backgroundColor: [
                        '#10B981', // green
                        '#3B82F6', // blue
                        '#F59E0B', // yellow
                        '#6B7280', // gray
                        '#EF4444'  // red
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            color: 'white'
                        }
                    }
                }
            }
        });
    } else {
        // Show no data message
        statusCtx.canvas.style.display = 'none';
        const noDataDiv = document.createElement('div');
        noDataDiv.className = 'flex items-center justify-center h-48 text-gray-400';
        noDataDiv.innerHTML = '<div class="text-center"><i class="fas fa-chart-pie text-4xl mb-2"></i><p>No order data available</p></div>';
        statusCtx.canvas.parentNode.appendChild(noDataDiv);
    }
</script>