// EasyDoctor Frontend JavaScript - Main Script File

document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    initializeCarousels();
    setupScrollToTop();
});

// Initialize all elements
function initializeElements() {
    // Bootstrap tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Bootstrap popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
}

// Setup event listeners
function setupEventListeners() {
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });

    // Scroll to top button
    const scrollToTopBtn = document.querySelector('.scroll-to-top');
    if (scrollToTopBtn) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollToTopBtn.classList.add('show');
            } else {
                scrollToTopBtn.classList.remove('show');
            }
        });

        scrollToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Active navbar link
    setActiveNavLink();
    window.addEventListener('scroll', setActiveNavLink);
}

// Set active navbar link based on scroll position
function setActiveNavLink() {
    const sections = document.querySelectorAll('[id]');
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

    let current = '';
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        if (window.pageYOffset >= sectionTop - 200) {
            current = section.getAttribute('id');
        }
    });

    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === '#' + current) {
            link.classList.add('active');
        }
    });
}

// Initialize carousels
function initializeCarousels() {
    // Slick carousel for doctors
    const doctorSlider = document.querySelector('.doctor-active');
    if (doctorSlider && typeof $ !== 'undefined' && $.fn.slick) {
        $(doctorSlider).slick({
            infinite: false,
            slidesToShow: 4,
            slidesToScroll: 1,
            // Custom Arrows
            prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>',
            nextArrow: '<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>',
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }
}

// Utility: Show toast notification
function showToast(message, type = 'info') {
    const alertClass = `alert-${type}`;
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert ${alertClass} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3`;
    alertDiv.style.zIndex = '9999';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    document.body.appendChild(alertDiv);

    setTimeout(() => {
        const alert = new bootstrap.Alert(alertDiv);
        alert.close();
    }, 5000);
}

// Utility: Format currency
function formatCurrency(amount, currency = 'USD') {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: currency
    }).format(amount);
}

// Utility: Format date
function formatDate(date, format = 'MM/DD/YYYY') {
    const d = new Date(date);
    const day = String(d.getDate()).padStart(2, '0');
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const year = d.getFullYear();

    return format
        .replace('DD', day)
        .replace('MM', month)
        .replace('YYYY', year);
}

// Utility: Validate email
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Utility: Validate phone
function isValidPhone(phone) {
    const phoneRegex = /^[0-9+\-\s()]{10,}$/;
    return phoneRegex.test(phone);
}

// Doctor search filter
function filterDoctors() {
    const searchInput = document.querySelector('#search');
    const specialtySelect = document.querySelector('#specialty');

    if (searchInput && specialtySelect) {
        const form = searchInput.closest('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                // Form will submit naturally with GET parameters
            });
        }
    }
}

// Initialize doctor filter on page load
if (document.querySelector('.doctor-search-filter')) {
    filterDoctors();
}

// Add loading spinner on form submit
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function() {
        const btn = this.querySelector('[type="submit"]');
        if (btn) {
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';

            // Re-enable after 5 seconds (in case of error)
            setTimeout(() => {
                btn.disabled = false;
                btn.innerHTML = originalText;
            }, 5000);
        }
    });
});

// Appointment booking helper
function bookAppointment(doctorId) {
    window.location.href = `/appointments?doctor_id=${doctorId}`;
}

// Add to cart helper for pharmacy
function addToCart(medicineId) {
    if (!medicineId) {
        showToast('Invalid medicine', 'danger');
        return;
    }

    const quantity = document.querySelector(`#quantity-${medicineId}`)?.value || 1;

    fetch('/api/v1/add-to-cart', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            medicine_id: medicineId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Added to cart successfully', 'success');
        } else {
            showToast(data.message || 'Error adding to cart', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error adding to cart', 'danger');
    });
}

// CSRF token setup for AJAX
const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

// Lazy loading images
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            }
        });
    });

    document.querySelectorAll('img.lazy').forEach(img => {
        imageObserver.observe(img);
    });
}

// Export functions for global access
window.EasyDoctor = {
    showToast,
    formatCurrency,
    formatDate,
    isValidEmail,
    isValidPhone,
    bookAppointment,
    addToCart
};

// Setup Scroll to Top Button
function setupScrollToTop() {
    const scrollButton = document.getElementById('scrollToTop');
    if (!scrollButton) return;

    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            scrollButton.classList.add('show');
        } else {
            scrollButton.classList.remove('show');
        }
    });

    scrollButton.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// Initialize AOS (Animate On Scroll) if available
if (typeof AOS !== 'undefined') {
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });
}
