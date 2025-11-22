<?php
include __DIR__ . '/../../lib/database.php';


if (!file_exists(__DIR__ . '/../../lib/database.php')) {
    die("Database file not found!");
}

if (!isset($con)) {
    die("Database not loaded!");
}
// Fetch all approved products
$sql = "SELECT * FROM products WHERE approve = 1 ORDER BY id DESC";
$result = mysqli_query($con, $sql);

$categories = [];

// Organize products category-wise
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Split categories by comma
        $productCategories = explode(",", $row['categories']);

        foreach ($productCategories as $cat) {
            $cat = trim($cat); // remove extra spaces
            $categories[$cat][] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Landing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6 m-5">

<?php foreach ($categories as $categoryName => $products): ?>
    <div class="m-12">
        <h2 class="text-2xl font-bold text-emerald-600 mb-6"><?= ucfirst($categoryName) ?></h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8 mb-12">
        <?php foreach ($products as $product): ?>
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                <div class="h-25 bg-gradient-to-br from-pink-100 to-pink-200 flex items-center justify-center">
                    <img src="./src/templates/supplier/product/<?= htmlspecialchars($product['image']) ?>"
                         alt="<?= htmlspecialchars($product['product_name']) ?>"
                         class="w-full h-[200px] object-cover">
                </div>
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-2"><?= htmlspecialchars($product['product_name']) ?></h4>
                    <p class="text-gray-600 text-sm mb-4"><?= htmlspecialchars($product['discription']) ?></p>
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-bold text-pink-600">$<?= number_format($product['price'], 2) ?></span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    </div>
<?php endforeach; ?>

</body>
</html>
