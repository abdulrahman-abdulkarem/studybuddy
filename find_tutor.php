<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="find_tutor.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <style>
      .print-btn {
        background-color: #34AF6D; /* Green color */
  color: #fff; /* White text color */
  border: none;
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;
  border-radius: 5px;
      }

      .print-btn:hover {
        background-color: #2E865F;
      }
    </style>
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
        <p>Explore the tutor list!</p>
      </div>
      <div class="main-body">
        <h1>Recent Tutors</h1>
        <div class="search-bar-container">
          <div class="search_bar">
            <input type="search" id="search-input" placeholder="Search course name here...">
            <select id="category-select">
              <option value="All">All</option>
              <option value="Web Design">Web Design</option>
              <option value="App Design">App Design</option>
              <option value="Python">Python</option>
            </select>
            <button id="search-btn" class="search-btn">Search</button>
            <button class="print-btn" onclick="printPage()">
              <i class="fas fa-print"></i>
              Print
            </button>
          </div>
        </div>
        <div id="job-card-container">
          <!-- Job cards will be dynamically inserted here -->
        </div>
      </div>
    </section>
  </div>
  <script src="find_tutor.js"></script>
  <script>
    // Function to print the current page
    function printPage() {
      window.print();
    }

    
  </script>
  <div class="mouse-trailer"></div>
</body>
</html>
