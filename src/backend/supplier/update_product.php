<?php
include("../../lib/database.php");
session_start();

// Make sure the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Access denied. Please login first.");
}

// Get product ID from URL
if (!isset($_GET['id'])) {
    die("Product ID not specified.");
}

$product_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Fetch product details
$result = mysqli_query($con, "SELECT * FROM products WHERE product_id='$product_id' AND user_id='$user_id'");
if (mysqli_num_rows($result) == 0) {
    die("Product not found or you don't have permission.");
}

$product = mysqli_fetch_assoc($result);

// If form submitted, update product
if (isset($_POST['update_product'])) {
    $name = mysqli_real_escape_string($con, $_POST['product_name']);
    $categories = isset($_POST['category']) ? implode(',', $_POST['category']) : '';
    $qty = intval($_POST['qty']);
    $price = floatval($_POST['price']);

    $update = mysqli_query($con, "UPDATE products SET
        product_name='$name',
        categories='$categories',
        qty='$qty',
        price='$price'
        WHERE product_id='$product_id' AND user_id='$user_id'");

    if ($update) {
        header("Location: ../../templates/supplier/index.php?msg=updated");
        exit;
    } else {
        echo "Error updating product: " . mysqli_error($con);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Hide the actual checkbox */
        .category-badge input[type="checkbox"] {
            display: none;
            padding: 5px;
            border-radius: 5px;
        }

        /* Default badge style */
        .category-badge span {
            @apply px-3 py-1 rounded-full cursor-pointer text-white transition-colors;
        }

        /* Checked badge style */
        .category-badge input[type="checkbox"]:checked+span {
            @apply ring-2 ring-emerald-500 bg-emerald-500;
        }

        /* Unchecked badge default colors (set via inline classes) */
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <form method="POST" class="w-full max-w-lg p-6 bg-white rounded-lg shadow-md space-y-6">

        <!-- Product Name -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Product Name:</label>
            <input type="text" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
        </div>

        <!-- Categories -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Categories:</label>
            <div class="flex flex-wrap gap-3">
                <div class="flex flex-wrap gap-3">
                    <?php
                    $all_categories = ['indoor', 'flowering', 'miniature', 'accessories'];
                    $selected_categories = explode(',', $product['categories']);
                    $colors = [
                        'indoor' => 'bg-blue-500',
                        'flowering' => 'bg-pink-500',
                        'miniature' => 'bg-purple-500',
                        'accessories' => 'bg-yellow-500'
                    ];
                    foreach ($all_categories as $cat) {
                        $checked = in_array($cat, $selected_categories) ? 'checked' : '';
                        echo "<label class='relative cursor-pointer'>
            <input type='checkbox' name='category[]' value='$cat' $checked class='hidden peer'>
            <span class='{$colors[$cat]} capitalize px-4 py-2 rounded-full text-white transition-all duration-200
                         peer-checked:ring-2 peer-checked:ring-emerald-500 peer-checked:bg-emerald-500'>
              $cat
            </span>
          </label>";
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Quantity -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Quantity:</label>
            <input type="number" name="qty" value="<?php echo $product['qty']; ?>" required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
        </div>

        <!-- Price -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Price:</label>
            <input type="text" name="price" value="<?php echo $product['price']; ?>" required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" name="update_product"
                class="w-full bg-emerald-500 text-white font-semibold px-4 py-2 rounded-md hover:bg-emerald-600 transition-colors">
                Update Product
            </button>
        </div>

    </form>

</body>

</html>