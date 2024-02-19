<x-form-section submit="updateProfileInformation">
  <x-slot name="title">
    {{ __('Profile Information') }}
  </x-slot>

  <x-slot name="description">
    {{ __('Update your account\'s profile information and email address.') }}
  </x-slot>

  <x-slot name="form">
    {{-- Profile Photo --}}
    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
      <div x-data="{ photoName: null, photoPreview: null }" class="col-span-6 sm:col-span-4">
        {{-- Profile Photo File Input --}}
        <input type="file" class="hidden" wire:model.live="photo" x-ref="photo"
          x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

        <x-label for="photo" value="{{ __('Photo') }}" />

        {{-- Current Profile Photo --}}
        <div class="mt-2" x-show="! photoPreview">
          <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
            class="h-20 w-20 rounded-full object-cover">
        </div>

        {{-- New Profile Photo Preview --}}
        <div class="mt-2" x-show="photoPreview">
          <span class="block h-20 w-20 rounded-full"
            x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' +
            photoPreview + '\');'">
          </span>
        </div>

        <x-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
          {{ __('Select a new photo') }}
        </x-secondary-button>

        @if ($this->user->profile_photo_path)
          <x-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
            {{ __('Remove photo') }}
          </x-secondary-button>
        @endif

        <x-input-error for="photo" class="mt-2" />
      </div>
    @endif

    {{-- Name --}}
    <div class="col-span-6 sm:col-span-4">
      <x-label for="name" value="{{ __('Name') }}" />
      <x-input id="name" type="text" class="mt-1 block w-full" wire:model="state.name"
        autocomplete="name" />
      <x-input-error for="name" class="mt-2" />
    </div>

    {{-- Email --}}
    <div class="col-span-6 sm:col-span-4">
      <x-label for="email" value="{{ __('Email') }}" />
      <x-input id="email" type="email" class="mt-1 block w-full" wire:model="state.email" />
      <x-input-error for="email" class="mt-2" />
    </div>

    {{-- Languages --}}
    <div class="col-span-6 sm:col-span-4">
      <x-label for="languages" value="{{ __('What language(s) do you speak?') }}" />
      <x-language-picker id="languages" class="mt-1 block" wire:model.live="state.languages" :defaultLanguages="$this->user->languages"
        shouldDisplayTranslatedLanguage />
      <x-input-error for="languages" class="mt-2" />
    </div>

    {{-- Newsletter --}}
    <div class="col-span-6 sm:col-span-4" id="newsletter-description">
      <x-label for="newsletter">
        <div class="flex items-center">
          <x-checkbox id="newsletter" aria-describedby="newsletter-description"
            wire:model.live="state.is_subscribed_to_newsletter" />
          <div class="ml-2">
            {{ __('Keep me updated with news related to Vegan Linguists') }}
          </div>
        </div>
      </x-label>
    </div>
  </x-slot>

  <x-slot name="actions">
    <x-action-message class="mr-3" on="saved">
      {{ __('Saved.') }}
    </x-action-message>

    <x-button type="submit" wire:loading.attr="disabled" wire:target="photo">
      {{ __('Save') }}
    </x-button>
  </x-slot>
</x-form-section>
