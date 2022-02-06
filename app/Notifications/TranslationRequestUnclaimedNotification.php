<?php

namespace App\Notifications;

use App\Models\TranslationRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TranslationRequestUnclaimedNotification extends BaseNotification implements ShouldQueue
{
    use Queueable;

    public static function getTitle()
    {
        return __('Translation Request Unclaimed');
    }

    public static function getDescription()
    {
        return __("Get notified when a translator unclaims one of your translation requests");
    }

    public function __construct(
        private mixed $translator, // prevent dependency injection
        private TranslationRequest $translationRequest
    ) {
    }

    public function toMail(User $notifiable)
    {
        return (new MailMessage)
            ->subject(__('Translation Request Unclaimed'))
            ->line(
                __(':translatorName has unclaimed the :languageName translation for :sourceTitle.', [
                    'translatorName' => '**' . (optional($this->translator)->name ?: __('Someone')) . '**',
                    'languageName' => '**' . $this->translationRequest->language->name . '**',
                    'sourceTitle' => '**' . $this->translationRequest->source->title . '**',
                ])
            )
            ->action(
                __('View your translation requests'),
                route('home')
            );
    }

    public function toArray(User $notifiable)
    {
        return [
            'translator_id' => optional($this->translator)->id,
            'translation_request_id' => $this->translationRequest->id,
        ];
    }
}
