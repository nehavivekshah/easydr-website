<!-- Global Toast Container -->
<div aria-live="polite" aria-atomic="true" class="position-relative">
    <div id="globalToastContainer" class="toast-container position-fixed top-0 end-0 p-4 mt-5" style="z-index: 1060;">
        <!-- PHP Flash Messages -->
        @if (session('success'))
            <div class="toast align-items-center border-0 shadow-lg show custom-toast-success pb-2 pt-2" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex p-2 align-items-center">
                    <div class="toast-icon bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                        style="width: 30px; height: 30px; flex-shrink: 0;">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="toast-body fw-medium fs-6 p-0 mb-0 flex-grow-1 text-dark">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn text-muted m-auto p-0 border-0 ms-2 btn-close-custom"
                        aria-label="Close" onclick="this.closest('.toast').remove()">
                        <i class="fas fa-times fs-5"></i>
                    </button>
                </div>
            </div>
        @endif

        @if(!empty(session('error')))
            <div class="toast align-items-center border-0 shadow-lg show custom-toast-error pb-2 pt-2" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex p-2 align-items-center">
                    <div class="toast-icon bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                        style="width: 30px; height: 30px; flex-shrink: 0;">
                        <i class="fas fa-exclamation"></i>
                    </div>
                    <div class="toast-body fw-medium fs-6 p-0 mb-0 flex-grow-1 text-dark">
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn text-muted m-auto p-0 border-0 ms-2 btn-close-custom"
                        aria-label="Close" onclick="this.closest('.toast').remove()">
                        <i class="fas fa-times fs-5"></i>
                    </button>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="toast align-items-center border-0 shadow-lg show custom-toast-error pb-2 pt-2" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex p-2">
                    <div class="toast-icon bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3 mt-1"
                        style="width: 30px; height: 30px; flex-shrink: 0;">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="toast-body fw-medium fs-6 p-0 mb-0 flex-grow-1 text-dark">
                        <strong>Errors occurred:</strong>
                        <ul class="mb-0 mt-2 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn text-muted m-auto p-0 border-0 ms-2 align-self-start btn-close-custom"
                        aria-label="Close" onclick="this.closest('.toast').remove()">
                        <i class="fas fa-times fs-5"></i>
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .custom-toast-success {
        background-color: #fff;
        border-left: 5px solid #198754 !important;
        border-radius: 8px;
    }

    .custom-toast-error {
        background-color: #fff;
        border-left: 5px solid #dc3545 !important;
        border-radius: 8px;
    }

    .toast-container .toast {
        animation: slideInRightToast 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        transition: opacity 0.3s ease-out;
        opacity: 1;
        /* Override bootstrap default before show */
    }

    .btn-close-custom:hover i {
        color: #000;
        transform: scale(1.1);
        transition: all 0.2s;
    }

    @keyframes slideInRightToast {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>

<script>
    // Global toast function for JavaScript AJAX responses
    window.showGlobalToast = function (type, message) {
        const container = document.getElementById('globalToastContainer');
        if (!container) return;

        const isSuccess = (type === 'success');
        const toastClass = isSuccess ? 'custom-toast-success' : 'custom-toast-error';
        const iconClass = isSuccess ? 'fa-check' : 'fa-exclamation';
        const bgClass = isSuccess ? 'bg-success' : 'bg-danger';

        const toastHTML = `
        <div class="toast align-items-center border-0 shadow-lg show ${toastClass} pb-2 pt-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex p-2 align-items-center">
                <div class="toast-icon ${bgClass} text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px; flex-shrink: 0;">
                    <i class="fas ${iconClass}"></i>
                </div>
                <div class="toast-body fw-medium fs-6 p-0 mb-0 flex-grow-1 text-dark">
                    ${message}
                </div>
                <button type="button" class="btn text-muted m-auto p-0 border-0 ms-2 btn-close-custom" aria-label="Close" onclick="this.closest('.toast').remove()">
                    <i class="fas fa-times fs-5"></i>
                </button>
            </div>
        </div>
        `;

        // Add to DOM
        container.insertAdjacentHTML('beforeend', toastHTML);
        const newToast = container.lastElementChild;

        // Auto close after 5 seconds
        setTimeout(() => {
            if (newToast && document.body.contains(newToast)) {
                newToast.classList.remove('show');
                newToast.style.opacity = '0';
                setTimeout(() => { if (newToast) newToast.remove() }, 300);
            }
        }, 5000);
    };

    // Auto close PHP toasts after 5 seconds
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function () {
            let toasts = document.querySelectorAll('.toast-container .toast');
            toasts.forEach(function (toast) {
                toast.classList.remove('show');
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            });
        }, 6000);
    });
</script>