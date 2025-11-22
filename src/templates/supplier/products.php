<?php
include("../../lib/database.php");
// session_start();

$user_id = $_SESSION['user_id'];
// Fetch products from DB
function fetchProducts($con, $user_id)
{
    $products = [];
    $sql = "SELECT product_id, product_name, categories, qty, price FROM products Where user_id = '$user_id' ORDER BY id DESC";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
    }
    return $products;
}
?>


<div class="bg-gray-800 p-8 rounded-lg shadow-xl">
    <h2 class="text-3xl font-bold text-emerald-400 mb-6">Product Management 🌿</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-700">
                <tr>
                    <th scope="col" class="py-3.5 px-4 text-left text-sm font-semibold text-gray-300">Product Name</th>
                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-300">Category</th>
                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-300">Stock</th>
                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-300">Price</th>
                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-300">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800 bg-gray-800">
                <?php
                $products = fetchProducts($con, $user_id);
                if (!empty($products)) {
                    foreach ($products as $product) {
                        echo "<tr>";
                        echo "<td class='px-4 py-4 text-sm font-medium text-gray-200'>" . htmlspecialchars($product['product_name']) . "</td>";
                        echo "<td class='px-4 py-4 text-sm text-gray-400'>" . htmlspecialchars($product['categories']) . "</td>";
                        echo "<td class='px-4 py-4 text-sm text-gray-400'>" . htmlspecialchars($product['qty']) . "</td>";
                        echo "<td class='px-4 py-4 text-sm text-gray-400'>$" . number_format($product['price'], 2) . "</td>";

                        // Action column
                        echo "<td class='px-4 py-4 text-sm text-gray-400 flex gap-2'>";

                        // Update button (redirect to edit page with product_id)
                        echo "<a href='../../backend/supplier/update_product.php?id=" . urlencode($product['product_id']) . "'
                class='bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs'>
                Update
              </a>";

                        // Delete button (calls delete script with confirmation)
                        echo "<a href='../../backend/supplier/delete_product.php?id=" . urlencode($product['product_id']) . "'
                onclick=\"return confirm('Are you sure you want to delete this product?');\"
                class='bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs'>
                Delete
              </a>";

                        echo "</td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='px-4 py-4 text-center text-sm text-gray-400'>No products found</td></tr>";
                }
                ?>

            </tbody>
        </table>
    </div>
</div>