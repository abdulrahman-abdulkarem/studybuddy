<?php
session_start();
include 'db.php'; // Include your database connection script

$tutor_id = $_SESSION['user_id']; // Assuming you store user id in session

$sql = "SELECT * FROM courses WHERE tutor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $tutor_id);
$stmt->execute();
$result = $stmt->get_result();

$courses = [];

while ($row = $result->fetch_assoc()) {
    $courses[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($courses);
?>
