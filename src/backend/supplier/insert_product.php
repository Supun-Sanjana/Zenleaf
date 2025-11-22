<?php
include("../../lib/database.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    die("User not logged in");
}
$user_id = $_SESSION['user_id'];
$approve = $_SESSION['approve'] ?? 0;

if ($approve != 1) {
    $_SESSION['error_message'] = "Your seller account is under review. You cannot add products until approved by admin.";
    header("Location: ../../templates/supplier/index.php");
    exit();
}

$errors = [];
$success = "";

    if (isset($_POST['submit'])) {
        // Sanitize and validate inputs
        $product_name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];

        // 1. Product name validation
        if (empty($product_name)) {
            $errors[] = "Product name is required.";
        } elseif (strlen($product_name) < 3) {
            $errors[] = "Product name must be at least 3 characters long.";
        }

        // 2. Description validation
        if (empty($description)) {
            $errors[] = "Description is required.";
        } elseif (strlen($description) > 500) {
            $errors[] = "Description cannot exceed 500 characters.";
        }

        // 3. Price validation
        if (!is_numeric($price) || $price <= 0) {
            $errors[] = "Please enter a valid price greater than 0.";
        }

        // 4. Quantity validation
        if (!is_numeric($quantity) || $quantity < 0) {
            $errors[] = "Quantity must be 0 or more.";
        }

        // 5. Category validation
        if (!empty($_POST['category'])) {
            $categories = $_POST['category'];
            $allowed_categories = ['indoor', 'flowering', 'miniature', 'accessories'];
            foreach ($categories as $cat) {
                if (!in_array($cat, $allowed_categories)) {
                    $errors[] = "Invalid category selected.";
                }
            }
            $category_str = implode(',', $categories);
        } else {
            $errors[] = "Please select at least one category.";
        }

        // 6. Image validation
        $imageToSave = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $max_size = 2 * 1024 * 1024; // 2MB

            if (!in_array($_FILES['image']['type'], $allowed_types)) {
                $errors[] = "Only JPG, PNG, and GIF images are allowed.";
            } elseif ($_FILES['image']['size'] > $max_size) {
                $errors[] = "Image size must be less than 2MB.";
            } else {
                $imageName = time() . '_' . basename($_FILES['image']['name']);
                $targetDir = "../../templates/supplier/product/";
                $targetFile = $targetDir . $imageName;

                // Create directory if it doesn't exist
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0755, true);
                }

                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    $imageToSave = $imageName;
                } else {
                    $errors[] = "Failed to upload image. Check directory permissions.";
                }
            }
        } else {
            $errors[] = "Please upload a product image.";
        }

        // If no errors, insert product
        if (empty($errors)) {
            // Product ID generator
            function generateProductId($con)
            {
                do {
                    $product_id = 'P' . rand(10000, 99999);
                    $check = mysqli_query($con, "SELECT product_id FROM products WHERE product_id='$product_id'");
                } while (mysqli_num_rows($check) > 0);
                return $product_id;
            }

            $product_id = generateProductId($con);

            $sql = "INSERT INTO products (product_id, user_id, product_name, categories, discription, price, image, qty)
                VALUES ('$product_id','$user_id', '$product_name', '$category_str', '$description', '$price', '$imageToSave', '$quantity')";

            if (mysqli_query($con, $sql)) {
                $_SESSION['success'] = "Product added successfully!";
            } else {
                $errors[] = "Database error: " . mysqli_error($con);
            }
        }

        // Store errors in session if any
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
        }

        // Redirect back to form
        header("Location: ../../templates/supplier/add_product.php");
        exit();
    }

