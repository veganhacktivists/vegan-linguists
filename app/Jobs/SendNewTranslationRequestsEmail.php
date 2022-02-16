<?php

namespace App\Jobs;

use App\Models\TranslationRequest;
use App\Models\User;
use App\Notifications\NewTranslationRequestsNotification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendNewTranslationRequestsEmail implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('Sending new translation requests email');
        $unclaimedTranslationRequests = TranslationRequest::query()
            ->unclaimed()
            ->with('source', 'reviewers')
            ->whereCreatedAfter(
                Carbon::now()->subtract('week', 1)
            )
            ->get();

        $reviewableTranslationRequests = TranslationRequest::query()
            ->needsReviewers()
            ->with('source', 'reviewers')
            ->get();

        Log::info('Requests', [
            'unclaimed' => $unclaimedTranslationRequests->count(),
            'reviewable' => $reviewableTranslationRequests->count()
        ]);

        User::whereSpeaksMultipleLanguages()
            ->with('languages:id')
            ->lazy()
            ->each(function (User $user) use ($unclaimedTranslationRequests, $reviewableTranslationRequests) {
                $languageIds = $user->languages->pluck('id');

                $numUnclaimedTranslationRequests = $unclaimedTranslationRequests
                    ->filter(function (TranslationRequest $translationRequest) use ($user, $languageIds) {
                        return $translationRequest->source->author_id !== $user->id
                            && !$translationRequest->reviewers->contains($user)
                            && $languageIds->contains($translationRequest->source->language_id)
                            && $languageIds->contains($translationRequest->language_id);
                    })
                    ->count();

                $numReviewableTranslationRequests = $reviewableTranslationRequests
                    ->filter(function (TranslationRequest $translationRequest) use ($user, $languageIds) {
                        return $translationRequest->source->author_id !== $user->id
                            && !$translationRequest->reviewers->contains($user)
                            && $translationRequest->translator_id !== $user->id
                            && $languageIds->contains($translationRequest->source->language_id)
                            && $languageIds->contains($translationRequest->language_id);
                    })
                    ->count();

                if ($numUnclaimedTranslationRequests + $numReviewableTranslationRequests === 0) return;

                Log::info('Notifying user', [
                    'user_id' => $user->id,
                    'unclaimed' => $numUnclaimedTranslationRequests,
                    'reviewable' => $numReviewableTranslationRequests,
                ]);

                $user->notify(
                    new NewTranslationRequestsNotification(
                        $numUnclaimedTranslationRequests,
                        $numReviewableTranslationRequests,
                    )
                );
            });

        Log::info('New translation email job completed');
    }
}
