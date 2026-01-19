function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}
window.onload = function () {

    const sidebar = document.querySelector(".sidebar");
    const closeBtn = document.querySelector("#btn");
    const closemBtn = document.querySelector("#mbtn");

    // Check if the sidebar state is saved in cookies
    const sidebarState = getCookie("sidebarOpen");

    let screenWidth = window.innerWidth;

    // Apply the saved state (open or closed) from cookies
    if (sidebarState === "open" && screenWidth > 768) {
        sidebar.classList.add("open");
        closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");
    } else {
        sidebar.classList.remove("open");
        closeBtn.classList.replace("bx-menu-alt-right", "bx-menu");
    }

    closeBtn.addEventListener("click", function () {
        sidebar.classList.toggle("open");
        menuBtnChange();
        saveSidebarState();
    });

    closemBtn.addEventListener("click", function () {
        sidebar.classList.toggle("open");
        menuBtnChange();
        saveSidebarState();
    });

    function menuBtnChange() {
        if (sidebar.classList.contains("open")) {
            closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        } else {
            closeBtn.classList.replace("bx-menu-alt-right", "bx-menu");
        }
    }

    function saveSidebarState() {
        if (sidebar.classList.contains("open")) {
            setCookie("sidebarOpen", "open", 7); // Save the 'open' state for 7 days
        } else {
            setCookie("sidebarOpen", "closed", 7); // Save the 'closed' state for 7 days
        }
    }
}

$(document).ready(function () {
    // Listen for clicks on delete buttons
    $(document).on('click', '.delete', function (event) {
        event.preventDefault(); // Prevent default action

        const recordId = $(this).data('id'); // Get the record ID
        const pageName = $(this).data('page'); // Get the page name

        // Show confirmation dialog using SweetAlert
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Perform AJAX request
                $.ajax({
                    url: '/admin/delete-record', // Replace with your backend URL
                    type: 'GET', // Use 'DELETE' if appropriate
                    data: {
                        _token: "{{ csrf_token() }}", // CSRF token
                        id: recordId,
                        page: pageName
                    },
                    success: function (response) {
                        // Show success message
                        Swal.fire(
                            'Deleted!',
                            'The record has been deleted.',
                            'success'
                        );
                        // Optionally remove the element from the DOM
                        $(`.delete[data-id="${recordId}"]`).closest('tr').remove();
                    },
                    error: function (xhr, status, error) {
                        // Show error message
                        Swal.fire(
                            'Error!',
                            'An error occurred while deleting the record.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});

