<x-guest-layout>
    <style>
        /* Override guest container width for registration */
        .guest-container { max-width: 720px !important; }

        .reg-title {
            text-align: center;
            margin-bottom: 1.75rem;
            font-weight: 700;
            font-size: 1.5rem;
            color: #f1f5f9;
        }

        .reg-subtitle {
            text-align: center;
            color: #94a3b8;
            font-size: 0.875rem;
            margin-top: -1.25rem;
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.375rem;
            font-weight: 500;
            font-size: 0.875rem;
            color: #cbd5e1;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            border: 1px solid rgba(148, 163, 184, 0.2);
            background: rgba(15, 23, 42, 0.6);
            color: #f1f5f9;
            font-size: 0.95rem;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }

        .form-input:focus {
            border-color: #818cf8;
            box-shadow: 0 0 0 3px rgba(129, 140, 248, 0.15);
        }

        .form-input::placeholder {
            color: #64748b;
        }

        .btn-primary {
            margin-top: 0.5rem;
            width: 100%;
            padding: 0.875rem;
            border-radius: 0.75rem;
            border: none;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            letter-spacing: 0.025em;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            box-shadow: 0 8px 25px -5px rgba(99, 102, 241, 0.4);
            transform: translateY(-1px);
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.25rem;
            border-top: 1px solid rgba(148, 163, 184, 0.1);
            color: #94a3b8;
            font-size: 0.9rem;
        }

        .login-link a {
            color: #818cf8;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .login-link a:hover {
            color: #a78bfa;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 0.75rem;
            padding: 0.875rem 1rem;
            margin-bottom: 1.25rem;
            color: #fca5a5;
            font-size: 0.875rem;
        }

        .alert-error ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        /* Session Cards */
        .session-cards-label {
            display: block;
            margin-bottom: 0.625rem;
            font-weight: 500;
            font-size: 0.875rem;
            color: #cbd5e1;
        }

        .session-cards-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
            max-height: 320px;
            overflow-y: auto;
            padding-right: 4px;
        }

        .session-cards-grid::-webkit-scrollbar {
            width: 4px;
        }

        .session-cards-grid::-webkit-scrollbar-track {
            background: transparent;
        }

        .session-cards-grid::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.25);
            border-radius: 4px;
        }

        .session-card {
            position: relative;
            background: rgba(15, 23, 42, 0.5);
            border: 2px solid rgba(148, 163, 184, 0.12);
            border-radius: 0.875rem;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .session-card:hover {
            border-color: rgba(129, 140, 248, 0.35);
            background: rgba(15, 23, 42, 0.7);
        }

        .session-card.selected {
            border-color: #818cf8;
            background: rgba(99, 102, 241, 0.1);
            box-shadow: 0 0 0 3px rgba(129, 140, 248, 0.15);
        }

        .session-card input[type="radio"] {
            display: none;
        }

        .session-card-check {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            border: 2px solid rgba(148, 163, 184, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .session-card.selected .session-card-check {
            border-color: #818cf8;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
        }

        .session-card-check svg {
            width: 12px;
            height: 12px;
            fill: none;
            stroke: #fff;
            stroke-width: 2.5;
            stroke-linecap: round;
            stroke-linejoin: round;
            opacity: 0;
            transition: opacity 0.2s;
        }

        .session-card.selected .session-card-check svg {
            opacity: 1;
        }

        .session-card-title {
            font-weight: 600;
            font-size: 0.95rem;
            color: #f1f5f9;
            margin-bottom: 0.5rem;
            padding-right: 2rem;
        }

        .session-card-detail {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            font-size: 0.775rem;
            color: #94a3b8;
            margin-bottom: 0.3rem;
        }

        .session-card-detail svg {
            width: 13px;
            height: 13px;
            flex-shrink: 0;
            stroke: #64748b;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .session-card-spots {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            margin-top: 0.5rem;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.2rem 0.55rem;
            border-radius: 6px;
            background: rgba(52, 211, 153, 0.1);
            color: #6ee7b7;
            border: 1px solid rgba(52, 211, 153, 0.15);
        }

        .session-card-spots.limited {
            background: rgba(251, 191, 36, 0.1);
            color: #fcd34d;
            border-color: rgba(251, 191, 36, 0.15);
        }

        .no-sessions-msg {
            grid-column: 1 / -1;
            text-align: center;
            padding: 2rem 1rem;
            color: #64748b;
            font-size: 0.9rem;
        }

        @media (max-width: 600px) {
            .form-row,
            .session-cards-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <h2 class="reg-title">Student Registration</h2>
    <p class="reg-subtitle">Create your account to get started</p>

    <form method="POST" action="{{ route('register') }}" x-data="{ selectedSession: '{{ old('session_id') }}' }">
        @csrf

        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-input" placeholder="Enter your full name" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" placeholder="Enter your email" value="{{ old('email') }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-input" placeholder="Create a password" required>
            </div>

            <div class="form-group">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-input" placeholder="Confirm your password" required>
            </div>
        </div>

        <div class="form-group">
            <label class="session-cards-label">Choose a Session</label>
            <div class="session-cards-grid">
                @forelse ($sessions as $session)
                    @php
                        $spotsLeft = $session->capacity ? ($session->capacity - $session->trainees_count) : null;
                        $isLimited = $spotsLeft !== null && $spotsLeft <= 3;
                    @endphp
                    <label class="session-card"
                           :class="{ 'selected': selectedSession == '{{ $session->id }}' }"
                           @click="selectedSession = '{{ $session->id }}'">
                        <input type="radio" name="session_id" value="{{ $session->id }}" x-model="selectedSession" required>
                        <div class="session-card-check">
                            <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                        <div class="session-card-title">{{ $session->title }}</div>
                        <div class="session-card-detail">
                            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            {{ $session->trainer?->name ?? 'No trainer' }}
                        </div>
                        <div class="session-card-detail">
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            {{ $session->time_from }} - {{ $session->time_to }}
                        </div>
                        <div class="session-card-detail">
                            <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            {{ is_array($session->days) ? implode(', ', $session->days) : $session->days }}
                        </div>
                        <div class="session-card-spots {{ $isLimited ? 'limited' : '' }}">
                            @if($spotsLeft === null)
                                Open enrollment
                            @else
                                {{ $spotsLeft }} {{ $spotsLeft === 1 ? 'spot' : 'spots' }} left
                            @endif
                        </div>
                    </label>
                @empty
                    <div class="no-sessions-msg">No sessions available at the moment.</div>
                @endforelse
            </div>
        </div>

        <button type="submit" class="btn-primary">Register</button>
    </form>

    <div class="login-link">
        Already have an account? <a href="{{ route('login') }}">Log in</a>
    </div>
</x-guest-layout>
