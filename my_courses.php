<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="my_courses.css">
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
        <h1>My Courses</h1>
        <button id="addCourseBtn">Add Course</button>
    </div>
    <div class="main-skills" id="coursesContainer">
        <!-- Courses will be dynamically loaded here -->
    </div>

    <section>
      <div class="main-top-request">
        <h1>Students request</h1>
      </div>
      <div class="job_card">
        <div class="job_details">
          <div class="img">
            <i class="fab fa-google-drive"></i>
          </div>
          <div class="text">
            <h2>Student name</h2>
            <span>Course name</span>
          </div>
        </div>
        <div class="job_salary">
          <button>Accept</button>
          <button>Reject</button>
        </div>
      </div>
    </section>
    </section>

<!-- Popup Form -->
<div id="courseFormPopup" class="popup-form">
<form id="courseForm" enctype="multipart/form-data" method="POST" action="submit_course.php">
<div class="form-section">
            <h2>Course Information</h2>
            <div class="form-group">
                <label for="tutorPic">Tutor Picture:</label>
                <img id="tutorPic" src="" alt="Tutor Picture" class="circle-img">
            </div>
            <div class="form-group">
                <label for="courseName">Course Name:</label>
                <input type="text" id="courseName" name="course_name" required>
            </div>
            <div class="form-group">
                <label for="courseDescription">Course Description:</label>
                <textarea id="courseDescription" name="course_description" required></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" step="0.01" required>
            </div>
        </div>
        <div class="form-section">
            <h2>Payment</h2>
            <div class="form-group">
                <label for="paymentPhoto">Upload your bank QR:</label>
                <input type="file" id="paymentPhoto" name="payment_photo" accept="image/*" required>
            </div>
        </div>
        <div class="form-section">
            <h2>Contact</h2>
            <div class="form-group">
                <label for="contactPhone">Phone Number:</label>
                <input type="tel" id="contactPhone" name="contact_phone" required>
            </div>
        </div>
        <div class="form-actions">
            <button type="button" id="cancelBtn">Cancel</button>
            <button type="submit">Submit</button>
        </div>
    </form>
</div>

</div>
  <script src="my_courses.js"></script>
</body>
</html>