<?php

namespace App\Jobs;

use App\Actions\Newsletter\SubscribeUser;
use App\Actions\Newsletter\UnsubscribeUser;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use MailchimpMarketing\ApiClient;
use MailchimpMarketing\ApiException;
use Spatie\WebhookClient\Models\WebhookCall;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;

class ProcessMailchimpWebhook extends ProcessWebhookJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $payload = $this->webhookCall->payload;

        Log::info(
            'Handling Mailchimp webhook',
            Arr::except($payload, ['data.email', 'data.merges.EMAIL'])
        );

        if ($payload['type'] === 'unsubscribe') {
            $this->handleUnsubscribe(Arr::get($payload, 'data.email', ''));
        } elseif ($payload['type'] === 'subscribe') {
            $this->handleSubscribe(Arr::get($payload, 'data.email', ''));
        }
    }

    private function handleUnsubscribe(string $email)
    {
        $user = User::whereEmail($email)->first();
        if (!$user) return;

        app(UnsubscribeUser::class)($user);
    }

    private function handleSubscribe(string $email)
    {
        $user = User::whereEmail($email)->first();
        if (!$user) return;

        $client = new ApiClient();
        $client->setConfig([
            'apiKey' => config('mailchimp.api.key'),
            'server' => config('mailchimp.api.server_prefix'),
        ]);

        try {
            $response = $client->lists->getListMemberTags(
                config('mailchimp.audience.id'),
                md5(strtolower($user->email))
            );

            $tag = Arr::first($response->tags, function ($tag) {
                return $tag->name === config('mailchimp.audience.tag');
            });

            if ($tag) {
                $user->update(['is_subscribed_to_newsletter' => true]);
            }
        } catch (ApiException $e) {
            $errorMessage = $e->getMessage();

            Log::error(
                "Mailchimp API error (subscribe webhook): $errorMessage",
                ['user_id' => $user->id]
            );
        }
    }
}
