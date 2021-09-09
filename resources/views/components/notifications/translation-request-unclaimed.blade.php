@php
    $sourceRoute = route('translation', [$translationRequest->source->id, $translationRequest->language->id]);
    $sourceTitle = htmlentities($translationRequest->source->title);

    $translationRequestTitle = <<<HTML
        <a class="font-bold text-indigo-700 hover:underline" href="$sourceRoute">$sourceTitle</a>
    HTML;

@endphp

<x-notifications.base-notification
    :user="$translator"
    :date="$date"
    :description="__(':userName has unclaimed the :languageName translation for :translationRequestTitle.', [
        'userName' => $translator->name,
        'languageName' => '<strong>'.$translationRequest->language->name.'</strong>',
        'translationRequestTitle' => $translationRequestTitle,
    ])" />
