<?php

namespace App\Policies;

use App\Models\TranslationRequest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TranslationRequestPolicy
{
    const MAX_CLAIMED_TRANSLATION_REQUESTS = 3;

    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, TranslationRequest $translationRequest)
    {
        if (
            $translationRequest->isClaimedBy($user) ||
            $translationRequest->hasReviewer($user)
        ) {
            return true;
        }

        if ($translationRequest->source->isOwnedBy($user)) {
            return false;
        }

        if (
            $translationRequest->isUnclaimed() ||
            $translationRequest->doesNeedReviewers()
        ) {
            return $user->speaksLanguages([
                $translationRequest->language_id,
                $translationRequest->source->language_id,
            ]);
        }

        return false;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, TranslationRequest $translationRequest)
    {
        return $translationRequest->source->isOwnedBy($user);
    }

    public function delete(User $user, TranslationRequest $translationRequest)
    {
        return $translationRequest->source->isOwnedBy($user);
    }

    public function claim(User $user, TranslationRequest $translationRequest)
    {
        return $translationRequest->isUnclaimed() &&
            $translationRequest->translator_id === null &&
            $user->hasVerifiedEmail() &&
            $user->speaksLanguages([
                $translationRequest->language_id,
                $translationRequest->source->language_id,
            ]) &&
            $user->num_claimed_translation_requests <
                self::MAX_CLAIMED_TRANSLATION_REQUESTS;
    }

    public function claimForReview(
        User $user,
        TranslationRequest $translationRequest
    ) {
        return $translationRequest->isUnderReview() &&
            $user->hasVerifiedEmail() &&
            !$translationRequest->isClaimedBy($user) &&
            $translationRequest->doesNeedReviewers() &&
            !$translationRequest->hasReviewer($user) &&
            !$translationRequest->source->isOwnedBy($user) &&
            $user->speaksLanguages([
                $translationRequest->language_id,
                $translationRequest->source->language_id,
            ]);
    }

    public function review(User $user, TranslationRequest $translationRequest)
    {
        return $translationRequest->hasReviewer($user);
    }

    public function approve(User $user, TranslationRequest $translationRequest)
    {
        return !$translationRequest->hasBeenApprovedBy($user);
    }

    public function comment(User $user, TranslationRequest $translationRequest)
    {
        return $translationRequest->isClaimedBy($user) ||
            $translationRequest->hasReviewer($user) ||
            $translationRequest->source->isOwnedBy($user);
    }

    public function resolveComment(
        User $user,
        TranslationRequest $translationRequest
    ) {
        return $translationRequest->isClaimedBy($user);
    }
}
