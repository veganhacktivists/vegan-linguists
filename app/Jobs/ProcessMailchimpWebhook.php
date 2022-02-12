<?php

namespace App\Jobs;

use App\Actions\Newsletter\UnsubscribeUser;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Spatie\WebhookClient\Models\WebhookCall;

class ProcessMailchimpWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private WebhookCall $webhookCall;

    public function handle()
    {
        $payload = $this->webhookCall->payload;

        Log::info(
            'Handling Mailchimp webhook',
            Arr::except($payload, ['data.email', 'data.merges.EMAIL'])
        );

        if ($payload['type'] === 'unsubscribe') {
            $this->handleUnsubscribe(Arr::get($payload, 'data.email', ''));
        }
    }

    private function handleUnsubscribe(string $email)
    {
        $user = User::whereEmail($email)->first();

        if ($user) {
            app(UnsubscribeUser::class)($user);
        }
    }
}
