<?php

use App\Models\User;
use App\Actions\Newsletter\UnsubscribeUser;
use App\Exceptions\Newsletter\NewsletterException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use MailchimpMarketing\Api\ListsApi;
use MailchimpMarketing\ApiClient;
use MailchimpMarketing\ApiException;

uses(RefreshDatabase::class);

dataset('newsletter_subscribed_users', [
    fn () => User::factory()->create(['is_subscribed_to_newsletter' => true]),
]);

it('unsubscribes a user from the newsletter', function (User $user) {
    expect($user->is_subscribed_to_newsletter)->toBeTrue();

    $mailchimp = mock(ApiClient::class)->makePartial();
    $mailchimp->lists = mock(ListsApi::class);
    $mailchimp->lists->shouldReceive([
        'updateListMemberTags' => '',
    ])->once();

    Log::shouldReceive('error')->never();

    $subscribeUser = app(UnsubscribeUser::class);
    $subscribeUser($user, $mailchimp);

    expect($user->is_subscribed_to_newsletter)->toBeFalse();
})->with('newsletter_subscribed_users');

it('does not unsubscribe the user when the API client throws an exception', function (User $user) {
    expect($user->is_subscribed_to_newsletter)->toBeTrue();

    $mailchimp = mock(ApiClient::class)->makePartial();
    $mailchimp->lists = mock(ListsApi::class);
    $mailchimp->lists->shouldReceive('updateListMemberTags')
        ->once()
        ->andThrow(new ApiException);

    Log::shouldReceive('error')->once();

    $subscribeUser = app(UnsubscribeUser::class);
    $subscribeUser($user, $mailchimp);

    expect($user->is_subscribed_to_newsletter)->toBeTrue();
})->throws(NewsletterException::class)
    ->with('newsletter_subscribed_users');
