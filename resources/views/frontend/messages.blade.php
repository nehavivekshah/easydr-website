@extends('frontend.layout')

@section('content')
    <main>
        <section class="pt-100 pb-40" style="background: #f4f7f6;">
            <div class="container">
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-lg-3 mb-4">
                        @include('frontend.inc.user_sidebar')
                    </div>

                    <!-- Chat Interface -->
                    <div class="col-lg-9">
                        <div class="dashboard_content shadow-sm p-0 m-0"
                            style="overflow: hidden; border-radius: 12px; border: 1px solid #e0e0e0; background: #fff;">
                            <div class="chat-container d-flex" style="height: 650px;">
                                <!-- Contacts Sidebar -->
                                <div class="chat-contacts border-end"
                                    style="flex: 0 0 270px; background: #fff; display: flex; flex-direction: column; border-right: 1px solid #dddddd85;">
                                    <div class="p-3 border-bottom bg-white">
                                        <h6 class="mb-3 font-weight-bold" style="color: #333;">Messages</h6>
                                        <div class="search-box position-relative">
                                            <i class='fas fa-search position-absolute'
                                                style="left: 15px; top: 15px; color: #adb5bd; font-size: 0.9rem;"></i>
                                            <input type="text" id="contact-search"
                                                class="form-control form-control-sm border-0 bg-light rounded-pill"
                                                placeholder="Search contacts..." style="height: 38px; padding-left: 40px;">
                                        </div>
                                    </div>
                                    <div class="contacts-list overflow-auto flex-grow-1" style="scrollbar-width: none;">
                                        @forelse($contacts as $contact)
                                            <div class="contact-item p-3 border-bottom d-flex align-items-center cursor-pointer transition-all"
                                                onclick="loadChat({{ $contact->id }}, '{{ $contact->first_name }} {{ $contact->last_name }}', '{{ !empty($contact->photo) ? asset('public/assets/images/profiles/' . $contact->photo) : asset('public/assets/images/doctor-placeholder.png') }}')"
                                                id="contact-{{ $contact->id }}">
                                                <div class="position-relative">
                                                    <img src="{{ !empty($contact->photo) ? asset('public/assets/images/profiles/' . $contact->photo) : asset('public/assets/images/doctor-placeholder.png') }}"
                                                        class="rounded-circle me-3"
                                                        style="width: 48px; height: 48px; object-fit: cover; border: 2px solid #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                                    <span class="status-indicator online"></span>
                                                </div>
                                                <div class="overflow-hidden flex-grow-1">
                                                    <h6 class="text-truncate font-weight-bold contact-name"
                                                        style="font-size: 0.95rem; color: #333;">
                                                        {{ $contact->first_name }} {{ $contact->last_name }}
                                                    </h6>
                                                    <p class="mb-0 text-muted small text-truncate">Click to open chat</p>
                                                </div>
                                            </div>
                                        @empty
                                            <div
                                                class="p-5 text-center text-muted h-100 d-flex flex-column align-items-center justify-content-center">
                                                <i class='fas fa-users text-light mb-2' style="font-size: 3rem;"></i>
                                                <p class="small">No active conversations found.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- Chat Area -->
                                <div class="chat-area flex-grow-1 d-flex flex-column"
                                    style="position: relative; overflow: hidden; background: #e5ddd5;">
                                    {{-- WhatsApp Style Background Pattern Overlay --}}
                                    <div
                                        style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: url('https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png'); opacity: 0.06; pointer-events: none;">
                                    </div>

                                    <!-- Chat Box (Initially Hidden via d-none, JS shows it) -->
                                    <div id="chat-box" class="d-none flex-column h-100 w-100"
                                        style="max-height: 100%; position: relative; z-index: 1;">
                                        <!-- Chat Header -->
                                        <div class="chat-header p-3 border-bottom bg-white d-flex align-items-center shadow-sm"
                                            style="flex: 0 0 auto; gap: 10px;">
                                            <div class="header-avatar me-3">
                                                <img id="header-photo" src="" class="rounded-circle"
                                                    style="width: 40px; height: 40px; object-fit: cover;">
                                            </div>
                                            <div class="header-info flex-grow-1">
                                                <h6 class="mb-0 font-weight-bold text-truncate" id="chat-with-name"
                                                    style="color: #333; max-width: 250px;">
                                                    ...</h6>
                                                <span class="small text-success d-flex align-items-center"
                                                    style="gap: 5px;">
                                                    <span class="status-dot me-1"></span> Online
                                                </span>
                                            </div>
                                            <div class="header-actions d-flex align-items-center">
                                                <select id="chat-filter"
                                                    class="form-select form-select-sm me-2 bg-light border-0"
                                                    style="width: auto; max-width: 180px; display: none; margin-right: 10px; cursor: pointer;"
                                                    onchange="applyFilter(this.value)">
                                                    <option value="all">Show All History</option>
                                                </select>
                                                <button type="button" class="btn btn-link text-muted px-2 mr-1 attachbtn"><i
                                                        class='fas fa-paperclip' style="font-size: 1.2rem;"></i></button>
                                            </div>
                                        </div>

                                        <!-- Appointment Alert Banner -->
                                        <div id="appointment-alert"
                                            class="d-none alert alert-info m-3 shadow-sm border-0 d-flex align-items-center justify-content-between"
                                            style="border-radius: 12px; background: #e3f2fd; color: #0d47a1; z-index: 10;">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-clock me-3" style="font-size: 1.2rem;"></i>
                                                <div>
                                                    <span class="font-weight-bold d-block">Session Finished?</span>
                                                    <small>The scheduled time for this appointment has elapsed.</small>
                                                </div>
                                            </div>
                                            <button onclick="completeAppointmentNow()"
                                                class="btn btn-sm btn-primary rounded-pill px-3 py-1 font-weight-bold shadow-sm">Complete
                                                Now</button>
                                        </div>

                                        <!-- Messages Area -->
                                        <div id="messages-display" class="p-4"
                                            style="display: flex; flex-direction: column; flex: 1 1 auto; overflow-y: auto; scrollbar-width: thin;">
                                            <!-- Messages will appear here -->
                                        </div>

                                        <!-- Chat Footer -->
                                        <div class="chat-footer p-3 bg-white border-top" style="flex: 0 0 auto;">
                                            <form id="chat-form" onsubmit="event.preventDefault(); sendMessage();"
                                                enctype="multipart/form-data">
                                                <input type="file" id="chat-file" class="d-none"
                                                    accept="image/*,.pdf,.doc,.docx">
                                                <div class="input-group align-items-center bg-white rounded-pill px-2 shadow-sm"
                                                    style="border: 1px solid #f0f0f0;">
                                                    <input type="text" id="chat-input"
                                                        class="form-control border-0 bg-transparent px-3"
                                                        placeholder="Type your message here..." autocomplete="off"
                                                        style="height: 50px;">
                                                    <div class="input-group-append">
                                                        <button type="submit"
                                                            class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center shadow-lg"
                                                            style="width: 42px; height: 42px; flex: 0 0 42px; padding: 0; margin-left: 8px;">
                                                            <i class='fas fa-paper-plane' style="font-size: 1.1rem;"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Placeholder when no chat is selected (Updated to handle hidden header) -->
                                    <div id="chat-splash"
                                        class="h-100 w-100 d-flex flex-column align-items-center justify-content-center text-center p-5"
                                        style="background: #fff; z-index: 2;">
                                        <div class="mb-4 bg-light p-4 rounded-circle">
                                            <i class='fas fa-comments text-primary'
                                                style="font-size: 5rem; opacity: 0.8;"></i>
                                        </div>
                                        <h4 class="font-weight-bold" style="color: #333;">EasyDoctor Chat</h4>
                                        <p class="text-muted mx-auto" style="max-width: 400px;">Connect safely with your
                                            patients or doctors. Select a contact from the left to start a conversation.</p>
                                        <div class="mt-2 small text-muted">
                                            <i class='fas fa-lock'></i> End-to-end encrypted
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <style>
        .cursor-pointer {
            cursor: pointer;
        }

        .transition-all {
            transition: all 0.2s ease;
        }

        .contact-item:hover {
            background-color: #f7f9fa;
        }

        .contact-item.active {
            background-color: #f0f7ff;
            border-left: 4px solid #007bff;
            box-shadow: inset 2px 0 0 #007bff;
        }

        .status-indicator {
            position: absolute;
            bottom: 2px;
            right: 15px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid #fff;
        }

        .status-indicator.online {
            background-color: #28a745;
        }

        .status-dot {
            height: 8px;
            width: 8px;
            background-color: #28a745;
            border-radius: 50%;
            display: inline-block;
        }

        .msg-bubble {
            max-width: 70%;
            margin-bottom: 8px;
            padding: 8px 12px;
            font-size: 14.5px;
            position: relative;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .msg-sent {
            align-self: flex-end;
            background-color: #dcf8c6;
            color: #303030;
            border-radius: 12px 0px 12px 12px;
        }

        .msg-received {
            align-self: flex-start;
            background-color: #fff;
            color: #303030;
            border-radius: 0px 12px 12px 12px;
        }

        .msg-time {
            font-size: 10px;
            opacity: 0.6;
            margin-top: 4px;
            display: block;
            text-align: right;
        }

        #messages-display::-webkit-scrollbar {
            width: 5px;
        }

        #messages-display::-webkit-scrollbar-track {
            background: transparent;
        }

        #messages-display::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .chat-image {
            max-width: 200px;
            border-radius: 8px;
            margin-bottom: 5px;
            cursor: pointer;
        }

        .chat-file-link {
            display: flex;
            align-items: center;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            padding: 8px 12px;
            border-radius: 8px;
            color: #333;
            text-decoration: none;
            margin-bottom: 5px;
        }

        .chat-file-link:hover {
            background: #e9ecef;
            text-decoration: none;
            color: #000;
        }

        .search-box input:focus {
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.1);
            background-color: #fff !important;
        }

        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 123, 255, 0.4);
        }

        #chat-input:focus {
            box-shadow: none !important;
            outline: none !important;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let currentRecipientId = null;
        let currentAppointmentId = null;
        let lastMessageId = 0;
        let pollingInterval = null;
        let statusCheckInterval = null;

        // New Global State
        let allMessages = [];
        let appointmentsMap = {};
        let currentFilter = 'all';

        const myId = {{ Auth::id() }};
        const myRole = {{ Auth::user()->role }};

        // Contact search logic
        $('#contact-search').on('input', function () {
            const query = $(this).val().toLowerCase();
            $('.contact-item').each(function () {
                const name = $(this).find('.contact-name').text().toLowerCase();
                $(this).toggle(name.includes(query));
            });
        });

        function loadChat(id, name, photo) {
            if (currentRecipientId === id) return;

            currentRecipientId = id;
            lastMessageId = 0;
            allMessages = []; // Reset messages
            appointmentsMap = {};
            currentFilter = 'all';

            // UI updates
            $('.contact-item').removeClass('active');
            $(`#contact-${id}`).addClass('active');
            $('#chat-splash').addClass('d-none');
            $('#chat-box').removeClass('d-none').addClass('d-flex');

            $('#chat-with-name').text(name);
            $('#header-photo').attr('src', photo);
            $('#messages-display').empty();
            $('#chat-filter').hide().empty().append('<option value="all">Show All History</option>');

            fetchMessages(true); // true = force scroll to bottom

            // Manage polling
            if (pollingInterval) clearInterval(pollingInterval);
            pollingInterval = setInterval(() => fetchMessages(false), 4000);

            if (statusCheckInterval) clearInterval(statusCheckInterval);
            if (myRole == 4) {
                checkAppointmentStatus();
                statusCheckInterval = setInterval(checkAppointmentStatus, 30000); // Check every 30s
            }
        }

        function checkAppointmentStatus() {
            if (!currentRecipientId || myRole != 4) return;

            $.get(`/chat/appointment-status/${currentRecipientId}`, function (response) {
                if (response.appointment && response.appointment.is_overdue) {
                    currentAppointmentId = response.appointment.id;
                    $('#appointment-alert').removeClass('d-none');
                } else {
                    $('#appointment-alert').addClass('d-none');
                    currentAppointmentId = null;
                }
            });
        }

        function completeAppointmentNow() {
            if (!currentAppointmentId) return;

            const btn = $('#appointment-alert button');
            const originalText = btn.text();
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

            $.post(`/chat/appointment-complete/${currentAppointmentId}`, {
                _token: '{{ csrf_token() }}'
            }, function (response) {
                if (response.success) {
                    $('#appointment-alert').fadeOut(function () {
                        $(this).addClass('d-none').show();
                    });
                } else {
                    alert(response.error || 'Failed to complete appointment.');
                    btn.prop('disabled', false).text(originalText);
                }
            });
        }

        function fetchMessages(forceScroll = false) {
            if (!currentRecipientId) return;

            $.get(`/chat/fetch/${currentRecipientId}`, function (response) {
                // response: { messages, active_appointment, can_chat, appointments_map }

                // 1. Update Input State
                updateChatInputState(response.can_chat, response.active_appointment);

                // 2. Update Data
                if (response.appointments_map) {
                    appointmentsMap = Object.assign(appointmentsMap, response.appointments_map);
                }

                const newMsgCount = response.messages.length;
                const oldMsgCount = allMessages.length;

                if (newMsgCount > oldMsgCount) {
                    allMessages = response.messages;

                    // Update Filter Dropdown Options
                    updateFilterOptions();

                    // Render
                    renderMessages();

                    // Scroll
                    lastMessageId = allMessages[allMessages.length - 1].id;
                    scrollToBottom();
                } else if (forceScroll) {
                    renderMessages();
                    scrollToBottom();
                }
            });
        }

        function updateChatInputState(canChat, activeAppt) {
            const input = $('#chat-input');
            const btn = $('#chat-form button');

            if (canChat) {
                input.prop('disabled', false).attr('placeholder', 'Type your message here...');
                btn.prop('disabled', false);
                $('#appointment-alert').addClass('d-none');
            } else {
                input.prop('disabled', true).attr('placeholder', 'Chat disabled (Appointment time ended/Not started)');
                btn.prop('disabled', true);

                // Optionally show alert if it was just active? 
                // Or just rely on the placeholder.
            }
        }

        function updateFilterOptions() {
            const select = $('#chat-filter');
            const currentVal = select.val();

            select.empty();
            select.append('<option value="all">Show All History</option>');

            // Extract Unique Dates and Appointments
            const dates = new Set();
            const appts = new Set();

            allMessages.forEach(msg => {
                if (msg.aid && appointmentsMap[msg.aid]) {
                    appts.add(msg.aid);
                } else {
                    // Extract YYYY-MM-DD
                    const date = msg.created_at.split('T')[0]; // Assuming ISO format or similar standard from Laravel
                    // Laravel usually returns "2023-10-27T10:00:00.000000Z" or "2023-10-27 10:00:00"
                    // Let's safe parse
                    const d = new Date(msg.created_at);
                    if (!isNaN(d)) {
                        dates.add(d.toISOString().split('T')[0]);
                    }
                }
            });

            // Add Appointment Options
            if (appts.size > 0) {
                select.append('<optgroup label="By Appointment">');
                appts.forEach(aid => {
                    const appt = appointmentsMap[aid];
                    const label = `Appt: ${appt.date} (${appt.time})`;
                    select.append(`<option value="aid_${aid}">${label}</option>`);
                });
                select.append('</optgroup>');
            }

            // Add Date Options
            if (dates.size > 0) {
                select.append('<optgroup label="By Date">');
                Array.from(dates).sort().reverse().forEach(date => {
                    select.append(`<option value="date_${date}">${date}</option>`);
                });
                select.append('</optgroup>');
            }

            select.val(currentVal || 'all');
            select.show();
        }

        function applyFilter(val) {
            currentFilter = val;
            renderMessages();
        }

        function renderMessages() {
            const container = $('#messages-display');
            container.empty();

            let filtered = [];

            if (currentFilter === 'all') {
                filtered = allMessages;
            } else if (currentFilter.startsWith('aid_')) {
                const targetAid = parseInt(currentFilter.replace('aid_', ''));
                filtered = allMessages.filter(m => m.aid == targetAid);
            } else if (currentFilter.startsWith('date_')) {
                const targetDate = currentFilter.replace('date_', '');
                filtered = allMessages.filter(m => {
                    if (m.aid) return false; // If linked to appt, use appt filter (preference) or show in date? 
                    // Let's assume date filter is for non-appt messages OR all messages on that date.
                    // User requirement: "chat date wise AND appointment wise". 
                    // Simple approach: Date filter matches creation date.
                    const mDate = new Date(m.created_at).toISOString().split('T')[0];
                    return mDate === targetDate;
                });
            }

            let lastAid = null;
            let lastDate = null;

            filtered.forEach(msg => {
                // Grouping Logic
                let showHeader = false;
                let headerText = '';

                if (msg.aid) {
                    if (msg.aid !== lastAid) {
                        showHeader = true;
                        const appt = appointmentsMap[msg.aid];
                        headerText = appt ? `Appointment: ${appt.date} at ${appt.time}` : `Appointment #${msg.aid}`;
                        lastAid = msg.aid;
                        lastDate = null; // Reset date group
                    }
                } else {
                    const mDate = new Date(msg.created_at).toISOString().split('T')[0];
                    if (mDate !== lastDate || lastAid !== null) { // Also show if we just switched from an Appt block
                        showHeader = true;
                        headerText = `Date: ${mDate}`;
                        lastDate = mDate;
                        lastAid = null;
                    }
                }

                if (showHeader) {
                    // Render Header
                    const header = $('<div>').addClass('text-center my-3').html(
                        `<span class="badge bg-light text-dark border px-3 py-2 rounded-pill shadow-sm">${headerText}</span>`
                    );
                    container.append(header);
                }

                appendMessageToDOM(msg);
            });
        }

        // Bind Attachment Button
        $('.attachbtn').click(function () {
            $('#chat-file').click();
        });

        // Handle File Selection - Immediate Send
        $('#chat-file').change(function () {
            if (this.files && this.files[0]) {
                sendMessage(); // Will handle file via FormData
            }
        });

        function appendMessageToDOM(msg) {
            const isSent = msg.pid == myId;
            const time = new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

            const msgDiv = $('<div>').addClass('msg-bubble shadow-sm').addClass(isSent ? 'msg-sent' : 'msg-received');

            // Handle content
            let content = '';

            if (msg.file) {
                const fileExt = msg.file.split('.').pop().toLowerCase();
                const filePath = `{{ asset('public/assets/images/chats/') }}/${msg.file}`;

                if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExt)) {
                    content += `<a href="${filePath}" target="_blank"><img src="${filePath}" class="chat-image" alt="Image"></a>`;
                } else {
                    content += `<a href="${filePath}" target="_blank" class="chat-file-link"><i class="fas fa-file-alt me-2"></i> ${msg.file}</a>`;
                }
            }

            if (msg.msg) {
                content += $('<span>').text(msg.msg).prop('outerHTML');
            }

            const timeSpan = $('<span>').addClass('msg-time').text(time);

            msgDiv.html(content).append(timeSpan);
            $('#messages-display').append(msgDiv);
        }

        function sendMessage() {
            const messageInput = $('#chat-input');
            const fileInput = $('#chat-file')[0];

            const message = messageInput.val().trim();
            const hasFile = fileInput.files.length > 0;

            if ((!message && !hasFile) || !currentRecipientId) return;

            // Disable inputs
            messageInput.prop('disabled', true);

            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('recipient_id', currentRecipientId);

            if (message) formData.append('message', message);
            if (hasFile) formData.append('file', fileInput.files[0]);

            $.ajax({
                url: '/chat/send',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    messageInput.prop('disabled', false).focus();
                    if (response.success) {
                        messageInput.val('');
                        fileInput.value = ''; // Reset file input
                        fetchMessages(true);
                    } else {
                        alert(response.error || 'Failed to send message.');
                    }
                },
                error: function (xhr) {
                    messageInput.prop('disabled', false);
                    fileInput.value = ''; // Reset file input
                    let err = 'Failed to send';
                    if (xhr.responseJSON && xhr.responseJSON.error) err = xhr.responseJSON.error;
                    alert(err);
                }
            });
        }

        function scrollToBottom() {
            const container = document.getElementById('messages-display');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        }

        // Clean up interval on page leave
        window.onbeforeunload = function () {
            if (pollingInterval) clearInterval(pollingInterval);
        };
    </script>
@endsection