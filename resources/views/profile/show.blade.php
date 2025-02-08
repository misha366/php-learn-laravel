@extends("layouts.auth")

@section("content")
    <div class="container mt-5">
        <h2 class="text-center mb-4">{{ __('Profile') }}</h2>

        @if (Laravel\Fortify\Features::canUpdateProfileInformation())
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">{{ __('Update Profile Information') }}</div>
                <div class="card-body">
                    @livewire('profile.update-profile-information-form')
                </div>
            </div>
        @endif

        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">{{ __('Update Password') }}</div>
                <div class="card-body">
                    @livewire('profile.update-password-form')
                </div>
            </div>
        @endif

        @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">{{ __('Two-Factor Authentication') }}</div>
                <div class="card-body">
                    @livewire('profile.two-factor-authentication-form')
                </div>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">{{ __('Logout Other Browser Sessions') }}</div>
            <div class="card-body">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>
        </div>

        @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
            <div class="card mb-4">
                <div class="card-header bg-danger text-white">{{ __('Delete Account') }}</div>
                <div class="card-body">
                    @livewire('profile.delete-user-form')
                </div>
            </div>
        @endif
    </div>
@endsection
