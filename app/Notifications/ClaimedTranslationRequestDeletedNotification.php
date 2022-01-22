<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClaimedTranslationRequestDeletedNotification extends Notification implements BaseNotification, ShouldQueue
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

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(private string $translationRequestTitle, private string $languageName, public string $userRelationship)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $media = [];

        if ($notifiable->shouldBeNotified(static::class, 'site')) {
            $media[] = 'database';
        }

        if ($notifiable->shouldBeNotified(static::class, 'email')) {
            $media[] = 'mail';
        }

        return $media;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $actionText = $this->userRelationship === self::RELATIONSHIP_TRANSLATOR
            ? __('View Your Translations')
            : __('View Your Translation Under Review');

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

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'translation_request_title' => $this->translationRequestTitle,
            'language_name' => $this->languageName,
        ];
    }
}
