<?php

namespace App\Actions\Newsletter;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Spatie\WebhookClient\WebhookConfig;

class ValidateMailchimpWebhook implements SignatureValidator
{
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        Log::info(
            'Validating Mailchimp webhook',
            Arr::except($request->post(), ['data.email', 'data.merges.EMAIL'])
        );

        // Unfortunately, marketing emails do not contain a signature,
        // so we just verify that the audience ID matches
        return $request->post('data.list_id') === config('mailchimp.audience.id');
    }
}
