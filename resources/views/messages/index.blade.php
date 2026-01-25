<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Messages') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-0">
                <div class="container-fluid">
                    <div class="row">
                        @include('messages.partials.messenger')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>