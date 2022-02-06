<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ClaimedTranslationRequestDeletedNotification extends BaseNotification implements ShouldQueue
{
    use Queueable;

    const RELATIONSHIP_TRANSLATOR = 'translator';
    const RELATIONSHIP_REVIEWER = 'reviewer';

    public static function getTitle()
    {
        return __('Claimed Translation Request Deleted');
    }

    public static function getDescription()
    {
        return __("Get notified when a translation request that you've claimed for translation or for review has been deleted");
    }

    public function __construct(
        private string $translationRequestTitle,
        private string $languageName,
        private string $userRelationship
    ) {
    }

    public function toMail(User $notifiable)
    {
        $actionText = $this->userRelationship === self::RELATIONSHIP_TRANSLATOR
            ? __('View your translations')
            : __('View your translation under review');

        $actionRoute = $this->userRelationship === self::RELATIONSHIP_TRANSLATOR
            ? claimedTranslationRequestsRoute()
            : underReviewTranslationRequestsRoute();

        return (new MailMessage)
            ->subject(__('Translation Request Deleted'))
            ->line(
                __('The :languageName translation request for :sourceTitle has been deleted.', [
                    'languageName' => '**' . $this->languageName . '**',
                    'sourceTitle' => '**' . $this->translationRequestTitle . '**',
                ])
            )
            ->action($actionText, $actionRoute);
    }

    public function toArray(User $notifiable)
    {
        return [
            'translation_request_title' => $this->translationRequestTitle,
            'language_name' => $this->languageName,
        ];
    }
}
