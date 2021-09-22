<x-jet-form-section submit="">
    <x-slot name="title">
        {{ __('Notification Settings') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Choose which notifications you would like to receive.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-12">
            <fieldset class="border-brandBrown-200">
                <div class="divide-y divide-brandBrown-200">
                    @foreach ($notificationSettings as $notificationSetting)
                        <div
                             class="relative flex items-start {{ $loop->first ? '' : 'pt-4' }} {{ $loop->last ? '' : 'pb-4' }}">
                            <div class="min-w-0 flex-1 text-sm">
                                <h4 class="text-brandBrown-900">{{ $notificationSetting->title }}</h4>
                                <p class="text-brandBrown-500">
                                    {{ $notificationSetting->description }}
                                </p>
                            </div>
                            <div class="ml-3 flex items-center h-5">
                                <label class="cursor-pointer">
                                    <div class="sr-only">
                                        {{ $notificationSetting->description }} ({{ __('Website') }})
                                    </div>

                                    <input type="checkbox"
                                           class="sr-only peer"
                                           wire:change="updateWebsiteNotificationSetting('{{ addslashes($notificationSetting->notification_type) }}', $event.target.checked)"
                                           {{ $notificationSetting->site ? 'checked' : '' }} />

                                    <x-heroicon-o-desktop-computer data-tooltip="{{ __('Website') }}"
                                                                   class="w-6 h-6 text-brandBrown-400 peer-checked:text-brandBrown-800" />

                                </label>
                            </div>
                            <div class="ml-3 flex items-center h-5">
                                <label class="cursor-pointer">
                                    <div class="sr-only">
                                        {{ $notificationSetting->description }} ({{ __('Email') }})
                                    </div>

                                    <input type="checkbox"
                                           class="sr-only peer"
                                           wire:change="updateEmailNotificationSetting('{{ addslashes($notificationSetting->notification_type) }}', $event.target.checked)"
                                           {{ $notificationSetting->email ? 'checked' : '' }} />

                                    <x-heroicon-o-mail data-tooltip="{{ __('Email') }}"
                                                       class="w-6 h-6 transition-color text-brandBrown-400 peer-checked:text-brandBrown-800" />
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </fieldset>
        </div>
    </x-slot>
</x-jet-form-section>
