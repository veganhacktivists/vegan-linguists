<x-action-section>
  <x-slot name="title">
    {{ __('Delete Account') }}
  </x-slot>

  <x-slot name="description">
    {{ __('Permanently delete your account.') }}
  </x-slot>

  <x-slot name="content">
    <div class="max-w-xl text-sm text-gray-600">
      {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
    </div>

    <div class="mt-5">
      <x-danger-button wire:click="confirmUserDeletion" wire:loading.attr="disabled" type="button">
        {{ __('Delete account') }}
      </x-danger-button>
    </div>

    <!-- Delete User Confirmation Modal -->
    <x-dialog-modal wire:model.live="confirmingUserDeletion">
      <x-slot name="title">
        {{ __('Delete Account') }}
      </x-slot>

      <x-slot name="content">
        {{ __('Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}

        <div class="mt-4" x-data="{}"
          x-on:confirming-delete-user.window="setTimeout(() => $el.querySelector('input[type=password]').focus(), 250)">
          <x-password-input class="mt-1 block" containerClass="w-3/4" placeholder="{{ __('Password') }}"
            wire:model="password" wire:keydown.enter="deleteUser" />

          <x-input-error for="password" class="mt-2" />
        </div>
      </x-slot>

      <x-slot name="footer">
        <x-secondary-button type="button" wire:click="$toggle('confirmingUserDeletion')"
          wire:loading.attr="disabled">
          {{ __('Cancel') }}
        </x-secondary-button>

        <x-danger-button class="ml-2" wire:click="deleteUser" wire:loading.attr="disabled">
          {{ __('Delete account') }}
        </x-danger-button>
      </x-slot>
    </x-dialog-modal>
  </x-slot>
</x-action-section>
