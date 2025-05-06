<?php
require 'db.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // redirect to login page if not logged in
    exit;
}

// Get the user's information from the database
$user_id = $_SESSION['user_id'];
$query = "SELECT name, email, pp_path FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();

// Close the database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
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
    <section class="profile">
      <div class="profile-pic">
        <img src="<?php echo htmlspecialchars($user_data['pp_path']); ?>" alt="Profile Photo">
      </div>
      <div class="profile-info">
        <h2><?php echo htmlspecialchars($user_data['name']); ?></h2>
        <p>Welcome to your dashboard!</p>
      </div>
    </section>
      <div class="main-top">
        <h1>My lessons</h1>
      </div>
      <div class="row">
        <div class="users">
            <div class="card">
                <img src="images/rahman.jpg" alt="Profile Photo">
                <h4>Abdulrahman Abdulkareem</h4>
                <p>C++</p>
                <p>Status:</p>
                <button>Accepted</button>
            </div>
        </div>
        <div class="users">
            <div class="card">
                <img src="images/zack.jpg" alt="Profile Photo">
                <h4>rafiq zakwan</h4>
                <p>python</p>
                <p>Status:</p>
                <button>Accepted</button>
            </div>
        </div>
        <div class="users">
            <div class="card">
                <img src="images/dhafa.jpg" alt="Profile Photo">
                <h4>dhafamovic</h4>
                <p>web design</p>
                <p>Status:</p>
                <button>Accepted</button>
            </div>
        </div>
    </div>
      
    </section>
  </div>
  <script src="dashboard.js"></script>
</body>
</html>