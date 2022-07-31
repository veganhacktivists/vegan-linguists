<?php

namespace App\Notifications;

use App\Models\TranslationRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TranslationRequestClaimedNotification extends BaseNotification implements
    ShouldQueue
{
    use Queueable;

    public static function getTitle()
    {
        return __('Translation Request Claimed');
    }

    public static function getDescription()
    {
        return __(
            'Get notified when your content has been claimed by a translator'
        );
    }

    public function __construct(
        private User $translator,
        private TranslationRequest $translationRequest
    ) {
    }

    public function toMail(User $notifiable)
    {
        return (new MailMessage())
            ->subject(__('Translation Request Claimed'))
            ->line(
                __(
                    ':translatorName has claimed the :languageName translation for :sourceTitle.',
                    [
                        'translatorName' =>
                            '**' .
                            (optional($this->translator)->name ?:
                                __('Someone')) .
                            '**',
                        'languageName' =>
                            '**' .
                            $this->translationRequest->language->name .
                            '**',
                        'sourceTitle' =>
                            '**' .
                            $this->translationRequest->source->title .
                            '**',
                    ]
                )
            )
            ->action(__('View your translation requests'), route('home'));
    }

    public function toArray(User $notifiable)
    {
        return [
            'translator_id' => $this->translator->id,
            'translation_request_id' => $this->translationRequest->id,
        ];
    }
}
