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
                                                style="left: 12px; top: 12px; color: #999; font-size: 0.9rem;"></i>
                                            <input type="text" id="contact-search"
                                                class="form-control form-control-sm pl-5 border-light bg-light rounded-pill"
                                                placeholder="Search contacts..." style="height: 38px;">
                                        </div>
                                    </div>
                                    <div class="contacts-list overflow-auto flex-grow-1" style="scrollbar-width: none;">
                                        @forelse($contacts as $contact)
                                            <div class="contact-item p-3 border-bottom d-flex align-items-center cursor-pointer transition-all"
                                                onclick="loadChat({{ $contact->id }}, '{{ $contact->first_name }} {{ $contact->last_name }}', '{{ !empty($contact->photo) ? asset('public/assets/images/profiles/' . $contact->photo) : asset('public/assets/images/doctor-placeholder.png') }}')"
                                                id="contact-{{ $contact->id }}">
                                                <div class="position-relative">
                                                    <img src="{{ !empty($contact->photo) ? asset('public/assets/images/profiles/' . $contact->photo) : asset('public/assets/images/doctor-placeholder.png') }}"
                                                        class="rounded-circle mr-3"
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
                                            style="flex: 0 0 auto;">
                                            <div class="header-avatar mr-3">
                                                <img id="header-photo" src="" class="rounded-circle"
                                                    style="width: 40px; height: 40px; object-fit: cover;">
                                            </div>
                                            <div class="header-info flex-grow-1">
                                                <h6 class="mb-0 font-weight-bold" id="chat-with-name" style="color: #333;">
                                                    ...</h6>
                                                <span class="small text-success d-flex align-items-center">
                                                    <span class="status-dot mr-1"></span> Online
                                                </span>
                                            </div>
                                            <div class="header-actions">
                                                <button type="button" class="btn btn-link text-muted px-2 mr-1"><i
                                                        class='fas fa-paperclip' style="font-size: 1.2rem;"></i></button>
                                            </div>
                                        </div>

                                        <!-- Messages Area -->
                                        <div id="messages-display" class="p-4"
                                            style="display: flex; flex-direction: column; flex: 1 1 auto; overflow-y: auto; scrollbar-width: thin;">
                                            <!-- Messages will appear here -->
                                        </div>

                                        <!-- Chat Footer -->
                                        <div class="chat-footer p-3 bg-white border-top" style="flex: 0 0 auto;">
                                            <form id="chat-form" onsubmit="event.preventDefault(); sendMessage();">
                                                <div class="input-group align-items-center bg-light rounded-pill px-2 shadow-sm"
                                                    style="border: 1px solid #ebebeb;">
                                                    <input type="text" id="chat-input"
                                                        class="form-control border-0 bg-transparent px-2"
                                                        placeholder="Type your message here..." required autocomplete="off"
                                                        style="height: 48px; box-shadow: none;">
                                                    <div class="input-group-append">
                                                        <button type="submit"
                                                            class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center shadow-lg"
                                                            style="width: 42px; height: 42px; flex: 0 0 42px; padding: 0; margin-left: 5px;">
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

        .search-box input:focus {
            box-shadow: none;
            border-color: #007bff;
            background-color: #fff !important;
        }

        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 123, 255, 0.4);
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let currentRecipientId = null;
        let lastMessageId = 0;
        let pollingInterval = null;
        const myId = {{ Auth::id() }};

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

            // UI updates
            $('.contact-item').removeClass('active');
            $(`#contact-${id}`).addClass('active');
            $('#chat-splash').addClass('d-none');
            $('#chat-box').removeClass('d-none').addClass('d-flex');

            $('#chat-with-name').text(name);
            $('#header-photo').attr('src', photo);
            $('#messages-display').empty();

            fetchMessages();

            // Manage polling
            if (pollingInterval) clearInterval(pollingInterval);
            pollingInterval = setInterval(fetchMessages, 4000);
        }

        function fetchMessages() {
            if (!currentRecipientId) return;

            $.get(`/chat/fetch/${currentRecipientId}`, function (messages) {
                let hasNew = false;
                messages.forEach(msg => {
                    if (msg.id > lastMessageId) {
                        appendMessage(msg);
                        lastMessageId = msg.id;
                        hasNew = true;
                    }
                });

                if (hasNew) {
                    scrollToBottom();
                }
            });
        }

        function appendMessage(msg) {
            const isSent = msg.pid == myId; // pid is now sender_id
            const time = new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

            const msgDiv = $('<div>').addClass('msg-bubble shadow-sm').addClass(isSent ? 'msg-sent' : 'msg-received');
            const msgText = $('<span>').text(msg.msg);
            const timeSpan = $('<span>').addClass('msg-time').text(time);

            msgDiv.append(msgText).append(timeSpan);
            $('#messages-display').append(msgDiv);
        }

        function sendMessage() {
            const message = $('#chat-input').val().trim();
            if (!message || !currentRecipientId) return;

            $('#chat-input').val('');

            $.post('/chat/send', {
                _token: '{{ csrf_token() }}',
                recipient_id: currentRecipientId,
                message: message
            }, function (response) {
                if (response.success) {
                    // Update if not already polled
                    if (response.chat.id > lastMessageId) {
                        appendMessage(response.chat);
                        lastMessageId = response.chat.id;
                        scrollToBottom();
                    }
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