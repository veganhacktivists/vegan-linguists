<x-notifications.base-notification icon="o-exclamation" :date="$date">

    <div class="flex gap-3 pr-4">
        <x-heroicon-o-exclamation class="h-6 w-6 text-indigo-700" />

        <span class="flex-1">
            {!! __('The :languageName translation request for :translationRequestTitle has been deleted.', [
                'translationRequestTitle' => '<strong>'.htmlentities($translationRequestTitle).'</strong>',
                'languageName' => $languageName,
            ]) !!}
        </span>
    </div>
</x-notifications.base-notification>
