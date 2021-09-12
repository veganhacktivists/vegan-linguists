@php
    use App\Notifications\ClaimedTranslationRequestDeletedNotification;
    use App\Notifications\TranslationRequestClaimRevokedNotification;
    use App\Notifications\TranslationRequestClaimedNotification;
    use App\Notifications\TranslationRequestCommentedOnNotification;
    use App\Notifications\TranslationRequestUnclaimedNotification;
    use App\Notifications\TranslationSubmittedNotification;

    $notifications = Auth::user()->notifications;
@endphp

<div class="max-w-7xl mx-auto px-4 pb-4">

    <div class="text-right my-4">
        <x-jet-secondary-button type="button" wire:click="markAllAsRead">
            {{ __('Mark all as read') }}
        </x-jet-secondary-button>
    </div>

    @if ($notifications->count() > 0)
        <ul role="list" class="divide-y divide-gray-200 rounded-md overflow-hidden shadow">
            @foreach (Auth::user()->notifications as $notification)
                <li class="p-4 transition-colors ease-linear duration-200 {{ $notification->read_at ? 'bg-white' : 'bg-indigo-100' }}">
                    @switch ($notification->type)
                    @case (TranslationRequestCommentedOnNotification::class)
                        <x-notifications.translation-request-commented-on :notification="$notification" />
                    @break
                    @case (TranslationRequestClaimedNotification::class)
                        <x-notifications.translation-request-claimed :notification="$notification" />
                    @break
                    @case (TranslationRequestUnclaimedNotification::class)
                        <x-notifications.translation-request-unclaimed :notification="$notification" />
                    @break
                    @case (TranslationSubmittedNotification::class)
                        <x-notifications.translation-submitted :notification="$notification" />
                    @break
                    @case (TranslationRequestClaimRevokedNotification::class)
                        <x-notifications.translation-request-claim-revoked :notification="$notification" />
                    @break
                    @case (ClaimedTranslationRequestDeletedNotification::class)
                        <x-notifications.claimed-translation-request-deleted :notification="$notification" />
                    @break
                    @endswitch
                </li>
            @endforeach
        </ul>
    @else
        <x-empty-state class="bg-white shadow rounded p-8"
                       icon="o-bell"
                       :title="__('You have no notifications')">
        </x-empty-state>
    @endif

</div>