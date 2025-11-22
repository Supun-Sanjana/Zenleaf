<?php
require_once './src/templates/shared/header.php';
include("./src/lib/database.php");

$sql = "SELECT * FROM products WHERE approve = 1 ORDER BY id DESC";
$result = mysqli_query($con, $sql);


$categoryColors = [
    'flowering' => 'bg-pink-500',
    'miniature' => 'bg-blue-500',
    'indoor' => 'bg-green-500',
    'accessories' => 'bg-yellow-500',

];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
    <div class="m-5 ml-10 mx-auto">
        <h1 class="text-3xl font-bold text-emerald-700 mb-6">Products</h1>
        <div class="mb-4">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="bg-green-500 w-[300px] text-white px-4 py-2 mb-4 rounded">
                    <?= $_SESSION['success'];
                    unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-500 text-white px-4 py-2 mb-4 rounded">
                    <?= $_SESSION['error'];
                    unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="bg-white rounded-lg shadow-lg p-4 flex flex-col">
                        <img src="src/templates/supplier/product/<?= htmlspecialchars($row['image']) ?>"
                            alt="<?= htmlspecialchars($row['product_name']) ?>"
                            class="w-full h-48 object-cover rounded-md mb-4">
                        <h3 class="text-lg font-bold text-gray-800"><?= htmlspecialchars($row['product_name']) ?></h3>
                        <p class="text-gray-600 text-sm mb-2"><?= htmlspecialchars($row['discription']) ?></p>

                        <!-- Categories as badges -->
                        <div class="flex flex-wrap gap-2 mb-2">
                            <?php
                            $categories = explode(',', $row['categories']);
                            foreach ($categories as $cat):
                                $cat = trim($cat);
                                $color = $categoryColors[$cat] ?? 'bg-gray-400';
                                ?>
                                <span class="text-white text-xs font-semibold px-2 py-1 rounded <?= $color ?>">
                                    <?= ucfirst($cat) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>

                        <p class="text-gray-800 font-semibold mb-2">$<?= number_format($row['price'], 2) ?></p>
                        <form action="./src/backend/add_to_cart.php" method="POST" class="mt-auto">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($row['product_id']) ?>">

                            <div class="flex gap-6">
                                <input type="number" name="qty" value="1" min="1" max="<?= $row['qty'] ?>"
                                    class="w-full mb-2 px-2 py-1 border rounded-md">
                                <button type="submit"
                                    class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-2 rounded-md font-semibold">
                                    Add to Cart
                                </button>
                            </div>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="col-span-full text-center text-gray-600">No products available.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>