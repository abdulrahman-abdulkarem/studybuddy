document.addEventListener('DOMContentLoaded', (event) => {
    const addCourseBtn = document.getElementById('addCourseBtn');
    const courseFormPopup = document.getElementById('courseFormPopup');
    const courseForm = document.getElementById('courseForm');
    const tutorPic = document.getElementById('tutorPic');
    const cancelBtn = document.getElementById('cancelBtn');
    const coursesContainer = document.getElementById('coursesContainer');

    addCourseBtn.addEventListener('click', () => {
        fetch('get_tutor_picture.php')
            .then(response => response.json())
            .then(data => {
                if (data.pp_path) {
                    tutorPic.src = data.pp_path;
                } else {
                    tutorPic.src = 'default_profile_picture_path';
                }
            })
            .catch(error => {
                console.error('Error fetching tutor picture:', error);
            });

        courseFormPopup.style.display = 'flex';
    });

    cancelBtn.addEventListener('click', () => {
        courseFormPopup.style.display = 'none';
    });

    courseForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(courseForm);

        fetch('submit_course.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Course submitted successfully!');
                courseFormPopup.style.display = 'none';
                loadCourses();
            } else {
                alert('Error submitting course: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    function loadCourses() {
        fetch('get_user_courses.php')
        .then(response => response.json())
        .then(courses => {
            coursesContainer.innerHTML = '';
            if (courses.length === 0) {
                coursesContainer.innerHTML = '<p>No courses uploaded yet.</p>';
            } else {
                courses.forEach(course => {
                    const courseCard = document.createElement('div');
                    courseCard.className = 'card';
                    courseCard.innerHTML = `
                        <h2>${course.course_name}</h2>
                        <p>${course.course_description}</p>
                        <h4>${course.price} RM / Lesson</h4>
                        <button class="removeCourseBtn" data-id="${course.id}">Remove</button>
                    `;
                    coursesContainer.appendChild(courseCard);
                });

                document.querySelectorAll('.removeCourseBtn').forEach(button => {
                    button.addEventListener('click', (e) => {
                        const courseId = e.target.getAttribute('data-id');
                        removeCourse(courseId);
                    });
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function removeCourse(courseId) {
        fetch(`remove_course.php?id=${courseId}`, {
            method: 'GET',
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Course removed successfully!');
                loadCourses();
            } else {
                alert('Error removing course: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    loadCourses();
});
