<?php

namespace App\Notifications;

use App\Models\TranslationRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TranslationSubmittedNotification extends BaseNotification implements
    ShouldQueue
{
    use Queueable;

    public static function getTitle()
    {
        return __('Translation Submitted');
    }

    public static function getDescription()
    {
        return __('Get notified when your content has been translated');
    }

    public function __construct(
        private User $translator,
        private TranslationRequest $translationRequest
    ) {
    }

    public function toMail(User $notifiable)
    {
        $subject = $this->translationRequest->isUnderReview()
            ? __('Translation Submitted for Review')
            : __('Translation Completed');

        $body = $this->translationRequest->isUnderReview()
            ? __(
                ':translatorName has submitted the :languageName translation for :sourceTitle. It is now awaiting review.',
                [
                    'translatorName' =>
                        '**' .
                        (optional($this->translator)->name ?: __('Someone')) .
                        '**',
                    'languageName' =>
                        '**' . $this->translationRequest->language->name . '**',
                    'sourceTitle' =>
                        '**' . $this->translationRequest->source->title . '**',
                ]
            )
            : __(
                ':translatorName has completed the :languageName translation for :sourceTitle.',
                [
                    'translatorName' =>
                        '**' .
                        (optional($this->translator)->name ?: __('Someone')) .
                        '**',
                    'languageName' =>
                        '**' . $this->translationRequest->language->name . '**',
                    'sourceTitle' =>
                        '**' . $this->translationRequest->source->title . '**',
                ]
            );

        return (new MailMessage())
            ->subject($subject)
            ->line($body)
            ->action(
                __('View translation'),
                route('translation', [
                    $this->translationRequest->source->id,
                    $this->translationRequest->language->id,
                ])
            );
    }

    public function toArray(User $notifiable)
    {
        return [
            'translator_id' => $this->translator->id,
            'translation_request_id' => $this->translationRequest->id,
        ];
    }
}
