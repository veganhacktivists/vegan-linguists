<?php

namespace App\Notifications;

use App\Models\TranslationRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TranslationRequestClaimedNotification extends Notification implements BaseNotification
{
    use Queueable;

    public static function getTitle()
    {
        return __('Translation Request Claimed');
    }

    public static function getDescription()
    {
        return __("Get notified when your content has been claimed by a translator");
    }

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(private User $translator, private TranslationRequest $translationRequest)
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
            ->subject(__('Translation Request Claimed'))
            ->line(
                __(':translatorName has claimed the :languageName translation for :sourceTitle.', [
                    'translatorName' => '**' . (optional($this->translator)->name ?: __('Someone')) . '**',
                    'languageName' => '**' . $this->translationRequest->language->name . '**',
                    'sourceTitle' => '**' . $this->translationRequest->source->title . '**',
                ])
            )
            ->action(
                __('View Your Translation Requests'),
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
            'translator_id' => $this->translator->id,
            'translation_request_id' => $this->translationRequest->id,
        ];
    }
}
