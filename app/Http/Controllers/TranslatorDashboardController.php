<?php

namespace App\Http\Controllers;

use App\Models\TranslationRequest;
use Illuminate\Support\Facades\Auth;

class TranslatorDashboardController extends Controller
{
    const MAX_TRANSLATION_REQUESTS_DISPLAYED = 5;

    public function __invoke()
    {
        $languageIds = Auth::user()->languages()->select('languages.id')->pluck('language.id');

        $translationRequests = $this->getUnclaimedTranslationRequestsQuery($languageIds)
            ->union($this->getInProgressTranslationsQuery())
            ->union($this->getReviewableTranslationRequestsQuery($languageIds))
            ->union($this->getTranslationRequestsClaimedForReviewQuery())
            ->with('source', 'source.language', 'source.author', 'reviewers')
            ->get()
            ->groupBy(function (TranslationRequest $translationRequest) {
                if ($translationRequest->isUnclaimed())             return 'unclaimed';
                if ($translationRequest->isClaimedBy(Auth::user())) return 'in_progress';
                if ($translationRequest->hasReviewer(Auth::user())) return 'claimed_for_review';
                return 'reviewable';
            });

        return view('translator-dashboard', [
            'unclaimedTranslationRequests' => $translationRequests['unclaimed'] ?? collect(),
            'inProgressTranslations' => $translationRequests['in_progress'] ?? collect(),
            'translationRequestsClaimedForReview' => $translationRequests['claimed_for_review'] ?? collect(),
            'reviewableTranslationRequests' => $translationRequests['reviewable'] ?? collect(),
        ]);
    }

    private function getUnclaimedTranslationRequestsQuery(iterable $languageIds)
    {
        return TranslationRequest::query()
            ->unclaimed()
            ->excludingSourceAuthor(Auth::user())
            ->limit(self::MAX_TRANSLATION_REQUESTS_DISPLAYED)
            ->whereSourceLanguageId($languageIds)
            ->whereLanguageId($languageIds)
            ->orderBy('created_at', 'desc');
    }

    private function getReviewableTranslationRequestsQuery(iterable $languageIds)
    {
        return TranslationRequest::query()
            ->needsReviewers()
            ->excludingSourceAuthor(Auth::user())
            ->excludingTranslator(Auth::user())
            ->excludingReviewer(Auth::user())
            ->whereSourceLanguageId($languageIds)
            ->whereLanguageId($languageIds)
            ->orderBy('created_at', 'desc')
            ->limit(self::MAX_TRANSLATION_REQUESTS_DISPLAYED);
    }

    private function getInProgressTranslationsQuery()
    {
        return Auth::user()
            ->translationRequests()
            ->incomplete()
            ->limit(self::MAX_TRANSLATION_REQUESTS_DISPLAYED)
            ->orderByStatus()
            ->orderBy('translation_requests.created_at', 'desc');
    }

    private function getTranslationRequestsClaimedForReviewQuery()
    {
        return Auth::user()
            ->translationRequestsClaimedForReview()
            ->underReview()
            ->select('translation_requests.*')
            ->limit(self::MAX_TRANSLATION_REQUESTS_DISPLAYED)
            ->orderBy('translation_requests.created_at', 'desc');
    }
}
