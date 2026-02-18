<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/45.2.0/ckeditor5.css">
    @yield('head')
</head>

<body>
    @php
        $unreadCount = \App\Http\Controllers\MessageController::getUnreadCount(\Illuminate\Support\Facades\Auth::guard('admin')->user());
    @endphp

    <nav class="app-navbar navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Almughared</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.users.admins.*') || request()->routeIs('admin.users.qas.*') || request()->routeIs('admin.users.trainers.*') || request()->routeIs('admin.users.trainees.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">Users</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.users.admins.index') }}">Admins</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.users.qas.index') }}">QA Staff</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.users.trainers.index') }}">Teachers</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.users.trainees.index') }}">Students</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users.sessions.*') ? 'active' : '' }}" href="{{ route('admin.users.sessions.index') }}">Sessions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users.weekly-plans.*') ? 'active' : '' }}" href="{{ route('admin.users.weekly-plans.index') }}">Plans</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users.reviews.*') ? 'active' : '' }}" href="{{ route('admin.users.reviews.index') }}">Reviews</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users.attendance.*') ? 'active' : '' }}" href="{{ route('admin.users.attendance.index') }}">Attendance</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('messages.*') ? 'active' : '' }}" href="{{ route('messages.index') }}">
                            Messages
                            @if($unreadCount > 0)
                                <span class="badge bg-danger rounded-pill ms-1">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
                <div class="user-dropdown dropdown">
                    <button class="btn dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="user-avatar d-flex align-items-center justify-content-center" style="background:rgba(255,255,255,0.2); color:#fff; font-weight:600; font-size:0.85rem;">{{ substr(Auth::guard('admin')->user()->name, 0, 1) }}</span>
                        {{ Auth::guard('admin')->user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="app-content">
        @yield('content')
    </div>

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>
