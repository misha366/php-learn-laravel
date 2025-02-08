<div class="card">
    <div class="card-header">
        <h5 class="card-title">{{ __('Delete Account') }}</h5>
        <p class="card-text text-muted">{{ __('Permanently delete your account.') }}</p>
    </div>

    <div class="card-body">
        <p class="text-muted">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>

        <div class="mt-4">
            <button type="button" class="btn btn-danger" wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                {{ __('Delete Account') }}
            </button>
        </div>
    </div>

    <!-- Delete User Confirmation Modal -->
    <div class="modal fade" tabindex="-1" wire:model.live="confirmingUserDeletion">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Delete Account') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>
                        {{ __('Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>
                    <div class="mt-3">
                        <input type="password" class="form-control"
                               placeholder="{{ __('Password') }}"
                               autocomplete="current-password"
                               wire:model="password"
                               wire:keydown.enter="deleteUser">
                        <x-input-error for="password" class="mt-2" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </button>
                    <button type="button" class="btn btn-danger ms-2" wire:click="deleteUser" wire:loading.attr="disabled">
                        {{ __('Delete Account') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
