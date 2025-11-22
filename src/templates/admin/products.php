<?php
include("../../lib/database.php");

// This will check if admin is logged in, otherwise redirect
checkAdmin();

// Fetch products from DB
function fetchProducts($con)
{
    $products = [];
    $sql = "SELECT product_id, product_name, categories, qty, price, approve FROM products ORDER BY id DESC";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
    }
    return $products;
}

// Handle product approve toggle via GET
if (isset($_GET['toggle_approve'])) {
    $product_id = $_GET['toggle_approve'];

    // Get current approve status
    $res = mysqli_query($con, "SELECT approve FROM products WHERE product_id='$product_id'");
    if (mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        $newStatus = $row['approve'] ? 0 : 1;
        mysqli_query($con, "UPDATE products SET approve='$newStatus' WHERE product_id='$product_id'");
    }

    // Redirect to same page to avoid query resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
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
                $products = fetchProducts($con);
                if (!empty($products)) {
                    foreach ($products as $product) {
                        echo "<tr>";
                        echo "<td class='px-4 py-4 text-sm font-medium text-gray-200'>" . htmlspecialchars($product['product_name']) . "</td>";
                        echo "<td class='px-4 py-4 text-sm text-gray-400'>" . htmlspecialchars($product['categories']) . "</td>";
                        echo "<td class='px-4 py-4 text-sm text-gray-400'>" . htmlspecialchars($product['qty']) . "</td>";
                        echo "<td class='px-4 py-4 text-sm text-gray-400'>$" . number_format($product['price'], 2) . "</td>";

                        // Action column
                        echo "<td class='px-4 py-4 text-sm text-gray-400 flex gap-2'>";

                        // Approve / Disapprove toggle button
                        if ($product['approve']) {
                            echo "<a href='?toggle_approve=" . urlencode($product['product_id']) . "'
                                  class='bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs'>
                                  Disapprove
                                  </a>";
                        } else {
                            echo "<a href='?toggle_approve=" . urlencode($product['product_id']) . "'
                                  class='bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs'>
                                  Approve
                                  </a>";
                        }

                        // Delete button
                        echo "<a href='../../backend/admin/delete_product.php?id=" . urlencode($product['product_id']) . "'
                              onclick=\"return confirm('Are you sure you want to delete this product?');\"
                              class='bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded text-xs'>
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
