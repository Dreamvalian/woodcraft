// Cart operations with client-side validation
document.addEventListener('DOMContentLoaded', function () {
  // Lazy loading for product images
  const lazyImages = document.querySelectorAll('img[data-src]');
  const imageObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const img = entry.target;
        img.src = img.dataset.src;
        img.removeAttribute('data-src');
        observer.unobserve(img);
      }
    });
  });

  lazyImages.forEach(img => imageObserver.observe(img));

  // Cart form validation
  const cartForm = document.querySelector('#add-to-cart-form');
  if (cartForm) {
    cartForm.addEventListener('submit', function (e) {
      e.preventDefault();

      const quantity = parseInt(this.querySelector('input[name="quantity"]').value);
      const productId = this.querySelector('input[name="product_id"]').value;

      // Client-side validation
      if (quantity < 1 || quantity > 99) {
        showError('Quantity must be between 1 and 99');
        return;
      }

      // Show loading state
      const submitButton = this.querySelector('button[type="submit"]');
      const originalText = submitButton.innerHTML;
      submitButton.disabled = true;
      submitButton.innerHTML = '<span class="spinner"></span> Adding...';

      // Submit form
      fetch(this.action, {
        method: 'POST',
        body: new FormData(this),
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            showSuccess(data.message);
            updateCartCount(data.cartCount);
          } else {
            showError(data.message);
          }
        })
        .catch(error => {
          showError('An error occurred. Please try again.');
        })
        .finally(() => {
          submitButton.disabled = false;
          submitButton.innerHTML = originalText;
        });
    });
  }

  // Helper functions
  function showError(message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-danger';
    alertDiv.textContent = message;
    document.querySelector('.alerts-container').appendChild(alertDiv);
    setTimeout(() => alertDiv.remove(), 5000);
  }

  function showSuccess(message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-success';
    alertDiv.textContent = message;
    document.querySelector('.alerts-container').appendChild(alertDiv);
    setTimeout(() => alertDiv.remove(), 5000);
  }

  function updateCartCount(count) {
    const cartCountElement = document.querySelector('.cart-count');
    if (cartCountElement) {
      cartCountElement.textContent = count;
    }
  }
}); 