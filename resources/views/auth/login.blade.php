<x-guest-layout>

    <style>
        body {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            font-family: 'Segoe UI', sans-serif;
        }

        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-card {
            background: #fff;
            border-radius: 16px;
            padding: 40px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .auth-card h2 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
            color: #333;
        }

        .info-boxes {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .info-box {
            padding: 18px;
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            background: #f9fafb;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
            text-transform: capitalize;
        }

        .info-box:hover {
            border-color: #0d6efd;
            background: #e7f1ff;
            transform: translateY(-3px);
        }

        .hidden {
            display: none;
        }

        label {
            margin-top: 15px;
            font-weight: 500;
            color: #555;
        }

        input {
            width: 100%;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid #ddd;
            margin-top: 5px;
            transition: border 0.2s;
        }

        input:focus {
            border-color: #0d6efd;
            outline: none;
        }

        .join-btn {
            margin-top: 25px;
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .join-btn:hover {
            opacity: 0.9;
        }

        .link {
            margin-top: 20px;
            text-align: center;
            color: #0d6efd;
            cursor: pointer;
            font-weight: 500;
        }

        .link:hover {
            text-decoration: underline;
        }

        .alert {
            border-radius: 10px;
        }

        .capitalize {
            text-transform: capitalize;
            color: #0d6efd;
        }

        @media (max-width: 480px) {
            .auth-card {
                padding: 30px 20px;
            }
        }
    </style>

    <div class="auth-container">

        <!-- Step 1 -->
        <div id="step1" class="auth-card">
            <h2>Select User Type</h2>

            <div class="info-boxes">
                <button type="button" class="info-box" data-type="admin">Admin</button>
                <button type="button" class="info-box" data-type="qa">QA</button>
                <button type="button" class="info-box" data-type="trainer">Trainer</button>
                <button type="button" class="info-box" data-type="trainee">Trainee</button>
            </div>
        </div>

        <!-- Step 2 -->
        <div id="step2" class="auth-card hidden">
            <h2>Login as <span id="selectedUserType" class="capitalize"></span></h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                @if ($errors->any())
                    <div class="alert alert-danger mb-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <input type="hidden" name="user_type" id="hidden_user_type" />

                <label>Email</label>
                <input type="email" name="email" required autofocus>

                <label>Password</label>
                <input type="password" name="password" required>

                <button type="submit" class="join-btn">Log in</button>
            </form>

            <div class="link" id="backToStep1">← Back to user selection</div>
        </div>

    </div>

    <script>
        const userTypeButtons = document.querySelectorAll('.info-box');
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
