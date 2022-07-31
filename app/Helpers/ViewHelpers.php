<?php

// Loaded in composer.json

use App\Models\User;
use Illuminate\Support\Facades\Request;

function user(User|null $user)
{
    if (!$user) {
        return User::deletedUser();
    }

    return $user;
}

/**
 * Translation request routing
 */
function unclaimedTranslationRequestsRoute()
{
    return route('translation-requests.index');
}

function claimedTranslationRequestsRoute()
{
    return route('translation-requests.index', ['filter' => 'mine']);
}

function reviewableTranslationRequestsRoute()
{
    return route('translation-requests.index', ['filter' => 'reviewable']);
}

function underReviewTranslationRequestsRoute()
{
    return route('translation-requests.index', ['filter' => 'under-review']);
}

function completedTranslationRequestsRoute()
{
    return route('translation-requests.index', ['filter' => 'completed']);
}
