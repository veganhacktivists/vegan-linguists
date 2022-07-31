<?php

namespace App\Http\Livewire\Profile;

use App\Models\NotificationSetting;
use App\Models\User;
use App\Notifications\ClaimedTranslationRequestDeletedNotification;
use App\Notifications\NewTranslationRequestsNotification;
use App\Notifications\TranslationRequestCommentResolvedNotification;
use App\Notifications\TranslationRequestApprovedNotification;
use App\Notifications\TranslationRequestClaimedNotification;
use App\Notifications\TranslationRequestClaimRevokedNotification;
use App\Notifications\TranslationRequestCommentedOnNotification;
use App\Notifications\TranslationRequestReviewerAddedNotification;
use App\Notifications\TranslationRequestUnclaimedNotification;
use App\Notifications\TranslationSubmittedNotification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationSettings extends Component
{
    public Collection $notificationSettings;

    public function mount()
    {
        $this->refreshNotificationSettings();
    }

    public function render()
    {
        return view('livewire.profile.notification-settings');
    }

    public function updateWebsiteNotificationSetting(
        string $notificationType,
        bool $enabled
    ) {
        $notificationSetting = Auth::user()
            ->notificationSettings()
            ->firstOrNew([
                'notification_type' => $notificationType,
            ]);

        $notificationSetting->site = $enabled;
        $notificationSetting->save();

        $this->refreshNotificationSettings();
    }

    public function updateEmailNotificationSetting(
        string $notificationType,
        bool $enabled
    ) {
        $notificationSetting = Auth::user()
            ->notificationSettings()
            ->firstOrNew([
                'notification_type' => $notificationType,
            ]);

        $notificationSetting->email = $enabled;
        $notificationSetting->save();

        $this->refreshNotificationSettings();
    }

    private function getDefaultNotificationSettings(User $user)
    {
        return collect([
            NewTranslationRequestsNotification::class,
            TranslationRequestClaimedNotification::class,
            TranslationRequestUnclaimedNotification::class,
            TranslationSubmittedNotification::class,
            TranslationRequestReviewerAddedNotification::class,
            TranslationRequestApprovedNotification::class,
            TranslationRequestCommentedOnNotification::class,
            TranslationRequestCommentResolvedNotification::class,
            TranslationRequestClaimRevokedNotification::class,
            ClaimedTranslationRequestDeletedNotification::class,
        ])->map(function (string $notificationType) use ($user) {
            return new NotificationSetting([
                'user_id' => $user->id,
                'notification_type' => $notificationType,
            ]);
        });
    }

    private function refreshNotificationSettings()
    {
        $user = Auth::user();

        $this->notificationSettings = $this->getDefaultNotificationSettings(
            $user
        )
            ->merge($user->notificationSettings)
            ->keyBy('notification_type');
    }
}
