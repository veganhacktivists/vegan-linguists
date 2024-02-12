<div>
@switch (true)
  @case($isMine)
    <x-translation-request.claimed-page :translationRequest="$translationRequest" />
  @break

  @case($translationRequest->isUnclaimed())
    <x-translation-request.unclaimed-page :translationRequest="$translationRequest" />
  @break

  @case($translationRequest->isUnderReview())
    @if ($canReview)
      <x-translation-request.under-review-page :translationRequest="$translationRequest" />
    @else
      <x-translation-request.needs-review-page :translationRequest="$translationRequest" />
    @endif
  @break

  @case($translationRequest->isComplete())
    <x-translation-request.under-review-page :translationRequest="$translationRequest" />
  @break

@endswitch
</div>
