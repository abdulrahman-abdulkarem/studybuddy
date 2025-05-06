<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Handle profile photo upload
    $ppPath = NULL;
    if (isset($_FILES['pp']) && $_FILES['pp']['error'] == UPLOAD_ERR_OK) {
        $pp = $_FILES['pp'];
        $fileType = strtolower(pathinfo($pp['name'], PATHINFO_EXTENSION));

        // Check if the file is a JPG or JPEG
        if ($fileType == 'jpg' || $fileType == 'jpeg') {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileName = uniqid() . '_' . basename($pp['name']);
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($pp['tmp_name'], $filePath)) {
                $ppPath = $filePath;
            } else {
                $error = 'Error uploading file';
            }
        } else {
            $error = 'Only JPG files are allowed';
        }
    }

    $sql = "INSERT INTO users (name, email, password, pp_path) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $password, $ppPath);

    if ($stmt->execute()) {
        session_start();
        $_SESSION['user_id'] = $conn->insert_id;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;
        header("Location: dashboard.php"); // Redirect to dashboard page
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
