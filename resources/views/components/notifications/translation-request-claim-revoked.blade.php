@php
    $sourceRoute = route('translate', [$translationRequest->id, $translationRequest->source->slug]);
    $sourceTitle = htmlentities($translationRequest->source->title);

    $translationRequestTitle = <<<HTML
        <a class="font-bold text-indigo-700 hover:underline" href="$sourceRoute">$sourceTitle</a>
    HTML;

@endphp

<x-notifications.base-notification
    :user="$author"
    :date="$date"
    :description="__(':userName has revoked your claim on the :languageName translation for :translationRequestTitle.', [
        'userName' => $author->name,
        'languageName' => '<strong>'.$translationRequest->language->name.'</strong>',
        'translationRequestTitle' => $translationRequestTitle,
    ])" />
