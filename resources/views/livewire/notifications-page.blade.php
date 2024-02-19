@php
use App\Notifications\ClaimedTranslationRequestDeletedNotification;
use App\Notifications\TranslationRequestApprovedNotification;
use App\Notifications\TranslationRequestClaimRevokedNotification;
use App\Notifications\TranslationRequestClaimedNotification;
use App\Notifications\TranslationRequestCommentedOnNotification;
use App\Notifications\TranslationRequestCommentResolvedNotification;
use App\Notifications\TranslationRequestReviewerAddedNotification;
use App\Notifications\TranslationRequestUnclaimedNotification;
use App\Notifications\TranslationSubmittedNotification;
@endphp

<x-page-container>

  <div class="my-4 flex items-center justify-between">
    <h2 class="text-2xl font-bold">
      {{ __('Notifications') }}
    </h2>

    <div>
      <x-secondary-button type="button" wire:click="markAllAsRead">
        {{ __('Mark all as read') }}
      </x-secondary-button>
    </div>
  </div>

  @if ($notifications->count() > 0)
    <ul role="list" class="divide-y divide-brand-brown-200 overflow-hidden rounded-md shadow">
      @foreach ($notifications as $notification)
        <li
          class="{{ $notification->read_at ? 'bg-white' : 'bg-brand-clay-200 bg-opacity-50' }} p-4 transition-colors duration-200 ease-linear">
          @switch ($notification->type)
            @case (ClaimedTranslationRequestDeletedNotification::class)
              <x-notifications.claimed-translation-request-deleted :notification="$notification" :modelCache="$modelCache" />
            @break

            @case (TranslationRequestApprovedNotification::class)
              <x-notifications.translation-request-approved :notification="$notification" :modelCache="$modelCache" />
            @break

            @case (TranslationRequestClaimRevokedNotification::class)
              <x-notifications.translation-request-claim-revoked :notification="$notification" :modelCache="$modelCache" />
            @break

            @case (TranslationRequestClaimedNotification::class)
              <x-notifications.translation-request-claimed :notification="$notification" :modelCache="$modelCache" />
            @break

            @case (TranslationRequestCommentedOnNotification::class)
              <x-notifications.translation-request-commented-on :notification="$notification" :modelCache="$modelCache" />
            @break

            @case (TranslationRequestCommentResolvedNotification::class)
              <x-notifications.translation-request-comment-resolved :notification="$notification" :modelCache="$modelCache" />
            @break

            @case (TranslationRequestReviewerAddedNotification::class)
              <x-notifications.translation-request-reviewer-added :notification="$notification" :modelCache="$modelCache" />
            @break

            @case (TranslationRequestUnclaimedNotification::class)
              <x-notifications.translation-request-unclaimed :notification="$notification" :modelCache="$modelCache" />
            @break

            @case (TranslationSubmittedNotification::class)
              <x-notifications.translation-submitted :notification="$notification" :modelCache="$modelCache" />
            @break
          @endswitch
        </li>
      @endforeach
    </ul>

    <div class="mt-4">
      {{ $notifications->links() }}
    </div>
  @else
    <x-empty-state class="rounded-md bg-white p-8 shadow" icon="o-bell" :title="__('You have no notifications')">
    </x-empty-state>
  @endif
</x-page-container>
