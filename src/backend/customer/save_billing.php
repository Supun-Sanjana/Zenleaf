<?php
session_start();

include('../../lib/database.php');

if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $city = trim($_POST['city']);
    $postal_code = trim($_POST['postal_code']);

    $shipping_address = $address . ", " . $city;

    $cart = $_SESSION['cart'];
    $user_id = $_SESSION['user_id'];

    // Update cart quantities from form
    if (isset($_POST['quantity']) && is_array($_POST['quantity'])) {
        foreach ($_POST['quantity'] as $product_id => $qty) {
            $qty = (int) $qty;
            if ($qty < 1)
                $qty = 1;
            if (isset($cart[$product_id])) {
                $cart[$product_id]['quantity'] = $qty;
            }
        }
        $_SESSION['cart'] = $cart; // save updated quantities back to session
    }

    $total = 0.0;
    $itemCount = 0;
    foreach ($cart as $item) {
        $qty = isset($item['quantity']) ? (int) $item['quantity'] : 1;
        $price = isset($item['price']) ? (float) $item['price'] : 0.0;
        $total += $qty * $price;


    }
}

// Generate order ID
do {
    $order_id = "O" . rand(10000, 99999);
    $check = $con->prepare("SELECT order_id FROM orders WHERE order_id = ?");
    $check->bind_param("s", $order_id);
    $check->execute();
    $check->store_result();
    $exists = $check->num_rows > 0;
    $check->close();
} while ($exists);

$status = "pending";
$payment_status = "paid";

$sql = "INSERT INTO orders (order_id, customer_id, 	total_amount, status ,payment_status ,shipping_address ,phone_number) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "sssssss", $order_id, $user_id, $total, $status, $payment_status, $shipping_address, $phone);
mysqli_stmt_execute($stmt);

foreach ($cart as $item) {
    $product_id = $item['product_id'];
    $qty = isset($item['quantity']) ? (int) $item['quantity'] : 1;

    $pro_sql = "UPDATE products SET qty = qty - ? WHERE product_id = ?";
    $pro_stmt = mysqli_prepare($con, $pro_sql);
    mysqli_stmt_bind_param($pro_stmt, "ii", $qty, $product_id);
    mysqli_stmt_execute($pro_stmt);
    mysqli_stmt_close($pro_stmt);
}

foreach ($cart as $item) {
    $product_id = $item['product_id'];
    $supplier_id = $item['supplier_id'] ?? ''; // use if you have it
    $quantity = (int) $item['quantity'];
    $price = (float) $item['price'];
    $total = $quantity * $price;

    $sql = "INSERT INTO order_items (order_id, product_id, supplier_id, quantity, price, total) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sssidd", $order_id, $product_id, $user_id, $quantity, $price, $total);
    $stmt->execute();
    $stmt->close();
}


unset($_SESSION['cart']);

header("Location: ../../templates/shared/checkout.php");
exit;


?>