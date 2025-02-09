@extends("layouts.auth")
@section("content")
    <x-errors.error-messages
        errTitle="Two-Factor Authentication"
        errSubtitle="Please confirm access to your account"
    ></x-errors.error-messages>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Two-Factor Authentication</h4>
                    </div>
                    <div class="card-body">
                        <p id="auth-text" class="mb-4 text-sm text-gray-600">
                            {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
                        </p>

                        <form method="POST" action="{{ route('two-factor.login') }}">
                            @csrf
                            <div id="auth-code-group">
                                <div class="mb-3">
                                    <label for="code" class="form-label">{{ __('Code') }}</label>
                                    <input type="text" class="form-control" id="code" name="code" inputmode="numeric" autocomplete="one-time-code" autofocus>
                                </div>
                            </div>

                            <div id="recovery-code-group" class="d-none">
                                <div class="mb-3">
                                    <label for="recovery_code" class="form-label">{{ __('Recovery Code') }}</label>
                                    <input type="text" class="form-control" id="recovery_code" name="recovery_code" autocomplete="one-time-code">
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <button type="button" class="btn btn-link p-0 text-decoration-none" id="toggle-recovery">
                                    {{ __('Use a recovery code') }}
                                </button>
                                <button type="submit" class="btn btn-primary">{{ __('Log in') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleButton = document.getElementById('toggle-recovery');
            const authCodeGroup = document.getElementById('auth-code-group');
            const recoveryCodeGroup = document.getElementById('recovery-code-group');
            const authText = document.getElementById('auth-text');

            let usingRecoveryCode = false;

            toggleButton.addEventListener('click', function () {
                usingRecoveryCode = !usingRecoveryCode;
                authCodeGroup.classList.toggle('d-none', usingRecoveryCode);
                recoveryCodeGroup.classList.toggle('d-none', !usingRecoveryCode);

                toggleButton.textContent = usingRecoveryCode
                    ? '{{ __('Use an authentication code') }}'
                    : '{{ __('Use a recovery code') }}';

                authText.textContent = usingRecoveryCode
                    ? '{{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}'
                    : '{{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}';
            });
        });
    </script>
@endsection
