@php
    if (!function_exists('isActive')) {
        function isActive($routes)
        {
            return request()->routeIs($routes) ? 'active' : '';
        }
    }

    $usersMenuOpen = request()->routeIs('admin.users.*');
@endphp
<div class="col-md-2 bg-light min-vh-100 p-3">
    <ul class="nav flex-column sidebar">

        <li class="nav-title">Main Menu</li>

        {{-- Dashboard --}}
        <li class="nav-item">
            <a class="nav-link {{ isActive('admin.dashboard') }}" href="{{ route('admin.dashboard') }}">
                🏠 Dashboard
            </a>
        </li>

        {{-- Manage Users --}}
        <li class="nav-item">
            <a class="nav-link {{ $usersMenuOpen ? '' : 'collapsed' }}" data-bs-toggle="collapse"
                href="#userManagementMenu" role="button" aria-expanded="{{ $usersMenuOpen ? 'true' : 'false' }}"
                aria-controls="userManagementMenu">
                👥 Manage Users
            </a>

            <div class="collapse ps-3 {{ $usersMenuOpen ? 'show' : '' }}" id="userManagementMenu">

                <ul class="nav flex-column">

                    <li class="nav-item">
                        <a class="nav-link {{ isActive('admin.users.admins.*') }}"
                            href="{{ route('admin.users.admins.index') }}">
                            🧑‍💼 Admins
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ isActive('admin.users.qas.*') }}"
                            href="{{ route('admin.users.qas.index') }}">
                            🧪 QAs
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ isActive('admin.users.trainers.*') }}"
                            href="{{ route('admin.users.trainers.index') }}">
                            👨‍🏫 Teachers
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ isActive('admin.users.trainees.*') }}"
                            href="{{ route('admin.users.trainees.index') }}">
                            👨‍🎓 Students
                        </a>
                    </li>

                </ul>
            </div>
        </li>

        {{-- Sessions --}}
        <li class="nav-item">
            <a class="nav-link {{ isActive('admin.users.sessions.*') }}"
                href="{{ route('admin.users.sessions.index') }}">
                🕒 Sessions
            </a>
        </li>

        {{-- Subjects --}}
        <li class="nav-item">
            <a class="nav-link {{ isActive('admin.users.subjects.*') }}"
                href="{{ route('admin.users.subjects.allSubjects') }}">
                📚 Subjects
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ isActive('admin.users.subjects.pending') }}"
                href="{{ route('admin.users.subjects.pending') }}">
                ⏳ Pending Subjects
            </a>
        </li>

        {{-- Reviews --}}
        <li class="nav-item">
            <a class="nav-link {{ isActive('admin.users.reviews.*') }}" href="{{ route('admin.users.reviews.index') }}">
                📝 Reviews
            </a>
        </li>

        {{-- Attendance --}}
        <li class="nav-item">
            <a class="nav-link {{ isActive('admin.users.attendance.*') }}" href="{{ route('admin.users.attendance.index') }}">
                📋 Attendance
            </a>
        </li>

        {{-- Messages --}}
        <li class="nav-item">
            <a class="nav-link {{ isActive('messages.*') }}" href="{{ route('messages.index') }}">
                💬 Messages
                @php
                    $unreadCount = \App\Http\Controllers\MessageController::getUnreadCount(\Illuminate\Support\Facades\Auth::guard('admin')->user());
                @endphp
                @if($unreadCount > 0)
                    <span class="badge bg-danger rounded-pill ms-1">{{ $unreadCount }}</span>
                @endif
            </a>
        </li>

        {{-- Logout --}}
        <li class="nav-item mt-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link btn btn-link border-0 p-0">
                    🚪 Logout
                </button>
            </form>
        </li>

    </ul>
</div>