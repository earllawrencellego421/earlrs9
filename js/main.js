// Mobile nav toggle
const toggle = document.querySelector('.nav-toggle');
const nav = document.querySelector('nav');

if (toggle && nav) {
  toggle.addEventListener('click', () => {
    const isOpen = nav.classList.toggle('is-open');
    toggle.classList.toggle('is-open', isOpen);
    toggle.setAttribute('aria-expanded', String(isOpen));
  });

  nav.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      nav.classList.remove('is-open');
      toggle.classList.remove('is-open');
      toggle.setAttribute('aria-expanded', 'false');
    });
  });
}

// Product Details Toggle
const detailButtons = document.querySelectorAll('.details-btn');

detailButtons.forEach(button => {
    button.addEventListener('click', function() {
        // Find the details container inside the specific product card clicked
        const card = this.closest('.product-card');
        const details = card.querySelector('.details-content');
        
        // Toggle the open class
        details.classList.toggle('is-open');
        
        // Change the button text
        if (details.classList.contains('is-open')) {
            this.textContent = 'Hide Details';
        } else {
            this.textContent = 'View Details';
        }
    });
});