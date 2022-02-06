<?php

namespace App\Notifications;

use App\Models\TranslationRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TranslationRequestReviewerAddedNotification extends BaseNotification implements ShouldQueue
{
    use Queueable;

    public static function getTitle()
    {
        return __('Translation Under Review');
    }

    public static function getDescription()
    {
        return __("Get notified when someone starts reviewing a translation request");
    }

    public function __construct(private TranslationRequest $translationRequest, private User $reviewer)
    {
    }

    public function toMail(User $notifiable)
    {
        $source = $this->translationRequest->source;

        $route = $notifiable->id === $source->author_id
            ? route('translation', [$source->id, $this->translationRequest->language->id]) // notifying the author
            : route('translate', [$this->translationRequest->id, $source->slug]); // notifying translator

        return (new MailMessage)
            ->subject(__('New Reviewer on Translation'))
            ->line(
                __(':userName has started reviewing the :languageName translation for :sourceTitle.', [
                    'userName' => '**' . $this->reviewer->name . '**',
                    'languageName' => '**' . $this->translationRequest->language->name . '**',
                    'sourceTitle' => '**' . $this->translationRequest->source->title . '**',
                ])
            )
            ->action(
                __('View translation'),
                $route,
            );
    }

    public function toArray(User $notifiable)
    {
        return [
            'translation_request_id' => $this->translationRequest->id,
            'reviewer_id' => $this->reviewer->id,
        ];
    }
}
