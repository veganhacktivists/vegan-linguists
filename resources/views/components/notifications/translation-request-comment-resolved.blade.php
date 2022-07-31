@php
$route = $isNotifyingAuthor ? route('translation', [$source->id, $translationRequest->language->id]) : route('translate', [$translationRequest->id, $source->slug, '#discussion']);

$title = htmlentities($source->title);

$translationRequestTitle = <<<HTML
    <a class="font-bold text-brand-clay-700 hover:underline" href="$route">$title</a>
HTML;

@endphp

<x-notifications.base-notification :date="$date" class="flex-col">
  <div class="flex w-full gap-3">
    <x-user-photo class="mt-1 h-6 w-6" :user="$translator" />

    <div>
      {!! __(':userName resolved a comment on :translationRequestTitle:', [
          'userName' => htmlentities($translator->name),
          'translationRequestTitle' => $translationRequestTitle,
      ]) !!}

      <div class="mt-1">
        {{ $comment->truncatedText }}
      </div>
    </div>
  </div>
</x-notifications.base-notification>
