@php
$sourceRoute = route('translate', [$translationRequest->id, $source->slug]);
$sourceTitle = htmlentities($source->title);

$translationRequestTitle = <<<HTML
    <a class="font-bold text-brand-clay-700 hover:underline" href="$sourceRoute">$sourceTitle</a>
HTML;

@endphp

<x-notifications.base-notification :user="$author"
                                   :date="$date"
                                   :description="__('Revoked your claim on the :languageName translation for :translationRequestTitle.', [
        'languageName' => '<strong>'.$translationRequest->language->name.'</strong>',
        'translationRequestTitle' => $translationRequestTitle,
    ])" />
