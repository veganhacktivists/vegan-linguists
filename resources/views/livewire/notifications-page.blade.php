@php
use App\Notifications\ClaimedTranslationRequestDeletedNotification;
use App\Notifications\TranslationRequestClaimRevokedNotification;
use App\Notifications\TranslationRequestClaimedNotification;
use App\Notifications\TranslationRequestCommentedOnNotification;
use App\Notifications\TranslationRequestUnclaimedNotification;
use App\Notifications\TranslationSubmittedNotification;
@endphp

<div class="max-w-7xl mx-auto px-4 pb-4">

    <div class="flex justify-between items-center my-4">
        <h2 class="text-2xl font-bold">
            {{ __('Notifications') }}
        </h2>

        <div>
            <x-jet-secondary-button type="button"
                                    wire:click="markAllAsRead">
                {{ __('Mark all as read') }}
            </x-jet-secondary-button>
        </div>
    </div>

    @if ($notifications->count() > 0)
        <ul role="list"
            class="divide-y divide-brandBrown-200 rounded-md overflow-hidden shadow">
            @foreach ($notifications as $notification)
                <li
                    class="p-4 transition-colors ease-linear duration-200 {{ $notification->read_at ? 'bg-white' : 'bg-brandClay-200 bg-opacity-50' }}">
                    @switch ($notification->type)
                        @case (TranslationRequestCommentedOnNotification::class)
                            <x-notifications.translation-request-commented-on :notification="$notification"
                                                                              :modelCache="$modelCache" />
                        @break
                        @case (TranslationRequestClaimedNotification::class)
                            <x-notifications.translation-request-claimed :notification="$notification"
                                                                         :modelCache="$modelCache" />
                        @break
                        @case (TranslationRequestUnclaimedNotification::class)
                            <x-notifications.translation-request-unclaimed :notification="$notification"
                                                                           :modelCache="$modelCache" />
                        @break
                        @case (TranslationSubmittedNotification::class)
                            <x-notifications.translation-submitted :notification="$notification"
                                                                   :modelCache="$modelCache" />
                        @break
                        @case (TranslationRequestClaimRevokedNotification::class)
                            <x-notifications.translation-request-claim-revoked :notification="$notification"
                                                                               :modelCache="$modelCache" />
                        @break
                        @case (ClaimedTranslationRequestDeletedNotification::class)
                            <x-notifications.claimed-translation-request-deleted :notification="$notification"
                                                                                 :modelCache="$modelCache" />
                        @break
                    @endswitch
                </li>
            @endforeach
        </ul>
    @else
        <x-empty-state class="bg-white shadow rounded-md p-8"
                       icon="o-bell"
                       :title="__('You have no notifications')">
        </x-empty-state>
    @endif

</div>
