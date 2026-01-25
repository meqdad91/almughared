@php
    if (!function_exists('isActive')) {
        function isActive($routes)
        {
            return request()->routeIs($routes) ? 'active' : '';
        }
    }
@endphp

<div class="col-md-2 bg-light min-vh-100 p-3">
    <ul class="nav flex-column sidebar">
        <li class="nav-title">Main Menu</li>
        <li class="nav-item">
            <a class="nav-link {{ isActive('trainer.dashboard') }}" href="{{ route('trainer.dashboard') }}">🏠 Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ isActive('trainer.session') }}" href="{{ route('trainer.session.active') }}">🕒 Sessions</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ isActive(['trainer.session.pending', 'trainer.subjects.pending*']) }}" href="{{ route('trainer.session.pending') }}">🕒 Pending Sessions</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ isActive('messages.*') }}" href="{{ route('messages.index') }}">
                💬 Messages
                @php
                    $unreadCount = \App\Http\Controllers\MessageController::getUnreadCount(\Illuminate\Support\Facades\Auth::guard('trainer')->user());
                @endphp
                @if($unreadCount > 0)
                    <span class="badge bg-danger rounded-pill ms-1">{{ $unreadCount }}</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="nav-link btn btn-link border-0 p-0" style="color: inherit; text-decoration: none;">
                    🚪 Logout
                </button>
            </form>
        </li>
    </ul>
</div>
