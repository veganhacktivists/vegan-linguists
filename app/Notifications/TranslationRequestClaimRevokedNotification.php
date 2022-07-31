<?php

namespace App\Notifications;

use App\Models\TranslationRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TranslationRequestClaimRevokedNotification
    extends BaseNotification
    implements ShouldQueue
{
    use Queueable;

    public static function getTitle()
    {
        return __('Translation Request Claim Revoked');
    }

    public static function getDescription()
    {
        return __(
            'Get notified when your claim on a translation request is revoked'
        );
    }

    public function __construct(
        private User $author,
        private TranslationRequest $translationRequest
    ) {
    }

    public function toMail(User $notifiable)
    {
        return (new MailMessage())
            ->subject(__('Translation Request Claim Revoked'))
            ->line(
                __(
                    'Your claim on the :languageName translation for :sourceTitle has been revoked.',
                    [
                        'languageName' =>
                            '<strong>' .
                            $this->translationRequest->language->name .
                            '</strong>',
                        'sourceTitle' =>
                            '<strong>' .
                            $this->translationRequest->source->title .
                            '</strong>',
                    ]
                )
            )
            ->action(
                __('View your claimed translation requests'),
                claimedTranslationRequestsRoute()
            );
    }

    public function toArray(User $notifiable)
    {
        return [
            'author_id' => $this->author->id,
            'translation_request_id' => $this->translationRequest->id,
        ];
    }
}
