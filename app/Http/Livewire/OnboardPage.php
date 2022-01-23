<?php

namespace App\Http\Livewire;

use App\Models\Language;
use App\Models\UserMode;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class OnboardPage extends Component
{
    public string $userMode = '';
    public array $languages = [];
    public array $targetLanguages = [];
    public Collection $defaultLanguages;

    public function render()
    {
        $this->defaultLanguages = Language::where('code', 'en')->get();
        return view('livewire.onboard-page')->layout('layouts.guest');
    }

    public function completeOnboarding()
    {
        $this->validate();

        $user = Auth::user();
        $user->languages()->attach($this->languages);

        if ($this->userMode === UserMode::AUTHOR) {
            $user->update(['user_mode' => UserMode::AUTHOR]);
            $user->default_target_languages = $this->targetLanguages;
        } else {
            $user->update(['user_mode' => UserMode::TRANSLATOR]);
        }

        return redirect()->route('home');
    }

    protected function rules()
    {
        return [
            'userMode' => 'required',
            'languages' => [
                'required',
                'array',
                Rule::when($this->isTranslator(), 'min:2'),
                'exists:languages,id'
            ],
            'targetLanguages' => [
                Rule::requiredIf($this->isAuthor()),
                'array',
                'exists:languages,id'
            ],
        ];
    }

    protected function messages()
    {
        $isTranslator = $this->isTranslator();

        return [
            'languages.required' => $isTranslator
                ? __('Please indicate which languages you can read and write fluently.')
                : __('Please indicate which languages your content is written in.'),
            'languages.min' => __('In order to translate content, you must be able to read and write in multiple languages.'),
            'targetLanguages.required' => __('Please indicate which languages you would like your content to be translated to.')
        ];
    }

    private function isTranslator()
    {
        return $this->userMode !== UserMode::AUTHOR;
    }

    private function isAuthor()
    {
        return $this->userMode !== UserMode::TRANSLATOR;
    }
}
