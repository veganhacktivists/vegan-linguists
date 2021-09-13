@php
    $sourceRoute = route('translation', [$source->id, $translationRequest->language->id]);
    $sourceTitle = htmlentities($source->title);

    $translationRequestTitle = <<<HTML
        <a class="font-bold text-indigo-700 hover:underline" href="$sourceRoute">$sourceTitle</a>
    HTML;

@endphp

<x-notifications.base-notification
    :user="$translator"
    :date="$date"
    :description="__('Submitted the :languageName translation for :translationRequestTitle.', [
        'languageName' => '<strong>'.$translationRequest->language->name.'</strong>',
        'translationRequestTitle' => $translationRequestTitle,
    ])" />
<div>
