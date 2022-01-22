<?php

namespace App\Http\Livewire;

use App\Models\TranslationRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ReviewSectionPage extends Component
{
    public Collection $translationsInNeedOfReview;
    public Collection $translationUnderReview;
    public Collection $reviewedTranslationRequests;

    public function mount()
    {
        $translator = Auth::User();

        $this->translationsInNeedOfReview = TranslationRequest::excludingTranslator($translator)
            ->excludingSourceAuthor($translator)
            ->needsReviewers()
            ->get();
        $this->translationUnderReview = $translator->underReviewTranslationRequests;
        $this->reviewedTranslationRequests = $translator->reviewedTranslationRequests()->complete;
    }

    public function render()
    {
        return view('livewire.review-section-page');
    }
}
