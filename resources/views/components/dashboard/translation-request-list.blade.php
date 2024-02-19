@props(['translationRequests', 'displayStatus' => false, 'displayPriority' => false])

<div class="flow-root w-full">
  <ul role="list" class="-my-5 divide-y divide-brand-brown-200">
    @foreach ($translationRequests as $translationRequest)
      <li class="py-4">
        <div class="flex items-center space-x-4">
          <div class="flex-shrink-0">
            <x-user-photo :user="$translationRequest->source->author" class="h-8 w-8" />
          </div>
          <div class="flex-1 overflow-hidden">
            <p class="truncate text-sm font-medium text-brand-brown-900">
              <a href="{{ route('translate', [$translationRequest->id, $translationRequest->source->slug]) }}"
                class="hover:underline">
                {{ $translationRequest->source->title }}
              </a>
            </p>
            <p class="flex items-center truncate text-sm text-brand-brown-700">
              {{ $translationRequest->source->language->native_name }}
              <x-heroicon-o-arrow-small-right class="h-4 w-4" />
              {{ $translationRequest->language->native_name }}
            </p>
          </div>

          @if ($displayStatus)
            <div>
              <x-badge class="border border-brand-clay-300 px-2.5 py-0.5 text-sm text-brand-clay-700 shadow-sm">
                @if ($translationRequest->isClaimed())
                  {{ __('Claimed') }}
                @elseif ($translationRequest->isUnderReview())
                  @if ($translationRequest->hasBeenApprovedBy(Auth::user()))
                    {{ __('Approved') }}
                  @else
                    {{ __('Under Review') }}
                  @endif
                @elseif ($translationRequest->isComplete())
                  @if ($translationRequest->translator->is(Auth::user()))
                    {{ __('Translated') }}
                  @else
                    {{ __('Reviewed') }}
                  @endif
                @endif
              </x-badge>
            </div>
          @elseif ($displayPriority)
            <div class="flex items-center gap-2 text-brand-clay-700">
              <x-heroicon-o-clock class="h-6 w-6" />
              {{ trans_choice('{0} Today|{1} Yesterday|[2,*] :count days', Carbon\Carbon::now()->diffInDays($translationRequest->created_at)) }}
            </div>
          @endif
        </div>
      </li>
    @endforeach
  </ul>
</div>
