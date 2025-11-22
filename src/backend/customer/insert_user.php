<?php
include("../../lib/database.php");

if (isset($_POST['submit'])) {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $user_name = trim($_POST['user_name']);
    $type = trim($_POST['type']);

    if ($_POST['password'] !== $_POST['password_confirmation']) {
        header("Location: ../../../login.php?pass_error=true");
        exit;
    }

    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    function generateUserId($type)
    {
        $type = strtolower(trim($type));
        $prefix = $type === 'customer' ? 'C' : ($type === 'supplier' ? 'S' : '');
        if (!$prefix)
            throw new InvalidArgumentException("Invalid user type");
        return $prefix . rand(1000, 99999);
    }

    // Ensure unique user_id
    do {
        $user_id = generateUserId($type);
        $check = mysqli_query($con, "SELECT user_id FROM users WHERE user_id='$user_id'");
    } while (mysqli_num_rows($check) > 0);

    /** IMAGE UPLOAD **/
    $imageToSave = 'default-avatar.png'; // fallback just in case
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $targetDir = "../../../uploads/";

        // Create directory if it doesn't exist
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $targetFile = $targetDir . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imageToSave = $imageName; // uploaded file
        }
    }

    $stmt = $con->prepare("INSERT INTO users
        (user_id, first_name, last_name, user_name, email, password, type, image)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind all 8 values
    $stmt->bind_param(
        "ssssssss",
        $user_id,
        $first_name,
        $last_name,
        $user_name,
        $email,
        $password,
        $type,
        $imageToSave
    );

    if ($stmt->execute()) {
        header("Location: ../../../index.php");
        exit;
    } else {
        echo "Something went wrong!! 🥲 Error: " . $stmt->error;
    }
}
?>