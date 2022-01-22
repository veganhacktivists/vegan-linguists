<?php

namespace App\Http\Livewire;

use App\Models\Language;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RequestTranslationPage extends Component
{
    public bool $shouldDisplaySubmissionModal = false;
    public string $title = '';
    public string $content = '';
    public string $plainText = '';
    public ?int $sourceLanguageId = null;
    public array $targetLanguages = [];
    public string $numReviewers = '0';
    public Collection $languages;

    public function mount()
    {
        $this->languages = Language::withCount('translators')->get();
    }

    public function render()
    {
        return view('livewire.request-translation-page')->layout('layouts.app', [
            'containContent' => true,
        ]);
    }

    public function requestTranslation()
    {
        $this->validate();

        $this->targetLanguages = array_unique(
            array_diff(
                $this->targetLanguages,
                [$this->sourceLanguageId]
            )
        );

        return DB::transaction(function () {
            $source = Auth::user()->sources()->create([
                'language_id' => $this->sourceLanguageId,
                'title' => $this->title,
                'content' => $this->content,
                'plain_text' => $this->plainText,
            ]);

            $source->translationRequests()->createMany(
                array_map(function ($targetLanguageId) {
                    return [
                        'language_id' => $targetLanguageId,
                        'content' => $this->content,
                        'plain_text' => $this->plainText,
                        'num_approvals_required' => $this->numReviewers,
                    ];
                }, $this->targetLanguages)
            );

            session()->flash('flash.banner', __('Success! You will be notified when your content gets translated'));

            return redirect()->route('home');
        });
    }

    protected function rules()
    {
        return [
            'title' => ['required', 'string'],
            'content' => ['required', 'string'],
            'plainText' => ['required', 'string'],
            'sourceLanguageId' => ['required', 'exists:languages,id'],
            'numReviewers' => ['required', 'integer', 'min:0', 'max:3'],
            'targetLanguages' => [
                'required',
                'array',
                'exists:languages,id',
                function ($attribute, $targetLanguages, $fail) {
                    if (in_array($this->sourceLanguageId, $targetLanguages) && count($targetLanguages) === 1) {
                        $fail(__('Your target language must differ from your source language.'));
                    }
                }
            ],
        ];
    }

    protected function messages()
    {
        return [
            'numReviewers.*' => __('Please choose a number of reviewers from 0 to 3.'),
        ];
    }
}
