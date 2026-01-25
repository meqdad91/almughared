<div class="relative" x-data="{ open: false }" style="position: relative;">
    <button @click="open = ! open" class="flex items-center space-x-2 focus:outline-none">
        <div class="rounded-full overflow-hidden border border-gray-200" style="width: 32px; height: 32px;">
            @if(Auth::user()->avatar)
                @if(filter_var(Auth::user()->avatar, FILTER_VALIDATE_URL))
                    <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover"
                        style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}"
                        class="w-full h-full object-cover" style="width: 100%; height: 100%; object-fit: cover;">
                @endif
            @else
                <div class="w-full h-full bg-gray-300 flex items-center justify-center text-xs font-bold text-gray-600"
                    style="width: 100%; height: 100%;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            @endif
        </div>
        <span class="hidden sm:inline-block font-medium text-gray-700">{{ Auth::user()->name }}</span>
        <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd" />
        </svg>
    </button>

    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95" style="display: none; position: absolute; right: 0; margin-top: 0.5rem;"
        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 ring-1 ring-black ring-opacity-5">

        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
            {{ __('Profile') }}
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                {{ __('Log Out') }}
            </a>
        </form>
    </div>
</div>