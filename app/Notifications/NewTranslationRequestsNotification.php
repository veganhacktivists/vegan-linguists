<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewTranslationRequestsNotification extends BaseNotification implements ShouldQueue
{
    use Queueable;

    public static function getTitle()
    {
        return __('New Translation Requests Available');
    }

    public static function getDescription()
    {
        return __("Get a weekly notification about new requests for translations and reviews");
    }

    public static function isDatabaseEnabled()
    {
        return false;
    }

    public function __construct(
        private int $numUnclaimedTranslationRequests,
        private int $numReviewableTranslationRequests
    ) {
    }

    public function toMail(User $notifiable)
    {
        return (new MailMessage)
            ->subject(__('Translation Requests Available'))
            ->line(__("This is your weekly update on what you can help out with as a translator on Vegan Linguists, based on the languages you speak."))
            ->when($this->numUnclaimedTranslationRequests > 0, function (MailMessage $mailMessage) {
                $mailMessage->line(
                    '* ' . trans_choice(
                        '[1] There is 1 new translation needed.|[*] There are :count new translations needed.',
                        $this->numUnclaimedTranslationRequests,
                    )
                );
            })
            ->when($this->numReviewableTranslationRequests > 0, function (MailMessage $mailMessage) {
                $mailMessage->line(
                    '* ' . trans_choice(
                        '[1] There is 1 translation in need of review.|[*] There are :count translations in need of review.',
                        $this->numReviewableTranslationRequests,
                    )
                );
            })
            ->line(__("Thank you so much for your help in making vegan content more accessible across the globe."))
            ->action(
                __('View translation requests'),
                route('home')
            );
    }

    public function toArray(User $notifiable)
    {
        return [];
    }
}
