<div class="col-md-10 p-4" style="background: #f4f5f7">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <!-- Conversations list (left column) -->
        <div class="col-md-4 col-lg-3 mb-3">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><strong>Messages</strong></span>
                </div>
                <div class="card-body p-2" style="height: 420px; overflow-y: auto;">
                    <!-- Start new chat -->
                    <form method="POST" action="{{ route('messages.store') }}" class="mb-3">
                        @csrf
                        <div class="mb-2">
                            <select name="receiver_type" id="receiver_type"
                                    class="form-select form-select-sm" required>
                                <option value="">{{ __('Select user type') }}</option>
                                <option value="admin">Admin</option>
                                <option value="qa">QA</option>
                                <option value="trainer">Teacher</option>
                                <option value="trainee">Student</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <select name="receiver_id" id="receiver_id"
                                    class="form-select form-select-sm" required>
                                <option value="">{{ __('Select user') }}</option>
                                @foreach ($admins as $admin)
                                    <option value="{{ $admin->id }}" data-type="admin">
                                        Admin: {{ $admin->name }} ({{ $admin->email }})
                                    </option>
                                @endforeach
                                @foreach ($qas as $qa)
                                    <option value="{{ $qa->id }}" data-type="qa">
                                        QA: {{ $qa->name ?? 'QA #'.$qa->id }} ({{ $qa->email ?? '' }})
                                    </option>
                                @endforeach
                                @foreach ($trainers as $trainer)
                                    <option value="{{ $trainer->id }}" data-type="trainer">
                                        Teacher: {{ $trainer->name ?? 'Teacher #'.$trainer->id }} ({{ $trainer->email ?? '' }})
                                    </option>
                                @endforeach
                                @foreach ($trainees as $trainee)
                                    <option value="{{ $trainee->id }}" data-type="trainee">
                                        Student: {{ $trainee->name }} ({{ $trainee->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <textarea name="body" class="form-control form-control-sm" rows="2"
                                      placeholder="{{ __('Type a message...') }}" required></textarea>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-sm">
                                {{ __('Send') }}
                            </button>
                        </div>
                    </form>

                    <hr class="my-2">

                    <!-- Existing conversations -->
                    @if ($conversations->isEmpty())
                        <p class="text-muted small mb-0">{{ __('No conversations yet.') }}</p>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach ($conversations as $conversation)
                                @php
                                    $isActive = $activeConversation
                                        && $activeConversation['type'] === $conversation['type']
                                        && (int) $activeConversation['id'] === (int) $conversation['id'];
                                    $hasUnread = isset($conversation['unread_count']) && $conversation['unread_count'] > 0;
                                @endphp
                                <a href="{{ route('messages.index', ['type' => $conversation['type'], 'id' => $conversation['id']]) }}"
                                   class="list-group-item list-group-item-action {{ $isActive ? 'active' : '' }} {{ $hasUnread ? 'bg-light' : '' }}">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center">
                                                <div class="fw-semibold {{ $hasUnread ? 'fw-bold' : '' }}">
                                                    {{ $conversation['name'] }}
                                                </div>
                                                @if($hasUnread)
                                                    <span class="badge bg-primary rounded-pill ms-2">{{ $conversation['unread_count'] }}</span>
                                                @endif
                                            </div>
                                            <div class="small {{ $hasUnread ? 'text-dark fw-semibold' : 'text-muted' }} text-truncate" style="max-width: 180px;">
                                                {{ $conversation['last_message_body'] }}
                                            </div>
                                        </div>
                                        <div class="small text-muted text-end ms-2">
                                            {{ $conversation['last_message_at']->diffForHumans() }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Active conversation (right column) -->
        <div class="col-md-8 col-lg-9 mb-3">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center">
                    @if ($activeUser)
                        <div class="me-2 rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                             style="width: 32px; height: 32px;">
                            {{ strtoupper(substr($activeUser->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <div class="fw-semibold">
                                {{ $activeUser->name ?? 'User #'.$activeUser->id }}
                            </div>
                            <div class="small text-muted text-capitalize">
                                {{ $activeConversation['type'] ?? '' }}
                            </div>
                        </div>
                    @else
                        <span class="text-muted">{{ __('Select a conversation or start a new chat') }}</span>
                    @endif
                </div>

                <div class="card-body d-flex flex-column" style="height: 420px;">
                    <div class="flex-grow-1 mb-3" style="overflow-y: auto;">
                        @if ($activeUser && $conversationMessages->isNotEmpty())
                            @foreach ($conversationMessages as $message)
                                @php
                                    $isSender = get_class($user) === $message->sender_type && $user->id === $message->sender_id;
                                @endphp
                                <div class="d-flex mb-2 {{ $isSender ? 'justify-content-end' : 'justify-content-start' }}">
                                    <div class="px-3 py-2 rounded-3 {{ $isSender ? 'bg-primary text-white' : 'bg-light' }}"
                                         style="max-width: 75%;">
                                        <div class="small">
                                            {{ $message->body }}
                                        </div>
                                        <div class="small text-muted text-end mt-1" style="font-size: 0.7rem;">
                                            {{ $message->created_at->format('Y-m-d H:i') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @elseif ($activeUser)
                            <p class="text-muted small mb-0">
                                {{ __('No messages yet. Say hi!') }}
                            </p>
                        @else
                            <p class="text-muted small mb-0">
                                {{ __('Choose a contact from the left or start a new chat.') }}
                            </p>
                        @endif
                    </div>

                    <!-- Composer -->
                    @if ($activeUser)
                        <form method="POST" action="{{ route('messages.store') }}">
                            @csrf
                            <input type="hidden" name="receiver_type" value="{{ $activeConversation['type'] ?? '' }}">
                            <input type="hidden" name="receiver_id" value="{{ $activeUser->id }}">

                            <div class="input-group">
                                <textarea name="body" class="form-control" rows="1"
                                          placeholder="{{ __('Type a message...') }}" required></textarea>
                                <button class="btn btn-primary" type="submit">
                                    {{ __('Send') }}
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        (function () {
            const typeSelect = document.getElementById('receiver_type');
            const userSelect = document.getElementById('receiver_id');
            if (!typeSelect || !userSelect) {
                return;
            }

            function filterUsers() {
                const type = typeSelect.value;
                Array.from(userSelect.options).forEach(option => {
                    if (!option.value) {
                        option.hidden = false;
                        return;
                    }
                    const optionType = option.getAttribute('data-type');
                    option.hidden = !!type && optionType !== type;
                });
                userSelect.value = '';
            }

            typeSelect.addEventListener('change', filterUsers);
        })();
    </script>
@endpush

