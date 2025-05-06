# 📚 StudyBuddy

**StudyBuddy** is a dynamic web-based platform built to connect students with tutors. It offers intuitive features for course posting, booking, profile management, and real-time updates — empowering both students and tutors to learn and teach efficiently.

---

## ✨ Features

- 👨‍🏫 **Tutor Dashboard**: Add, view, and remove available courses
- 🧑‍🎓 **Student Dashboard**: Browse and book tutors
- 📬 **Real-time Booking Requests**: Accept/Reject functionality for tutors
- ✏️ **Editable Profiles** for both user types
- 🛠️ **Role-based Navigation** between tutor and student views
- 🔄 **AJAX-based data fetching** and status updates (no page reloads)
- 📱 Fully **responsive design** with clean UI

---

## 🚀 Tech Stack

| Layer       | Technologies                                           |
|-------------|--------------------------------------------------------|
| Frontend    | HTML, CSS, JavaScript                                  |
| Styling     | Google Fonts (Poppins), custom CSS                     |
| Backend     | PHP (modular scripts for fetch/update logic)          |
| Database    | MySQL (via `db.php` connection)                        |
| APIs        | AJAX using native `fetch()`                            |
| Tools       | Git, XAMPP (optional for local hosting)                |

---

## 📂 Project Structure

📁 StudyBuddy/

├── dashboard.php / .js / .css

├── index.php / .js / .css

├── login.php / logout.php / register.php

├── edit_profile.php / .css

├── find_tutor.php / .js / .css

├── my_courses.php / .js / .css

├── home.html / .js / .css

├── fetch_tutors.php / submit_booking.php / remove_course.php / etc.

└── db.php

