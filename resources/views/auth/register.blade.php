<x-guest-layout>
    <style>
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
    </style>

    <h2 class="reg-title">Student Registration</h2>
    <p class="reg-subtitle">Create your account to get started</p>

    <form method="POST" action="{{ route('register') }}">
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

        <div class="form-group">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-input" placeholder="Enter your full name" value="{{ old('name') }}" required autofocus>
        </div>

        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-input" placeholder="Enter your email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-input" placeholder="Create a password" required>
        </div>

        <div class="form-group">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-input" placeholder="Confirm your password" required>
        </div>

        <button type="submit" class="btn-primary">Register</button>
    </form>

    <div class="login-link">
        Already have an account? <a href="{{ route('login') }}">Log in</a>
    </div>
</x-guest-layout>
