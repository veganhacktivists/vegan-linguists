<?php

namespace App\Notifications;

use App\Models\TranslationRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TranslationRequestApprovedNotification extends BaseNotification implements
    ShouldQueue
{
    use Queueable;

    public static function getTitle()
    {
        return __('Translation Approved');
    }

    public static function getDescription()
    {
        return __(
            'Get notified when a translation has been approved by a reviewer'
        );
    }

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        private TranslationRequest $translationRequest,
        private User $reviewer
    ) {
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(User $notifiable)
    {
        $source = $this->translationRequest->source;

        $route =
            $notifiable->id === $source->author_id
                ? route('translation', [
                    $source->id,
                    $this->translationRequest->language->id,
                ]) // notifying the author
                : route('translate', [
                    $this->translationRequest->id,
                    $source->slug,
                ]); // notifying translator

        if ($this->translationRequest->isComplete()) {
            $subject = __('Translation Completed');

            $body = __(
                ':userName has approved the :languageName translation for :sourceTitle, and it is officially completed.',
                [
                    'userName' => '**' . $this->reviewer->name . '**',
                    'languageName' =>
                        '**' . $this->translationRequest->language->name . '**',
                    'sourceTitle' =>
                        '**' . $this->translationRequest->source->title . '**',
                ]
            );
        } else {
            $subject = __('Translation Approved');

            $body = __(
                ':userName has approved the :languageName translation for :sourceTitle. :numReviewsRemaining.',
                [
                    'userName' => '**' . $this->reviewer->name . '**',
                    'languageName' =>
                        '**' . $this->translationRequest->language->name . '**',
                    'sourceTitle' =>
                        '**' . $this->translationRequest->source->title . '**',
                    'numReviewsRemaining' => trans_choice(
                        '[1] :count review remaining|[*] :count reviews remaining',
                        $this->translationRequest->num_approvals_remaining
                    ),
                ]
            );
        }

        return (new MailMessage())
            ->subject($subject)
            ->line($body)
            ->action(__('View translation'), $route);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray(User $notifiable)
    {
        return [
            'translation_request_id' => $this->translationRequest->id,
            'reviewer_id' => $this->reviewer->id,
        ];
    }
}
