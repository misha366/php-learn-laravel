<div class="card">
    <div class="card-header">
        <h5 class="card-title">{{ __('Profile Information') }}</h5>
        <p class="card-text text-muted">{{ __('Update your account\'s profile information and email address.') }}</p>
    </div>

    <form wire:submit.prevent="updateProfileInformation">
        <div class="card-body">
            <!-- Profile Photo -->
            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <div x-data="{photoName: null, photoPreview: null}" class="mb-3">
                    <label for="photo" class="form-label">{{ __('Photo') }}</label>
                    <input type="file" id="photo" class="form-control d-none"
                           wire:model.live="photo"
                           x-ref="photo"
                           x-on:change="
                                photoName = $refs.photo.files[0].name;
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    photoPreview = e.target.result;
                                };
                                reader.readAsDataURL($refs.photo.files[0]);
                           " />

                    <div class="mt-2">
                        <!-- Current Profile Photo -->
                        <div x-show="! photoPreview" class="mb-2">
                            <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-circle" style="height: 80px; width: 80px;">
                        </div>

                        <!-- New Profile Photo Preview -->
                        <div x-show="photoPreview" style="display: none;" class="mb-2">
                            <div class="rounded-circle" style="height: 80px; width: 80px; background-size: cover; background-position: center;"
                                 x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-secondary me-2 mt-2" x-on:click.prevent="$refs.photo.click()">
                        {{ __('Select A New Photo') }}
                    </button>

                    @if ($this->user->profile_photo_path)
                        <button type="button" class="btn btn-danger mt-2" wire:click="deleteProfilePhoto">
                            {{ __('Remove Photo') }}
                        </button>
                    @endif

                    <x-input-error for="photo" class="mt-2" />
                </div>
            @endif

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">{{ __('Name') }}</label>
                <input type="text" id="name" class="form-control" wire:model="state.name" required autocomplete="name">
                <x-input-error for="name" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input type="email" id="email" class="form-control" wire:model="state.email" required autocomplete="username">
                <x-input-error for="email" class="mt-2" />

                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                    <p class="text-sm mt-2 text-warning">
                        {{ __('Your email address is unverified.') }}
                        <button type="button" class="btn btn-link p-0 text-decoration-underline" wire:click.prevent="sendEmailVerification">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if ($this->verificationLinkSent)
                        <p class="mt-2 text-success">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                @endif
            </div>
        </div>

        <div class="card-footer d-flex justify-content-end">
            <x-action-message class="me-3" on="saved">
                {{ __('Saved.') }}
            </x-action-message>
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="photo">
                {{ __('Save') }}
            </button>
        </div>
    </form>
</div>
