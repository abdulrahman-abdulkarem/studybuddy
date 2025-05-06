// find_tutor.js

const mainTop = document.querySelector('.main-top');
const mainBody = document.querySelector('.main-body');
const jobCardContainer = document.querySelector('#job-card-container');
const searchInput = document.querySelector('#search-input');
const categorySelect = document.querySelector('#category-select');
const searchBtn = document.querySelector('#search-btn');

// Fetch all tutors on page load
fetchTutors();

searchBtn.addEventListener('click', () => {
  const search = searchInput.value.trim();
  const category = categorySelect.value;
  fetchTutors(search, category);
});

function fetchTutors(search = '', category = 'All') {
  fetch(`fetch_tutors.php?search=${search}&category=${category}`)
   .then(response => response.json())
   .then(tutors => {
      jobCardContainer.innerHTML = ''; // Clear existing content

      tutors.forEach(tutor => {
        const jobCard = document.createElement('div');
        jobCard.className = 'job_card';
        jobCard.innerHTML = `
          <div class="job_details">
            <div class="img">
              <img src="${tutor.photo}" alt="${tutor.tutor_name}" />
            </div>
            <div class="text">
              <h2>${tutor.tutor_name}</h2>
              <span>${tutor.course_name}</span>
              <p>${tutor.course_description}</p>
            </div>
          </div>
          <div class="job_salary">
            <h4>$${tutor.price} /Lesson</h4>
            <button class="book_btn">Book</button>
          </div>
        `;
        jobCardContainer.appendChild(jobCard);
      });

      if (tutors.length === 0) {
        const noResults = document.createElement('p');
        noResults.textContent = 'No tutors found.';
        jobCardContainer.appendChild(noResults);
      }
    })
   .catch(error => {
      console.error('Error:', error);
    });
}