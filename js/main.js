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

const detailButtons = document.querySelectorAll('.details-btn');
detailButtons.forEach(button => {
    button.addEventListener('click', function() {
        const card = this.closest('.product-card');
        const details = card.querySelector('.details-content');
        details.classList.toggle('is-open');
        if (details.classList.contains('is-open')) {
            this.textContent = 'Hide Details';
        } else {
            this.textContent = 'View Details';
        }
    });
});

const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
addToCartButtons.forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        
        const formData = new FormData();
        formData.append('action', 'add');
        formData.append('id', this.dataset.id);
        formData.append('name', this.dataset.name);
        formData.append('price', this.dataset.price);
        formData.append('image', this.dataset.image);

        fetch('cart_action.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success') {
                alert('Item added to cart!');
                const counter = document.getElementById('cart-counter');
                if(counter) counter.innerText = data.totalItems;
            } else if (data.status === 'unauthorized') {
                alert('Please log in to add items to your cart.');
                window.location.href = 'login.php'; 
            }
        })
        .catch(error => console.error('Error adding to cart:', error));
    });
});