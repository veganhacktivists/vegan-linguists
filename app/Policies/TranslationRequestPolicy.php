<?php

namespace App\Policies;

use App\Models\TranslationRequest;
use App\Models\TranslationRequestStatus;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

define('MAX_CLAIMED_TRANSLATION_REQUESTS', 3);

class TranslationRequestPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, TranslationRequest $translationRequest)
    {
        if ($translationRequest->isClaimed()) {
            return $translationRequest->isClaimedBy($user);
        }

        return $translationRequest->status === TranslationRequestStatus::UNCLAIMED
            && $translationRequest->source->author_id !== $user->id
            && $user->speaksLanguage($translationRequest->language_id);
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, TranslationRequest $translationRequest)
    {
        return $translationRequest->source->author_id === $user->id;
    }

    public function delete(User $user, TranslationRequest $translationRequest)
    {
        return $translationRequest->source->author_id === $user->id;
    }

    public function claim(User $user, TranslationRequest $translationRequest)
    {
        return $this->view($user, $translationRequest)
            && $translationRequest->translator_id === null
            && $user->translationRequests()->count() < MAX_CLAIMED_TRANSLATION_REQUESTS;
    }
}
