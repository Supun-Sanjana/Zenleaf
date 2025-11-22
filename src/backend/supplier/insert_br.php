<?php
include("../../lib/database.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// ✅ Check if supplier already uploaded a BR
$check = $con->prepare("SELECT id FROM business_reg WHERE user_id = ?");
$check->bind_param("s", $user_id);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo "<p class='text-red-600 font-bold'>You have already submitted a business registration file. Please wait for admin review.</p>";
    $check->close();
    exit;
}
$check->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $business_name = trim($_POST['business-name']);
    $full_name = trim($_POST['full-name']);
    $address = trim($_POST['address']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    if (isset($_FILES['br-file']) && $_FILES['br-file']['error'] === 0) {
        $file_tmp = $_FILES['br-file']['tmp_name'];
        $file_name = time() . "_" . basename($_FILES['br-file']['name']);

        // Server path where file will be stored
        $target_dir = __DIR__ . "/../../uploads/business_files/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $target_file = $target_dir . $file_name;

        // Web-accessible path to store in DB
        $web_path = "/uploads/business_files/" . $file_name;

        if (move_uploaded_file($file_tmp, $target_file)) {
            $stmt = $con->prepare("INSERT INTO business_reg (user_id, b_name, b_address, full_name, email, p_number, b_certificate) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $user_id, $business_name, $address, $full_name, $email, $phone, $web_path);

            if ($stmt->execute()) {
                echo "<p class='text-green-600 font-bold'>Business registered successfully!</p>";
            } else {
                echo "<p class='text-red-600 font-bold'>Error: " . $stmt->error . "</p>";
            }

            $stmt->close();
        } else {
            echo "<p class='text-red-600 font-bold'>Failed to upload file.</p>";
        }

    } else {
        echo "<p class='text-red-600 font-bold'>Please upload a valid file.</p>";
    }
}
?>
