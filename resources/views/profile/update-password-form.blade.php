<x-jet-form-section submit="updatePassword">
  <x-slot name="title">
    {{ __('Update Password') }}
  </x-slot>

  <x-slot name="description">
    {{ __('Ensure your account is using a long, random password to stay secure.') }}
  </x-slot>

  <x-slot name="form">
    <div class="col-span-6 sm:col-span-4">
      <x-jet-label for="current_password" value="{{ __('Current Password') }}" />
      <x-password-input id="current_password" class="mt-1 block" wire:model.defer="state.current_password"
        autocomplete="current-password" />
      <x-jet-input-error for="current_password" class="mt-2" />
    </div>

    <div class="col-span-6 sm:col-span-4">
      <x-jet-label for="password" value="{{ __('New Password') }}" />
      <x-password-input id="password" class="mt-1 block w-full" wire:model.defer="state.password"
        autocomplete="new-password" />
      <x-jet-input-error for="password" class="mt-2" />
    </div>
  </x-slot>

  <x-slot name="actions">
    <x-jet-action-message class="mr-3" on="saved">
      {{ __('Saved.') }}
    </x-jet-action-message>

    <x-jet-button type="submit">
      {{ __('Save') }}
    </x-jet-button>
  </x-slot>
</x-jet-form-section>
