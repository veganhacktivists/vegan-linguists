<?php

namespace App\View\Components;

use App\Models\Language;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class LanguagePicker extends Component
{
    public Collection $languages;
    public Collection $defaultLanguages;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        Collection $languages,
        Collection $defaultLanguages,
        public bool $shouldDisplayTranslatedLanguage = false,
    )
    {
        $this->languages = $languages->isNotEmpty() ? $languages : Language::all();
        $this->defaultLanguages = old(
            'languages',
            $defaultLanguages,
        );
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.language-picker');
    }
}
