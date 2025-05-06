<?php
session_start();
include 'config.php';

$student_id = $_SESSION['user_id'];
$tutor_id = $_POST['tutor_id'];
$course_id = $_POST['course_id'];

$query = "INSERT INTO bookings (student_id, tutor_id, course_id) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("iii", $student_id, $tutor_id, $course_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}
?>
