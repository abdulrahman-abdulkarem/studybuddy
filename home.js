document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');
  
    // Close sidebar on click outside
    document.addEventListener('click', function(event) {
      const target = event.target;
      if (!target.closest('#sidebar') && sidebar.classList.contains('active')) {
        sidebar.classList.remove('active');
      }
    });
  
    // Toggle sidebar on small screens
    sidebar.addEventListener('click', function() {
      if (window.innerWidth <= 768) {
        sidebar.classList.toggle('active');
      }
    });
  
    // Adjust content margin on hover (desktop)
    sidebar.addEventListener('mouseenter', function() {
      if (window.innerWidth > 768) {
        content.style.marginLeft = '250px';
      }
    });
  
    sidebar.addEventListener('mouseleave', function() {
      if (window.innerWidth > 768 && !sidebar.classList.contains('active')) {
        content.style.marginLeft = '80px';
      }
    });
  
    // Initial setup for small screens
    if (window.innerWidth <= 768) {
      sidebar.classList.add('active');
    }
  
    // Carousel functionality
    const carousel = document.querySelector('.carousel');
    let isDown = false;
    let startX;
    let scrollLeft;
  
    carousel.addEventListener('mousedown', (e) => {
      isDown = true;
      carousel.classList.add('active');
      startX = e.pageX - carousel.offsetLeft;
      scrollLeft = carousel.scrollLeft;
    });
  
    carousel.addEventListener('mouseleave', () => {
      isDown = false;
      carousel.classList.remove('active');
    });
  
    carousel.addEventListener('mouseup', () => {
      isDown = false;
      carousel.classList.remove('active');
    });
  
    carousel.addEventListener('mousemove', (e) => {
      if (!isDown) return;
      e.preventDefault();
      const x = e.pageX - carousel.offsetLeft;
      const walk = (x - startX) * 3; //scroll-fast
      carousel.scrollLeft = scrollLeft - walk;
    });
  });