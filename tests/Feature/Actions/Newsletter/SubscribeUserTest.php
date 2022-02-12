<?php

use App\Models\User;
use App\Actions\Newsletter\SubscribeUser;
use App\Exceptions\Newsletter\NewsletterException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use MailchimpMarketing\Api\ListsApi;
use MailchimpMarketing\ApiClient;
use MailchimpMarketing\ApiException;

define('SUBSCRIBE_SUCCESS_RESPONSE', [
    'id' => 'string',
    'email_address' => 'string',
    'unique_email_id' => 'string',
    'contact_id' => 'string',
    'full_name' => 'string',
    'web_id' => 0,
    'email_type' => 'string',
    'status' => 'subscribed',
    'unsubscribe_reason' => 'string',
    'consents_to_one_to_one_messaging' => true,
    'merge_fields' => [
        'property1' => null,
        'property2' => null,
    ],
    'interests' => [
        'property1' => true,
        'property2' => true,
    ],
    'stats' => [
        'avg_open_rate' => 0,
        'avg_click_rate' => 0,
        'ecommerce_data' => [
            'total_revenue' => 0,
            'number_of_orders' => 0,
            'currency_code' => 'USD',
        ],
    ],
    'ip_signup' => 'string',
    'timestamp_signup' => '2019-08-24T14:15:22Z',
    'ip_opt' => 'string',
    'timestamp_opt' => '2019-08-24T14:15:22Z',
    'member_rating' => 0,
    'last_changed' => '2019-08-24T14:15:22Z',
    'language' => 'string',
    'vip' => true,
    'email_client' => 'string',
    'location' => [
        'latitude' => 0,
        'longitude' => 0,
        'gmtoff' => 0,
        'dstoff' => 0,
        'country_code' => 'string',
        'timezone' => 'string',
    ],
    'marketing_permissions' => [
        [
            'marketing_permission_id' => 'string',
            'text' => 'string',
            'enabled' => true,
        ],
    ],
    'last_note' => [
        'note_id' => 0,
        'created_at' => '2019-08-24T14:15:22Z',
        'created_by' => 'string',
        'note' => 'string',
    ],
    'source' => 'string',
    'tags_count' => 0,
    'tags' => [
        [
            'id' => 0,
            'name' => 'string',
        ],
    ],
    'list_id' => 'string',
    '_links' => [
        [
            'rel' => 'string',
            'href' => 'string',
            'method' => 'GET',
            'targetSchema' => 'string',
            'schema' => 'string',
        ],
    ],
]);

uses(RefreshDatabase::class);

dataset('newsletter_unsubscribed_users', [
    fn () => User::factory()->create(),
]);

it('subscribes a user to the newsletter', function (User $user) {
    expect($user->is_subscribed_to_newsletter)->toBeFalse();

    $mailchimp = mock(ApiClient::class)->makePartial();
    $mailchimp->lists = mock(ListsApi::class);
    $mailchimp->lists->shouldReceive([
        'setListMember' => SUBSCRIBE_SUCCESS_RESPONSE,
        'updateListMemberTags' => '',
    ])->once();

    Log::shouldReceive('error')->never();

    $subscribeUser = app(SubscribeUser::class);
    $subscribeUser($user, $mailchimp);

    expect($user->is_subscribed_to_newsletter)->toBeTrue();
})->with('newsletter_unsubscribed_users');

it('does not subscribe the user when the API client throws an exception on the subscribe endpoint', function (User $user) {
    expect($user->is_subscribed_to_newsletter)->toBeFalse();

    $mailchimp = mock(ApiClient::class)->makePartial();
    $mailchimp->lists = mock(ListsApi::class);
    $mailchimp->lists->shouldReceive('setListMember')
        ->once()
        ->andThrow(new ApiException);
    $mailchimp->lists->shouldReceive('updateListMemberTags')->never();

    Log::shouldReceive('error')->once();

    $subscribeUser = app(SubscribeUser::class);
    $subscribeUser($user, $mailchimp);

    expect($user->is_subscribed_to_newsletter)->toBeFalse();
})->throws(NewsletterException::class)
    ->with('newsletter_unsubscribed_users');


it('subscribes the user when the API client throws an exception on the tag endpoint, but logs the error', function (User $user) {
    expect($user->is_subscribed_to_newsletter)->toBeFalse();

    $mailchimp = mock(ApiClient::class)->makePartial();
    $mailchimp->lists = mock(ListsApi::class);
    $mailchimp->lists->shouldReceive('setListMember')
        ->once()
        ->andReturn(SUBSCRIBE_SUCCESS_RESPONSE);
    $mailchimp->lists->shouldReceive('updateListMemberTags')
        ->once()
        ->andThrow(new ApiException);

    Log::shouldReceive('error')->once();

    $subscribeUser = app(SubscribeUser::class);
    $subscribeUser($user, $mailchimp);

    expect($user->is_subscribed_to_newsletter)->toBeTrue();
})->with('newsletter_unsubscribed_users');
