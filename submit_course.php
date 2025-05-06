<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $tutor_id = $_SESSION['user_id']; // Assuming you store user id in session
        $course_name = $_POST['course_name'];
        $course_description = $_POST['course_description'];
        $contact_phone = $_POST['contact_phone'];
        $price = $_POST['price'];

        // Handle file upload
        if (isset($_FILES['payment_photo']) && $_FILES['payment_photo']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['payment_photo']['tmp_name'];
            $fileName = $_FILES['payment_photo']['name'];
            $fileSize = $_FILES['payment_photo']['size'];
            $fileType = $_FILES['payment_photo']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = './uploads/';
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $payment_photo = $dest_path;

                $sql = "INSERT INTO courses (tutor_id, course_name, course_description, payment_photo, contact_phone, price) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("issssd", $tutor_id, $course_name, $course_description, $payment_photo, $contact_phone, $price);

                if ($stmt->execute()) {
                    echo json_encode(['success' => true, 'message' => 'Course added successfully!']);
                } else {
                    echo json_encode(['success' => false, 'error' => $stmt->error]);
                }

                $stmt->close();
            } else {
                echo json_encode(['success' => false, 'error' => 'File upload failed.']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'No file uploaded or file upload error.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }

    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
?>
