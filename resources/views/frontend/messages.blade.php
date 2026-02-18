@extends('frontend.layout')

@section('content')
    <main>
        <section class="pt-100 pb-40">
            <div class="container">
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-lg-3 mb-4">
                        @include('frontend.inc.user_sidebar')
                    </div>

                    <!-- Chat Interface -->
                    <div class="col-lg-9">
                        <div class="dashboard_content" style="padding: 0; overflow: hidden; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                            <div class="chat-container bg-white d-flex" style="height: 650px;">
                                <!-- Contacts Sidebar -->
                                <div class="chat-contacts border-end" style="flex: 0 0 280px; background: #fff;">
                                    <div class="p-3 border-bottom bg-light">
                                        <h6 class="mb-0 font-weight-bold">Conversations</h6>
                                    </div>
                                    <div class="contacts-list overflow-auto" style="height: calc(100% - 53px);">
                                        @forelse($contacts as $contact)
                                            <div class="contact-item p-3 border-bottom d-flex align-items-center cursor-pointer hover-bg-light"
                                                onclick="loadChat({{ $contact->id }}, '{{ $contact->first_name }} {{ $contact->last_name }}')"
                                                id="contact-{{ $contact->id }}">
                                                <div class="position-relative">
                                                    <img src="{{ !empty($contact->photo) ? asset('public/assets/images/profiles/' . $contact->photo) : asset('public/assets/images/doctor-placeholder.png') }}"
                                                        class="rounded-circle mr-3"
                                                        style="width: 45px; height: 45px; object-fit: cover;">
                                                </div>
                                                <div class="overflow-hidden flex-grow-1">
                                                    <h6 class="mb-0 text-truncate font-weight-bold" style="font-size: 0.95rem;">
                                                        {{ $contact->first_name }} {{ $contact->last_name }}</h6>
                                                    <p class="mb-0 text-muted small text-truncate">Click to open chat</p>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="p-4 text-center text-muted">
                                                <p class="small">No contacts found from your appointments.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- Chat Area -->
                                <div class="chat-area flex-grow-1 d-flex flex-column bg-light" style="position: relative; overflow: hidden;">
 
                                    <!-- Chat Box -->
                                    <div id="chat-box" class="d-none flex-column h-100 w-100" style="max-height: 100%;">
                                        <!-- Chat Header -->
                                        <div class="chat-header p-3 border-bottom bg-white d-flex align-items-center" style="flex: 0 0 auto;">
                                            <h6 class="mb-0 font-weight-bold text-primary" id="chat-with-name">...</h6>
                                        </div>
 
                                        <!-- Messages Area -->
                                        <div id="messages-display" class="p-4"
                                            style="background: #f0f2f5; display: flex; flex-direction: column; flex: 1 1 auto; overflow-y: auto; scrollbar-width: thin;">
                                            <!-- Messages will appear here -->
                                        </div>
 
                                        <!-- Chat Footer -->
                                        <div class="chat-footer p-3 border-top bg-white" style="flex: 0 0 auto;">
                                            <form id="chat-form" onsubmit="event.preventDefault(); sendMessage();">
                                                <div class="input-group align-items-center">
                                                    <input type="text" id="chat-input"
                                                        class="form-control border-0 bg-light rounded-pill px-3"
                                                        placeholder="Type a message..." required autocomplete="off" style="height: 45px;">
                                                    <div class="input-group-append">
                                                        <button type="submit"
                                                            class="btn btn-primary rounded-circle ml-2 d-flex align-items-center justify-content-center"
                                                            style="width: 45px; height: 45px; flex: 0 0 45px; padding: 0;">
                                                            <i class='bx bxs-paper-plane' style="font-size: 1.2rem;"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
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

        .hover-bg-light:hover {
            background-color: #f8f9fa;
        }

        .contact-item.active {
            background-color: #f0f7ff;
            border-left: 4px solid #007bff;
        }

        #messages-display {
            scrollbar-width: thin;
            scrollbar-color: #ccc transparent;
        }

        #messages-display::-webkit-scrollbar {
            width: 6px;
        }

        #messages-display::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }

        .msg-bubble {
            max-width: 75%;
            margin-bottom: 15px;
            padding: 10px 15px;
            border-radius: 18px;
            font-size: 14px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            line-height: 1.4;
        }

        .msg-sent {
            align-self: flex-end;
            background-color: #007bff;
            color: white;
            border-bottom-right-radius: 2px;
        }

        .msg-received {
            align-self: flex-start;
            background-color: white;
            color: #333;
            border-bottom-left-radius: 2px;
        }

        .msg-time {
            font-size: 10px;
            opacity: 0.7;
            margin-top: 4px;
            display: block;
        }

        .msg-sent .msg-time {
            text-align: right;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let currentRecipientId = null;
        let lastMessageId = 0;
        let pollingInterval = null;
        const myId = {{ Auth::id() }};

        function loadChat(id, name) {
            if (currentRecipientId === id) return;

            currentRecipientId = id;
            lastMessageId = 0;

            // UI updates
            $('.contact-item').removeClass('active');
            $(`#contact-${id}`).addClass('active');
            $('#chat-box').removeClass('d-none').addClass('d-flex');
            $('#chat-with-name').text(name);
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

            const msgDiv = $('<div>').addClass('msg-bubble').addClass(isSent ? 'msg-sent' : 'msg-received');
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