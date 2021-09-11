@php
    $route = $isNotifyingAuthor
        ? route('translation', [$translationRequest->source->id, $translationRequest->language->id])
        : route('translate', [$translationRequest->id, $translationRequest->source->slug]);

    $title = htmlentities($translationRequest->source->title);

    $translationRequestTitle = <<<HTML
        <a class="font-bold text-indigo-700 hover:underline" href="$route">$title</a>
    HTML;

@endphp

<x-notifications.base-notification :date="$date" class="flex-col">
    <div class="flex gap-3 w-full">
        <x-user-photo class="h-6 w-6" :user="$comment->author" />

        <div>
            {!! __(':userName left a comment on :translationRequestTitle:', [
                'userName' => htmlentities($comment->author->name),
                'translationRequestTitle' => $translationRequestTitle,
            ]) !!}

            <div class="mt-1">
                @if (strlen($comment->plain_text) >= 100)
                    {{ substr($comment->plain_text, 0, 97) }}…
                @else
                    {{ $comment->plain_text }}
                @endif
            </div>
        </div>
    </div>
</x-notifications.base-notification>
