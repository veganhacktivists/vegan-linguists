<?php

// Loaded in composer.json

use App\Models\User;
use Illuminate\Support\Facades\Request;

function user(User|null $user)
{
    if (!$user) return User::deletedUser();

    return $user;
}

/**
 * Translation request routing
 */
function unclaimedTranslationRequestsRoute()
{
    return route('translation-requests.index', Request::except('filter'));
}

function claimedTranslationRequestsRoute()
{
    return route('translation-requests.index', ['filter' => 'mine'] + Request::all());
}

function reviewableTranslationRequestsRoute()
{
    return route('translation-requests.index', ['filter' => 'reviewable'] + Request::all());
}

function underReviewTranslationRequestsRoute()
{
    return route('translation-requests.index', ['filter' => 'under-review'] + Request::all());
}

function completedTranslationRequestsRoute()
{
    return route('translation-requests.index', ['filter' => 'completed'] + Request::all());
}
