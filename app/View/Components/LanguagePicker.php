<?php

namespace App\View\Components;

use App\Models\Language;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class LanguagePicker extends Component
{
    public Collection $languages;
    public string $defaultLanguages;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Collection $languages, array $defaultLanguages = [])
    {
        $this->languages = $languages->isNotEmpty() ? $languages : Language::all();
        $this->defaultLanguages = json_encode(
            array_map(
                'intval',
                old(
                    'languages',
                    Language::whereIn('code', $defaultLanguages)->get()->pluck('id')->toArray(),
                )
            )
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
