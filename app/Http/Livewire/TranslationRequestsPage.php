<?php

namespace App\Http\Livewire;

use App\Models\TranslationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TranslationRequestsPage extends Component
{
    public string $sourceLanguageCode;
    public string $targetLanguageCode;
    public Collection $languages;

    private string $filter;

    public function render(Request $request)
    {
        $this->filter = $request->query('filter', '') ?? '';
        $this->sourceLanguageCode = $request->query('source', '') ?? '';
        $this->targetLanguageCode = $request->query('target', '') ?? '';
        $this->languages = Auth::user()->languages;

        $this->translationRequests = $this->getTranslationRequests($this->sourceLanguageCode, $this->targetLanguageCode);

        return view('livewire.translation-requests-page');
    }

    public function isMinePage()
    {
        return $this->filter === 'mine';
    }

    public function isAvailablePage()
    {
        return !($this->isMinePage()
            || $this->isReviewablePage()
            || $this->isUnderReviewPage()
            || $this->isCompletedPage()
        );
    }

    public function isReviewablePage()
    {
        return $this->filter === 'reviewable';
    }

    public function isUnderReviewPage()
    {
        return $this->filter === 'under-review';
    }

    public function isCompletedPage()
    {
        return $this->filter === 'completed';
    }

    private function getTranslationRequests()
    {
        $sourceLanguage = $this->languages->where('code', $this->sourceLanguageCode)->first();
        $targetLanguage = $this->languages->where('code', $this->targetLanguageCode)->first();

        if ($this->isMinePage()) {
            $translationRequests = Auth::user()->translationRequests()->incomplete();
        } elseif ($this->isReviewablePage()) {
            $translationRequests = TranslationRequest::needsReviewers()
                ->excludingSourceAuthor(Auth::user())
                ->excludingTranslator(Auth::user())
                ->excludingReviewer(Auth::user());
        } elseif ($this->isUnderReviewPage()) {
            $translationRequests = Auth::user()->translationRequestsClaimedForReview()->underReview();
        } elseif ($this->isCompletedPage()) {
            $translationRequests = Auth::user()->completedTranslationRequests()->union(
                Auth::user()->translationRequestsClaimedForReview()
                    ->complete()
                    ->whereSourceLanguageId(
                        $sourceLanguage ? $sourceLanguage->id : $this->languages->pluck('id')
                    )
                    ->whereLanguageId(
                        $targetLanguage ? $targetLanguage->id : $this->languages->pluck('id')
                    )
                    ->select('translation_requests.*')
            );
        } else {
            $translationRequests = TranslationRequest::unclaimed()->excludingSourceAuthor(Auth::user());
        }

        return $translationRequests
            ->with('source', 'source.author', 'source.language', 'reviewers')
            ->whereSourceLanguageId(
                $sourceLanguage ? $sourceLanguage->id : $this->languages->pluck('id')
            )
            ->whereLanguageId(
                $targetLanguage ? $targetLanguage->id : $this->languages->pluck('id')
            )
            ->get();
    }
}
