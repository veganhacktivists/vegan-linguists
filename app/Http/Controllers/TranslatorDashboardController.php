<?php

namespace App\Http\Controllers;

use App\Models\TranslationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TranslatorDashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $filter = $request->query('filter', '') ?? '';
        $sourceLanguageCode = $request->query('source', '') ?? '';
        $targetLanguageCode = $request->query('target', '')?? '';

        $translationRequests = $this->getTranslationRequests($filter, $sourceLanguageCode, $targetLanguageCode);

        $languages = Auth::user()->languages;

        return view('translator-dashboard', [
            'filter' => $filter,
            'translationRequests' => $translationRequests,
            'languages' => $languages,
            'sourceLanguageCode' => $sourceLanguageCode,
            'targetLanguageCode' => $targetLanguageCode,
        ]);
    }

    private function getTranslationRequests(string $filter, string $sourceLanguageCode, string $targetLanguageCode)
    {
        $languages = Auth::user()->languages;

        if ($filter === 'unclaimed') {
            $translationRequests = $this->getUnclaimedTranslationRequests();
        } elseif ($filter === 'complete') {
            $translationRequests = $this->getCompletedTranslationRequests();
        } else {
            $translationRequests = $this->getClaimedTranslationRequests();
        }

        $sourceLanguage = $languages->where('code', $sourceLanguageCode)->first();
        $targetLanguage = $languages->where('code', $targetLanguageCode)->first();

        return $translationRequests
            ->with('source', 'source.author', 'source.language')
            ->whereSourceLanguageId(
                $sourceLanguage ? $sourceLanguage->id : $languages->pluck('id')
            )
            ->whereLanguageId(
                $targetLanguage ? $targetLanguage->id : $languages->pluck('id')
            )
            ->get();
    }

    private function getClaimedTranslationRequests()
    {
        return Auth::user()->claimedTranslationRequests();
    }

    private function getCompletedTranslationRequests()
    {
        return Auth::user()->completedTranslationRequests();
    }

    private function getUnclaimedTranslationRequests()
    {
        return TranslationRequest::query()
            ->unclaimed()
            ->excludingSourceAuthor(Auth::user())
            ->orderBy('created_at', 'desc');
    }
}
