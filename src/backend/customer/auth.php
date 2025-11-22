<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Include the working database connection
include '../../lib/database.php';

// Only process if form submitted
if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Prepare query
    $stmt = $con->prepare("SELECT user_id, user_name, first_name, last_name , email, password, type, approve FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $row = $result->fetch_assoc()) {

        if (password_verify($password, $row['password'])) {

            // Set session variables
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['last_name'] = $row['last_name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['type'] = $row['type'];
            $_SESSION['approve'] = $row['approve'];

            // Redirect based on type using relative paths
            if ($row['type'] === 'supplier') {
                header("Location: ../../templates/supplier/index.php");
            } elseif ($row['type'] === 'admin') {
                header("Location: ../../templates/admin/index.php");
            } else {
                header("Location: ../../../index.php");
            }
            exit;

        } else {
            // Wrong password
            header("Location: ../../../login.php?error=wrong_password");
            exit;
        }

    } else {
        // User not found
        header("Location: ../../../login.php?error=user_not_found");
        exit;
    }
} else {
    // Form not submitted
    header("Location: ../../../login.php");
    exit;
}