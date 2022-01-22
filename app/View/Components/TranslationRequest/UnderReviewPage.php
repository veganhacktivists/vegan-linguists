<?php

namespace App\View\Components\TranslationRequest;

use App\Models\TranslationRequest;
use Illuminate\View\Component;

class UnderReviewPage extends Component
{
    public function __construct(public TranslationRequest $translationRequest)
    {
    }

    public function render()
    {
        return view('components.translation-request.under-review-page');
    }
}
