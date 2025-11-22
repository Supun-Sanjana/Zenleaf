<?php
include("../../lib/database.php");
include("../../backend/admin/admin_auth.php");

checkAdmin(); // Ensure admin is logged in

// Get date range from query parameters
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01'); // First day of current month
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d'); // Today

// Total Sales Query
$total_sales_query = "SELECT
    COUNT(DISTINCT o.order_id) as total_orders,
    SUM(o.total_amount) as total_revenue,
    AVG(o.total_amount) as avg_order_value
    FROM orders o
    WHERE o.order_date BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'
    AND o.payment_status = 'paid'";

$total_sales_result = mysqli_query($con, $total_sales_query);
$total_sales = mysqli_fetch_assoc($total_sales_result);

// Sales by Status
$status_query = "SELECT
    status,
    COUNT(*) as count,
    SUM(total_amount) as revenue
    FROM orders
    WHERE order_date BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'
    GROUP BY status
    ORDER BY count DESC";

$status_result = mysqli_query($con, $status_query);
$status_data = [];
while ($row = mysqli_fetch_assoc($status_result)) {
    $status_data[] = $row;
}

// Top Products
$top_products_query = "SELECT
    p.product_name,
    p.image,
    SUM(oi.quantity) as total_sold,
    SUM(oi.total) as revenue,
    COUNT(DISTINCT oi.order_id) as orders_count
    FROM order_items oi
    JOIN products p ON oi.product_id = p.product_id
    JOIN orders o ON oi.order_id = o.order_id
    WHERE o.order_date BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'
    AND o.payment_status = 'paid'
    GROUP BY oi.product_id
    ORDER BY total_sold DESC
    LIMIT 10";

$top_products_result = mysqli_query($con, $top_products_query);
$top_products = [];
while ($row = mysqli_fetch_assoc($top_products_result)) {
    $top_products[] = $row;
}

// Top Suppliers
$top_suppliers_query = "SELECT
    u.user_name,
    u.first_name,
    u.last_name,
    COUNT(DISTINCT oi.order_id) as orders_count,
    SUM(oi.total) as revenue,
    SUM(oi.quantity) as items_sold
    FROM order_items oi
    JOIN users u ON oi.supplier_id = u.user_id
    JOIN orders o ON oi.order_id = o.order_id
    WHERE o.order_date BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'
    AND o.payment_status = 'paid'
    GROUP BY oi.supplier_id
    ORDER BY revenue DESC
    LIMIT 10";

$top_suppliers_result = mysqli_query($con, $top_suppliers_query);
$top_suppliers = [];
while ($row = mysqli_fetch_assoc($top_suppliers_result)) {
    $top_suppliers[] = $row;
}

// Daily Sales for Chart
$daily_sales_query = "SELECT
    DATE(order_date) as date,
    COUNT(*) as orders,
    SUM(total_amount) as revenue
    FROM orders
    WHERE order_date BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'
    AND payment_status = 'paid'
    GROUP BY DATE(order_date)
    ORDER BY date";

$daily_sales_result = mysqli_query($con, $daily_sales_query);
$daily_sales = [];
while ($row = mysqli_fetch_assoc($daily_sales_result)) {
    $daily_sales[] = $row;
}

// Recent Orders
$recent_orders_query = "SELECT
    o.order_id,
    o.total_amount,
    o.status,
    o.order_date,
    u.first_name,
    u.last_name,
    COUNT(oi.id) as items_count
    FROM orders o
    JOIN users u ON o.customer_id = u.user_id
    LEFT JOIN order_items oi ON o.order_id = oi.order_id
    WHERE o.order_date BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'
    GROUP BY o.order_id
    ORDER BY o.order_date DESC
    LIMIT 20";

$recent_orders_result = mysqli_query($con, $recent_orders_query);
$recent_orders = [];
while ($row = mysqli_fetch_assoc($recent_orders_result)) {
    $recent_orders[] = $row;
}
?>

<?php include './header.php'; ?>

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" />

<div class="bg-gray-800 min-h-screen p-6">
    <div class="bg-gray-900 p-8 shadow-xl rounded-xl">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-emerald-400">Sales Dashboard 📊</h2>

            <!-- Date Filter -->
            <form method="GET" class="flex space-x-4 items-center">
                <div>
                    <label class="text-sm text-gray-300">From:</label>
                    <input type="date" name="start_date" value="<?= $start_date ?>" class="bg-gray-700 text-white rounded px-3 py-1 text-sm">
                </div>
                <div>
                    <label class="text-sm text-gray-300">To:</label>
                    <input type="date" name="end_date" value="<?= $end_date ?>" class="bg-gray-700 text-white rounded px-3 py-1 text-sm">
                </div>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-1 rounded text-sm">
                    <i class="fas fa-filter mr-1"></i>Filter
                </button>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-6 rounded-lg text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm">Total Orders</p>
                        <p class="text-3xl font-bold"><?= $total_sales['total_orders'] ?: 0 ?></p>
                    </div>
                    <i class="fas fa-shopping-cart text-4xl text-blue-200"></i>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-600 to-green-700 p-6 rounded-lg text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm">Total Revenue</p>
                        <p class="text-3xl font-bold">$<?= number_format($total_sales['total_revenue'] ?: 0, 2) ?></p>
                    </div>
                    <i class="fas fa-dollar-sign text-4xl text-green-200"></i>
                </div>
            </div>

            <div class="bg-gradient-to-r from-purple-600 to-purple-700 p-6 rounded-lg text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm">Avg Order Value</p>
                        <p class="text-3xl font-bold">$<?= number_format($total_sales['avg_order_value'] ?: 0, 2) ?></p>
                    </div>
                    <i class="fas fa-chart-line text-4xl text-purple-200"></i>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Daily Sales Chart -->
            <div class="bg-gray-800 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-white mb-4">Daily Sales Trend</h3>
                <canvas id="dailySalesChart" width="400" height="200"></canvas>
            </div>

            <!-- Order Status Chart -->
            <div class="bg-gray-800 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-white mb-4">Orders by Status</h3>
                <canvas id="statusChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Data Tables Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Top Products -->
            <div class="bg-gray-800 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-white mb-4">Top Products</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Product</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Sold</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Revenue</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            <?php foreach ($top_products as $product): ?>
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-300">
                                    <div class="flex items-center">
                                        <img src="../supplier/product/<?= $product['image'] ?>" alt="Product" class="w-8 h-8 rounded mr-3 object-cover">
                                        <?= htmlspecialchars(substr($product['product_name'], 0, 30)) ?>...
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-300"><?= $product['total_sold'] ?></td>
                                <td class="px-4 py-3 text-sm text-gray-300">$<?= number_format($product['revenue'], 2) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Top Suppliers -->
            <div class="bg-gray-800 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-white mb-4">Top Suppliers</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Supplier</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Orders</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Revenue</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            <?php foreach ($top_suppliers as $supplier): ?>
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-300">
                                    <?= htmlspecialchars($supplier['first_name'] . ' ' . $supplier['last_name']) ?>
                                    <br><span class="text-xs text-gray-500">@<?= htmlspecialchars($supplier['user_name']) ?></span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-300"><?= $supplier['orders_count'] ?></td>
                                <td class="px-4 py-3 text-sm text-gray-300">$<?= number_format($supplier['revenue'], 2) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-gray-800 p-6 rounded-lg">
            <h3 class="text-xl font-semibold text-white mb-4">Recent Orders</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Order ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Items</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        <?php foreach ($recent_orders as $order): ?>
                        <tr>
                            <td class="px-4 py-3 text-sm font-medium text-white"><?= $order['order_id'] ?></td>
                            <td class="px-4 py-3 text-sm text-gray-300"><?= htmlspecialchars($order['first_name'] . ' ' . $order['last_name']) ?></td>
                            <td class="px-4 py-3 text-sm text-gray-300"><?= $order['items_count'] ?> items</td>
                            <td class="px-4 py-3 text-sm text-gray-300">$<?= number_format($order['total_amount'], 2) ?></td>
                            <td class="px-4 py-3 text-sm">
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
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-300"><?= date('M j, Y', strtotime($order['order_date'])) ?></td>
                            <td class="px-4 py-3 text-sm">
                                <a href="order_details.php?id=<?= $order['order_id'] ?>" class="text-emerald-400 hover:text-emerald-300">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
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
            tension: 0.1
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
                    callback: function(value) {
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
</script>