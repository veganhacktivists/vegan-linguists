<?php

namespace App\Actions\Newsletter;

use App\Exceptions\Newsletter\NewsletterException;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use MailchimpMarketing\ApiClient;
use MailchimpMarketing\ApiException;

class UnsubscribeUser
{
    public function __invoke(User $user, ApiClient $apiClient = null)
    {
        $apiClient = $apiClient ?? new ApiClient();

        $apiClient->setConfig([
            'apiKey' => config('mailchimp.api.key'),
            'server' => config('mailchimp.api.server_prefix'),
        ]);

        try {
            $apiClient->lists->updateListMemberTags(
                config('mailchimp.audience.id'),
                md5(strtolower($user->email)),
                [
                    'tags' => [
                        [
                            'name' => config('mailchimp.audience.tag'),
                            'status' => 'inactive',
                        ],
                    ],
                ]
            );

            $user->update(['is_subscribed_to_newsletter' => false]);
        } catch (ApiException $e) {
            $errorMessage = $e->getMessage();

            Log::error("Mailchimp API error (unsubscribe): $errorMessage", [
                'user_id' => $user->id,
            ]);

            throw new NewsletterException($errorMessage);
        }
    }
}
