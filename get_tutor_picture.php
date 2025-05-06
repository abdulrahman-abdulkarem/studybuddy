<?php
session_start();
include 'db.php'; // Include your database connection script

$user_id = $_SESSION['user_id']; // Assuming you store user id in session

if ($user_id) {
    $sql = "SELECT profile_picture FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode(['pp_path' => $user['profile_picture']]);
    } else {
        echo json_encode(['pp_path' => '']);
    }

    $stmt->close();
} else {
    echo json_encode(['pp_path' => '']);
}

$conn->close();
?>
