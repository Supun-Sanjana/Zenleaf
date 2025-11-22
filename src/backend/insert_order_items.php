<?php
session_start();
include("../lib/database.php");

// Make sure user logged in
if (!isset($_SESSION['user_id'])) {
    die("User not logged in");
}

// Make sure cart exists
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("Cart is empty");
}

// Generate unique order ID
$order_id = "O" . rand(10000, 99999);

// Supplier ID (from logged in user)
$supplier_id = $_SESSION['user_id'];

// Loop through cart items and insert into DB
foreach ($_SESSION['cart'] as $item) {
    $product_id = $item['product_id'];
    $quantity   = $item['quantity'];
    $price      = $item['price'];
    $total      = $price * $quantity;

    $sql = "INSERT INTO order_items (order_id, product_id, supplier_id, quantity, price, total)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "sssidd", $order_id, $product_id, $supplier_id, $quantity, $price, $total);

    if (!mysqli_stmt_execute($stmt)) {
        echo "Error inserting $product_id: " . mysqli_error($con);
    }
}

// Optionally clear cart after placing order
unset($_SESSION['cart']);

echo "Order saved successfully! Order ID: $order_id";
?>
