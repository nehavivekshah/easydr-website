@if(Request::segment(1) != 'login')
    <!-- Scripts -->
    <script src="{{ asset('/public/assets/js/script.js') }}"></script>
@endif

@if(Request::segment(2) == 'manage-appointment')

    <script>
        document.getElementById('doctor_id').addEventListener('change', function () {
            const doctorId = this.value;

            if (doctorId) {
                // Fetch doctor availability
                fetch(`/admin/doctor-availability/${doctorId}`)
                    .then(response => response.json())
                    .then(data => {
                        const dateSelect = document.getElementById('appointment_date');
                        const timeSelect = document.getElementById('appointment_time');

                        // Clear existing options
                        dateSelect.innerHTML = '<option value="">Select Date</option>';
                        timeSelect.innerHTML = '<option value="">Select Time</option>';

                        // Populate dates
                        const dates = [...new Set(data.map(item => item.date))];
                        dates.forEach(date => {
                            const option = document.createElement('option');
                            option.value = date;
                            option.textContent = date;
                            dateSelect.appendChild(option);
                        });

                        // Populate times based on selected date
                        dateSelect.addEventListener('change', function () {
                            const selectedDate = this.value;
                            timeSelect.innerHTML = '<option value="">Select Time</option>';

                            const times = data
                                .filter(item => item.date === selectedDate)
                                .map(item => item.time);

                            times.forEach(time => {
                                const option = document.createElement('option');
                                option.value = time;
                                option.textContent = time;
                                timeSelect.appendChild(option);
                            });
                        });
                    })
                    .catch(error => console.error('Error fetching doctor availability:', error));
            }
        });
    </script>

@endif

@if(Request::segment(1) != 'manage-slot')

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Get current date and time
            const now = new Date();
            const currentDate = now.toISOString().split("T")[0]; // Format as YYYY-MM-DD
            const currentTime = now.toTimeString().split(" ")[0]; // Format as HH:mm:ss

            // Date picker
            flatpickr(".datepicker", {
                dateFormat: "Y-m-d",
                minDate: currentDate, // Disable past dates
                onChange: function (selectedDates, dateStr, instance) {
                    // If today's date is selected, adjust time picker to block past times
                    if (dateStr === currentDate) {
                        startPicker.set("minTime", currentTime);
                    } else {
                        startPicker.set("minTime", "00:00"); // Reset to default for future dates
                    }
                }
            });

            // Time pickers
            const startPicker = flatpickr(".timepicker-start", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                minTime: currentTime, // Disable past times for today
            });

            flatpickr(".timepicker-end", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                minTime: "00:00", // Default for end time
            });
        });
    </script>

@endif

@if(Request::segment(1) == 'task')

    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(function () {
            $(".eventblock").sortable({
                connectWith: ".connectedSortable",
                opacity: .5,
                receive: function (event, ui) {
                    let getItemPosition = ui.item.index();
                    let userId = $(this).attr("data-user");
                    let taskIds = $(ui.item).attr("data-taskid");

                    $.ajax({
                        type: 'get',
                        url: "/tasksubmit",
                        data: { taskIds: taskIds, userId: userId, getItemPosition: getItemPosition },

                        beforeSend: function () {
                            //alert('....Please wait');
                        },
                        success: function (response) {
                            console.log(response);
                        },
                        complete: function (response) {
                            //alert(response);
                        }
                    });

                    //alert("New position: " + getItemPosition + " user: " + userId + " taskIds: " + taskIds);
                }
            }).disableSelection();
        });
    </script>

@endif

@if(Request::segment(1) != 'manage-city')

    <script>
        document.getElementById('country').addEventListener('change', function () {
            const countryId = this.value;
            const stateDropdown = document.getElementById('state');
            stateDropdown.innerHTML = '<option value="">Loading...</option>'; // Show loading option

            if (countryId) {
                fetch(`/api/v1/get-states?country_id=${countryId}`)
                    .then(response => response.json())
                    .then(data => {
                        stateDropdown.innerHTML = '<option value="">Select State</option>';
                        data.forEach(state => {
                            const option = document.createElement('option');
                            option.value = state.name;
                            option.textContent = state.name;
                            stateDropdown.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error loading states:', error);
                        stateDropdown.innerHTML = '<option value="">Select State</option>';
                    });
            } else {
                stateDropdown.innerHTML = '<option value="">Select State</option>';
            }
        });
    </script>

@endif

{{-- Admin UI/UX JavaScript Enhancements --}}
@if(Request::segment(1) == 'admin' && Request::segment(2) != 'login' && Request::segment(2) != 'register')
    <script>
        $(document).ready(function () {
            // ==================== Active Menu Highlighting ====================
            const currentPath = window.location.pathname;
            const currentSegment2 = '{{ Request::segment(2) }}';
            const currentSegment3 = '{{ Request::segment(3) }}';

            // Highlight active menu item
            $('.sidebar a').each(function () {
                const href = $(this).attr('href');
                if (href && (currentPath === href || currentPath.startsWith(href + '/'))) {
                    $(this).closest('li').addClass('active');

                    // Expand parent collapse if exists
                    const parentCollapse = $(this).closest('.collapse');
                    if (parentCollapse.length) {
                        parentCollapse.addClass('show');
                        parentCollapse.prev('a').attr('aria-expanded', 'true');
                    }
                }
            });

            // ==================== Auto-hide Alerts ====================
            if ($('.response-msg').length) {
                setTimeout(function () {
                    $('.response-msg').addClass('hiding');
                    setTimeout(function () {
                        $('.response-msg').remove();
                    }, 300);
                }, 5000);
            }

            // ==================== Smooth Scroll ====================
            $('html').css('scroll-behavior', 'smooth');

            // ==================== Sidebar Toggle Enhancement ====================
            $('#btn').on('click', function () {
                $('.sidebar').toggleClass('open');
                // Save state to cookie
                const isOpen = $('.sidebar').hasClass('open');
                document.cookie = `sidebarOpen=${isOpen ? 'open' : 'closed'}; path=/; max-age=31536000`;
            });

            // Close sidebar when clicking outside on mobile
            $(document).on('click', function (e) {
                if ($(window).width() <= 768) {
                    if (!$(e.target).closest('.sidebar, #btn').length) {
                        $('.sidebar').removeClass('open');
                    }
                }
            });

            // ==================== Form Validation Enhancement ====================
            $('form').on('submit', function () {
                const submitBtn = $(this).find('button[type="submit"]');
                submitBtn.addClass('loading');
            });

            // ==================== Tooltip Initialization ====================
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // ==================== Confirm Delete Actions ====================
            $('.btn-danger[href*="delete"]').on('click', function (e) {
                if (!$(this).data('confirmed')) {
                    e.preventDefault();
                    const href = $(this).attr('href');
                    const btn = $(this);

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This action cannot be undone!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            btn.data('confirmed', true);
                            window.location.href = href;
                        }
                    });
                }
            });
        });
    </script>
@endif