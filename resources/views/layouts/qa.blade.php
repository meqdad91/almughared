<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Almughared - QA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/45.2.0/ckeditor5.css">
    @yield('head')
</head>

<body>
    @php
        if (!function_exists('isActive')) {
            function isActive($routes) {
                return request()->routeIs($routes) ? 'active' : '';
            }
        }
        $currentUser = \Illuminate\Support\Facades\Auth::guard('qa')->user();
        $unreadCount = \App\Http\Controllers\MessageController::getUnreadCount($currentUser);
    @endphp

    <nav class="navbar navbar-expand-lg app-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('qa.dashboard') }}">Almughared</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#qaNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="qaNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ isActive('qa.dashboard') }}" href="{{ route('qa.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ isActive(['qa.session.pending', 'qa.subjects.pending*']) }}" href="{{ route('qa.session.pending') }}">Pending Sessions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ isActive(['qa.session.active', 'qa.subjects.active*', 'qa.subjects.show']) }}" href="{{ route('qa.session.active') }}">Active Sessions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ isActive('qa.weekly-plans.*') }}" href="{{ route('qa.weekly-plans.pending') }}">Pending Plans</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ isActive('messages.*') }}" href="{{ route('messages.index') }}">
                            Messages
                            @if($unreadCount > 0)
                                <span class="badge bg-danger rounded-pill">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    </li>
                </ul>

                <div class="user-dropdown dropdown">
                    <button class="btn dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @if($currentUser->avatar)
                            @if(filter_var($currentUser->avatar, FILTER_VALIDATE_URL))
                                <img src="{{ $currentUser->avatar }}" alt="" class="user-avatar">
                            @else
                                <img src="{{ asset('storage/' . $currentUser->avatar) }}" alt="" class="user-avatar">
                            @endif
                        @else
                            <span class="user-avatar-placeholder">{{ strtoupper(substr($currentUser->name, 0, 1)) }}</span>
                        @endif
                        {{ $currentUser->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Logout</button>
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
