<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

if ($role == 'student') {
    // Fetch bookings for student
    $query = "SELECT bookings.id, users.name AS tutor_name, courses.course_name, bookings.status 
              FROM bookings 
              JOIN users ON bookings.tutor_id = users.id 
              JOIN courses ON bookings.course_id = courses.id 
              WHERE bookings.student_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $bookings = $result->fetch_all(MYSQLI_ASSOC);
} elseif ($role == 'tutor') {
    // Fetch student requests for tutor
    $query = "SELECT bookings.id, users.name AS student_name, courses.course_name, bookings.status 
              FROM bookings 
              JOIN users ON bookings.student_id = users.id 
              JOIN courses ON bookings.course_id = courses.id 
              WHERE bookings.tutor_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $requests = $result->fetch_all(MYSQLI_ASSOC);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid user role']);
    exit;
}

echo json_encode([
    'data' => $role == 'student' ? $bookings : $requests
]);

$stmt->close();
$conn->close();
?>
