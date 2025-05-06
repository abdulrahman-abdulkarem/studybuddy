<?php
include 'db.php'; // Include your database connection script

$search = isset($_GET['search'])? $_GET['search'] : '';
$category = isset($_GET['category'])? $_GET['category'] : 'All';

$sql = "SELECT users.name as tutor_name, users.pp_path as photo, courses.course_name, courses.course_description, courses.price 
        FROM users 
        JOIN courses ON users.id = courses.tutor_id";

if ($search != '') {
    $sql .= " WHERE (users.name LIKE? OR courses.course_name LIKE?)";
    $stmt = $conn->prepare($sql);
    $search_param = "%". $search. "%";
    $stmt->bind_param("ss", $search_param, $search_param);
} elseif ($category != 'All') {
    $sql .= " WHERE courses.course_name =?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category);
} else {
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

$tutors = [];
while ($row = $result->fetch_assoc()) {
    $tutors[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($tutors);
?>