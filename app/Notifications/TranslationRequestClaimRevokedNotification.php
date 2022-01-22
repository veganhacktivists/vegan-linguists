<?php

namespace App\Notifications;

use App\Models\TranslationRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TranslationRequestClaimRevokedNotification extends Notification implements BaseNotification, ShouldQueue
{
    use Queueable;

    public static function getTitle()
    {
        return __('Translation Request Claim Revoked');
    }

    public static function getDescription()
    {
        return __("Get notified when your claim on a translation request is revoked");
    }

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(private User $author, private TranslationRequest $translationRequest)
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
        return (new MailMessage)
            ->subject(__('Translation Request Claim Revoked'))
            ->line(
                __('Your claim on the :languageName translation for :sourceTitle has been revoked.', [
                    'languageName' => '<strong>' . $this->translationRequest->language->name . '</strong>',
                    'sourceTitle' => '<strong>' . $this->translationRequest->source->title . '</strong>',
                ])
            )
            ->action(
                __('View Your Claimed Translation Requests'),
                route('home')
            );
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
            'author_id' => $this->author->id,
            'translation_request_id' => $this->translationRequest->id,
        ];
    }
}
