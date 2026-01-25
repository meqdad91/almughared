@extends($layout)

@section('content')
    <div class="col-md-9 col-lg-10 p-4"> <!-- Main Content Column -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
            {{ __('Profile') }}
        </h2>

        <div class="space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>


        </div>
    </div>
@endsection