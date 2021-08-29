<?php

namespace App\View\Components\Dashboard;

use App\Models\Source;
use App\Models\TranslationRequest;
use App\Models\TranslationRequestStatus;
use Illuminate\View\Component;

class TranslationRequestRow extends Component
{
    public string $statusClass;
    public string $statusText;
    public bool $isComplete;
    public bool $isClaimed;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public TranslationRequest $translationRequest,
        public Source $source,
    )
    {
        $this->isComplete = false;
        $this->isClaimed = false;

        if ($translationRequest->isComplete()) {
            $this->statusClass = 'bg-green-200';
            $this->statusText = __('Complete');
            $this->isComplete = true;
        } else if ($translationRequest->isClaimed()) {
            $this->statusClass = 'bg-yellow-200';
            $this->statusText = __('Claimed');
            $this->isClaimed = true;
        } else {
            $this->statusClass = 'bg-gray-200';
            $this->statusText = __('Unclaimed');
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.translation-request-row');
    }
}
