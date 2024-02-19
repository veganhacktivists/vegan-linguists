<x-form-section submit="">
  <x-slot name="title">
    {{ __('Notification Settings') }}
  </x-slot>

  <x-slot name="description">
    {{ __('Choose which notifications you would like to receive.') }}
  </x-slot>

  <x-slot name="form">
    <div class="col-span-12">
      <fieldset class="border-brand-brown-200">
        <div class="divide-y divide-brand-brown-200">
          @foreach ($notificationSettings as $notificationSetting)
            <div class="{{ $loop->first ? '' : 'pt-4' }} {{ $loop->last ? '' : 'pb-4' }} relative flex items-center">
              <div class="min-w-0 flex-1 text-sm">
                <h4 class="text-brand-brown-900">{{ $notificationSetting->title }}</h4>
                <p class="text-brand-brown-500">
                  {{ $notificationSetting->description }}
                </p>
              </div>
              @if ($notificationSetting->isDatabaseEnabled())
                <div class="ml-3 flex h-5 items-center">
                  <label class="cursor-pointer">
                    <div class="sr-only">
                      {{ $notificationSetting->description }} ({{ __('Website') }})
                    </div>

                    <input type="checkbox" class="peer sr-only"
                      wire:change="updateWebsiteNotificationSetting('{{ addslashes($notificationSetting->notification_type) }}', $event.target.checked)"
                      {{ $notificationSetting->site ? 'checked' : '' }} />

                    <x-heroicon-o-computer-desktop data-tooltip="{{ __('Website') }}"
                      class="h-6 w-6 text-brand-brown-400 peer-checked:text-brand-brown-800" />

                  </label>
                </div>
              @endif

              @if ($notificationSetting->isMailEnabled())
                <div class="ml-3 flex h-5 items-center">
                  <label class="cursor-pointer">
                    <div class="sr-only">
                      {{ $notificationSetting->description }} ({{ __('Email') }})
                    </div>

                    <input type="checkbox" class="peer sr-only"
                      wire:change="updateEmailNotificationSetting('{{ addslashes($notificationSetting->notification_type) }}', $event.target.checked)"
                      {{ $notificationSetting->email ? 'checked' : '' }} />

                    <x-heroicon-o-envelope data-tooltip="{{ __('Email') }}"
                      class="transition-color h-6 w-6 text-brand-brown-400 peer-checked:text-brand-brown-800" />
                  </label>
                </div>
              @endif
            </div>
          @endforeach
        </div>
      </fieldset>
    </div>
  </x-slot>
</x-form-section>
