<?php
session_start();
include("../lib/database.php");

// Expect product_id as string (e.g. "P12345") and qty as integer
if (isset($_POST['product_id'], $_POST['qty'])) {
    $product_id = trim($_POST['product_id']); // keep as string
    $qty = intval($_POST['qty']);
    if ($qty < 1) $qty = 1;

    // Fetch product by product_id (string)
    $sql = "SELECT * FROM products WHERE product_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $product_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($product = mysqli_fetch_assoc($result)) {
        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Use product_id (string) as the session key so different products don't collide
        if (isset($_SESSION['cart'][$product_id])) {
            // Update quantity
            $_SESSION['cart'][$product_id]['quantity'] += $qty;

            // Optional: cap at stock
            if (isset($product['qty']) && $_SESSION['cart'][$product_id]['quantity'] > (int)$product['qty']) {
                $_SESSION['cart'][$product_id]['quantity'] = (int)$product['qty'];
                $_SESSION['error'] = "Only {$product['qty']} items available in stock.";
            }
        } else {
            // New product entry (use 'quantity' everywhere)
            $_SESSION['cart'][$product_id] = [
                'product_id' => $product_id,
                'name'       => $product['product_name'],
                'price'      => (float)$product['price'],
                'image'      => $product['image'],
                'quantity'   => $qty

            ];
        }

        $_SESSION['success'] = "{$product['product_name']} added to cart!";
        header("Location: ../../shop.php");
        exit;
    } else {
        $_SESSION['error'] = "Product not found!";
        header("Location: ../../shop.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Invalid request!";
    header("Location: ../../shop.php");
    exit;
}