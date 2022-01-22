<?php

namespace App\Notifications;

use App\Models\TranslationRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TranslationSubmittedNotification extends Notification implements BaseNotification, ShouldQueue
{
    use Queueable;

    public static function getTitle()
    {
        return __('Translation Submitted');
    }

    public static function getDescription()
    {

        return __("Get notified when your content has been translated");
    }

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(private User $translator, private TranslationRequest $translationRequest)
    {
        //
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
        $subject = $this->translationRequest->isUnderReview()
            ? __('Translation Submitted for Review')
            : __('Translation Completed');

        $body = $this->translationRequest->isUnderReview()
            ?  __(':translatorName has submitted the :languageName translation for :sourceTitle. It is now awaiting review.', [
                'translatorName' => '**' . (optional($this->translator)->name ?: __('Someone')) . '**',
                'languageName' => '**' . $this->translationRequest->language->name . '**',
                'sourceTitle' => '**' . $this->translationRequest->source->title . '**',
            ])

            :
            __(':translatorName has completed the :languageName translation for :sourceTitle.', [
                'translatorName' => '**' . (optional($this->translator)->name ?: __('Someone')) . '**',
                'languageName' => '**' . $this->translationRequest->language->name . '**',
                'sourceTitle' => '**' . $this->translationRequest->source->title . '**',
            ]);

        return (new MailMessage)
            ->subject($subject)
            ->line($body)
            ->action(
                __('View Translation'),
                route('translation', [$this->translationRequest->source->id, $this->translationRequest->language->id])
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
