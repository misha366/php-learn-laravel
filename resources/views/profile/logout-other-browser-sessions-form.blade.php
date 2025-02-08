<div class="card">
    <div class="card-header">
        <h5 class="card-title">{{ __('Browser Sessions') }}</h5>
        <p class="card-text text-muted">{{ __('Manage and log out your active sessions on other browsers and devices.') }}</p>
    </div>

    <div class="card-body">
        <p class="text-muted">
            {{ __('If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.') }}
        </p>

        @if (count($this->sessions) > 0)
            <div class="mt-4">
                @foreach ($this->sessions as $session)
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            @if ($session->agent->isDesktop())
                                <i class="bi bi-laptop text-secondary fs-2"></i>
                            @else
                                <i class="bi bi-phone text-secondary fs-2"></i>
                            @endif
                        </div>
                        <div>
                            <div class="text-muted small">
                                {{ $session->agent->platform() ? $session->agent->platform() : __('Unknown') }} -
                                {{ $session->agent->browser() ? $session->agent->browser() : __('Unknown') }}
                            </div>
                            <div class="text-muted small">
                                {{ $session->ip_address }},
                                @if ($session->is_current_device)
                                    <span class="text-success fw-semibold">{{ __('This device') }}</span>
                                @else
                                    {{ __('Last active') }} {{ $session->last_active }}
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="d-flex align-items-center mt-4">
            <button type="button" class="btn btn-primary" wire:click="confirmLogout" wire:loading.attr="disabled">
                {{ __('Log Out Other Browser Sessions') }}
            </button>
            <span class="ms-3 text-success small" wire:loading.remove wire:target="confirmLogout">
                {{ __('Done.') }}
            </span>
        </div>
    </div>

    <!-- Log Out Other Devices Confirmation Modal -->
    <div class="modal fade" tabindex="-1" wire:model.live="confirmingLogout">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Log Out Other Browser Sessions') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices.') }}</p>
                    <div class="mt-3">
                        <input type="password" class="form-control"
                               placeholder="{{ __('Password') }}"
                               autocomplete="current-password"
                               wire:model="password"
                               wire:keydown.enter="logoutOtherBrowserSessions">
                        <x-input-error for="password" class="mt-2" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="$toggle('confirmingLogout')" wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </button>
                    <button type="button" class="btn btn-danger ms-2" wire:click="logoutOtherBrowserSessions" wire:loading.attr="disabled">
                        {{ __('Log Out Other Browser Sessions') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
