@extends("layouts.auth")
@section("content")
    <x-errors.error-messages
        errTitle="Password Confirmation Error"
        errSubtitle="Please confirm your password to continue."
    ></x-errors.error-messages>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Confirm Password</h4>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-4">
                            This is a secure area of the application. Please confirm your password before continuing.
                        </p>

                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" type="password" class="form-control" name="password" required autofocus autocomplete="current-password">
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Confirm Password') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
