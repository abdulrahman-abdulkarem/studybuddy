<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $current_password = $_POST['current_password'];
  $new_password = $_POST['new_password'];
  $confirm_password = $_POST['confirm_password'];
  $ppPath = NULL;

  // Check if the current password is correct
  $sql = "SELECT password, pp_path FROM users WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $hashed_password = $row['password'];
  $old_ppPath = $row['pp_path'];

  if (password_verify($current_password, $hashed_password)) {
    // Update password if new password is provided
    if (!empty($new_password) && !empty($confirm_password)) {
      if ($new_password == $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $hashed_password, $user_id);
        $stmt->execute();
      } else {
        $error = 'New password and confirm password do not match';
      }
    }

    // Update email
    $sql = "UPDATE users SET email=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $email, $user_id);
    $stmt->execute();

    // Update name
    $sql = "UPDATE users SET name=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $name, $user_id);
    $stmt->execute();

    // Update profile photo
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

          // Update the database with the image path
          $sql = "UPDATE users SET pp_path=? WHERE id=?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("si", $ppPath, $user_id);
          $stmt->execute();

          // Optionally: Delete the old profile picture if one exists
          if ($old_ppPath && file_exists($old_ppPath)) {
            unlink($old_ppPath);
          }
        } else {
          $error = 'Error uploading file';
        }
      } else {
        $error = 'Only JPG files are allowed';
      }
    }

    $_SESSION['user_name'] = $name;
    $_SESSION['user_email'] = $email;
    header("Location: dashboard.php");
    exit();
  } else {
    $error = 'Current password is incorrect';
  }

  $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="edit_profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
</head>
<body>
  <div class="container">
    <nav>
      <ul>
        <li><a href="#" class="logo">
          <img src="images/logo.png">
          <span class="nav-item">StudyBuddy</span>
        </a></li>
        <li><a href="home.html">
          <i class="fas fa-home"></i>
          <span class="nav-item">Home</span>
        </a></li>
        <li><a href="find_tutor.php">
          <i class="fas fa-chalkboard-teacher"></i>
          <span class="nav-item">Find tutor</span>
        </a></li>
        <li><a href="my_courses.php">
          <i class="fas fa-book"></i>
          <span class="nav-item">My courses</span>
        </a></li>
        <li><a href="dashboard.php">
          <i class="fas fa-chart-bar"></i>
          <span class="nav-item">Dashboard</span>
        </a></li>
        <li><a href="edit_profile.php" class="editprofile">
          <i class="fas fa-user-edit"></i>
          <span class="nav-item">Edit profile</span>
        </a></li>
        <li><a href="logout.php" class="logout">
          <i class="fas fa-sign-out-alt"></i>
          <span class="nav-item">Log out</span>
        </a></li>
      </ul>
    </nav>
    <section class="main">
      <div class="main-top">
        <h1>Edit your profile</h1>
      </div>
      <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_SESSION['user_name']);?>"><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : ''; ?>"><br><br>
        <label for="current_password">Current Password:</label>
        <input type="password" id="current_password" name="current_password"><br><br>
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password"><br><br>
        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" id="confirm_password" name="confirm_password"><br><br>
        <label for="pp">Profile Photo:</label>
        <input type="file" id="pp" name="pp"><br><br>
        <input type="submit" value="Update Profile">
        <?php if (isset($error)) { echo '<p style="color: red;">' . htmlspecialchars($error) . '</p>'; } ?>
      </form>
    </section>
  </div>
  <script src="edit_profile.js"></script>
</body>
</html>
