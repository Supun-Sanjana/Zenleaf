<?php
include("../../lib/database.php");
session_start();

if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $stmt = $con->prepare("SELECT user_id, user_name, password, type FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $row = $result->fetch_assoc()) {

        if (password_verify($password, $row['password'])) {

            if (strtolower($row['type']) === 'admin') {
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['user_name'] = $row['user_name'];
                $_SESSION['type'] = trim($row['type']); // ✅ fixed

                header("Location: ../../templates/admin/index.php");
                exit;
            } else {

                header("Location: ../../templates/admin/login.php?error=invalid_type");
                exit;
            }

        } else {

            header("Location: ../../templates/admin/login.php?error=wrong_password");
            exit;
        }
    } else {

        header("Location: ../../templates/admin/login.php?error=user_not_found");
        exit;
    }
}

function checkAdmin()
{
    if (!isset($_SESSION['type']) || strtolower($_SESSION['type']) !== 'admin') {
        header("Location: login.php?error=not_logged_in");
        exit;
    }
}
?>