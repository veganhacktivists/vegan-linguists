@php
$route = $isNotifyingAuthor ? route('translation', [$source->id, $translationRequest->language->id]) : route('translate', [$translationRequest->id, $source->slug]);

$title = htmlentities($source->title);

$translationRequestTitle = <<<HTML
    <a class="font-bold text-brand-clay-700 hover:underline" href="$route">$title</a>
HTML;

@endphp

<x-notifications.base-notification :date="$date" class="flex-col">
  <div class="flex w-full gap-3">
    <x-user-photo class="mt-1 h-6 w-6" :user="$reviewer" />

    <div>
      {!! __(':userName started reviewing the :languageName translation for :translationRequestTitle:', [
          'userName' => htmlentities($reviewer->name),
          'languageName' => '<strong>' . $translationRequest->language->name . '</strong>',
          'translationRequestTitle' => $translationRequestTitle,
      ]) !!}
    </div>
  </div>
</x-notifications.base-notification>
