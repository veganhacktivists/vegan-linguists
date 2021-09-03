<?php

namespace App\View\Components\Dashboard;

use App\Models\Source;
use Illuminate\View\Component;

class SourceRow extends Component
{
    public int $numCompleteTranslationRequests;
    public int $totalTranslationRequests;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public Source $source)
    {
        $this->numCompleteTranslationRequests = $source->num_complete_translation_requests;
        $this->totalTranslationRequests = $source->translationRequests->count();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.source-row');
    }
}
