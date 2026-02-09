<x-guest-layout>
    <style>
        .step-title {
            text-align: center;
            margin-bottom: 1.75rem;
            font-weight: 700;
            font-size: 1.5rem;
            color: #f1f5f9;
        }

        .step-title .highlight {
            background: linear-gradient(135deg, #818cf8, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-transform: capitalize;
        }

        .role-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.875rem;
        }

        .role-card {
            padding: 1.25rem;
            border-radius: 0.875rem;
            border: 1px solid rgba(148, 163, 184, 0.15);
            background: rgba(51, 65, 85, 0.4);
            color: #e2e8f0;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.25s ease;
            text-align: center;
            text-transform: capitalize;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }

        .role-card .role-icon {
            width: 40px;
            height: 40px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            background: rgba(99, 102, 241, 0.15);
        }

        .role-card:hover {
            border-color: #818cf8;
            background: rgba(99, 102, 241, 0.1);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -5px rgba(99, 102, 241, 0.2);
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

        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1.25rem;
            color: #94a3b8;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #818cf8;
        }

        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.25rem;
            border-top: 1px solid rgba(148, 163, 184, 0.1);
            color: #94a3b8;
            font-size: 0.9rem;
        }

        .register-link a {
            color: #818cf8;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .register-link a:hover {
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

        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            border-radius: 0.75rem;
            padding: 0.875rem 1rem;
            margin-bottom: 1.25rem;
            color: #86efac;
            font-size: 0.875rem;
            text-align: center;
        }

        .hidden { display: none; }

        @media (max-width: 400px) {
            .role-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Step 1: Select User Type -->
    <div id="step1">
        <h2 class="step-title">Welcome Back</h2>

        <div class="role-grid">
            <button type="button" class="role-card" data-type="admin">
                <div class="role-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                Admin
            </button>
            <button type="button" class="role-card" data-type="qa">
                <div class="role-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                QA
            </button>
            <button type="button" class="role-card" data-type="trainer">
                <div class="role-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                Teacher
            </button>
            <button type="button" class="role-card" data-type="trainee">
                <div class="role-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                Student
            </button>
        </div>

        <div class="register-link">
            New student? <a href="{{ route('register') }}">Create an account</a>
        </div>
    </div>

    <!-- Step 2: Login Form -->
    <div id="step2" class="hidden">
        <h2 class="step-title">Login as <span class="highlight" id="selectedUserType"></span></h2>

        <form method="POST" action="{{ route('login') }}">
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

            <input type="hidden" name="user_type" id="hidden_user_type" />

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" placeholder="Enter your email" required autofocus>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-input" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="btn-primary">Log in</button>
        </form>

        <div class="back-link" id="backToStep1">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
            Back to role selection
        </div>
    </div>

    <script>
        const userTypeButtons = document.querySelectorAll('.role-card');
        const step1Div = document.getElementById('step1');
        const step2Div = document.getElementById('step2');
        const hiddenUserType = document.getElementById('hidden_user_type');
        const selectedUserTypeSpan = document.getElementById('selectedUserType');
        const backBtn = document.getElementById('backToStep1');

        userTypeButtons.forEach(button => {
            button.addEventListener('click', () => {
                const userType = button.dataset.type;
                hiddenUserType.value = userType;
                selectedUserTypeSpan.textContent = userType;
                step1Div.classList.add('hidden');
                step2Div.classList.remove('hidden');
            });
        });

        backBtn.addEventListener('click', () => {
            step2Div.classList.add('hidden');
            step1Div.classList.remove('hidden');
        });
    </script>
</x-guest-layout>
