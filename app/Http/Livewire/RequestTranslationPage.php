<?php

namespace App\Http\Livewire;

use App\Models\Language;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RequestTranslationPage extends Component
{
    public bool $shouldDisplayLanguagePicker = false;
    public string $title = '';
    public string $content = '';
    public string $plainText = '';
    public ?int $sourceLanguageId = null;
    public array $targetLanguages = [];
    public Collection $languages;

    protected array $rules = [
        'title' => ['required', 'string'],
        'content' => ['required', 'string'],
        'plainText' => ['required', 'string'],
        'sourceLanguageId' => ['required', 'exists:languages,id'],
        'targetLanguages' => ['required', 'array', 'exists:languages,id'],
    ];

    public function mount()
    {
        $this->languages = Language::all();

        $userLanguages = Auth::user()->languages;
        if (count($userLanguages) > 0) {
            $this->sourceLanguageId = $userLanguages->first()->id;
        }
    }

    public function render()
    {
        return view('livewire.request-translation-page');
    }

    public function requestTranslation()
    {
        $this->validate();

        return DB::transaction(function() {
            $source = Auth::user()->sources()->create([
                'language_id' => $this->sourceLanguageId,
                'title' => $this->title,
                'content' => $this->content,
                'plain_text' => $this->plainText,
            ]);

            $source->translationRequests()->createMany(
                array_map(function($targetLanguageId) {
                    return [
                        'language_id' => $targetLanguageId,
                        'content' => '',
                        'plain_text' => '',
                    ];
                }, $this->targetLanguages)
            );

            session()->flash('flash.banner', __('Success! You will be notified when your content gets translated'));

            return redirect()->route('dashboard');
        });
    }
}
