// Add navbar background color and size change when scrolling
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.querySelector('.navbar');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Handle mobile menu body scroll
    const navbarCollapse = document.querySelector('.navbar-collapse');
    const body = document.body;

    navbarCollapse.addEventListener('show.bs.collapse', function () {
        body.style.overflow = 'hidden';
    });

    navbarCollapse.addEventListener('hide.bs.collapse', function () {
        body.style.overflow = '';
    });

    // Handle contact form submission
    const contactForm = document.getElementById('contactForm');
    const formMessage = document.getElementById('formMessage');

    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Disable submit button during submission
            const submitButton = contactForm.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.innerHTML = 'Sending...';

            // Collect form data
            const formData = new FormData(contactForm);

            // Send form data
            fetch(contactForm.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                // Show success message
                formMessage.style.display = 'block';
                formMessage.className = 'mt-3 text-center alert alert-success';
                formMessage.innerHTML = data;
                
                // Reset form
                contactForm.reset();
            })
            .catch(error => {
                // Show error message
                formMessage.style.display = 'block';
                formMessage.className = 'mt-3 text-center alert alert-danger';
                formMessage.innerHTML = 'There was an error sending your message. Please try again.';
            })
            .finally(() => {
                // Re-enable submit button
                submitButton.disabled = false;
                submitButton.innerHTML = 'Send Message';
            });
        });
    }
});
