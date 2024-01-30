@php
$secondTourStepText = __('This is the translation that you are reviewing. If you think anything can be approved, simply select the relevant text and click the "Comment" button that appears above it.');

$secondTourStepImageAlt = __('Demonstration of the review functionality');

$secondTourStepHtml = <<<HTML
<p>$secondTourStepText</p>

<img src="/img/review-demonstration.gif" alt="$secondTourStepImageAlt" class="mt-2 w-full border border-brand-brown-400" />
HTML;

$helpTourSteps = [
    [
        'attachTo' => [
            'element' => '#sourceContent',
            'on' => 'right-start',
        ],
        'title' => __('Original Content'),
        'text' => __('Here, you will see the content as it was written in its original languages. Use this as a reference when reviewing the translation.'),
    ],
    [
        'attachTo' => [
            'element' => '#translationContent',
            'on' => 'left-start',
        ],
        'title' => __('Translation'),
        'text' => $secondTourStepHtml,
    ],
    [
        'attachTo' => [
            'element' => '#approveButton',
            'on' => 'top-end',
        ],
        'title' => __('Approve the Translation'),
        'text' => __('Once all feedback has been addressed by the translator and you are completely satisfied with the translation, approve the translation! Once it has been approved by enough reviewers, then it will be considered complete.'),
        'modalOverlayOpeningPadding' => 8,
        'modalOverlayOpeningRadius' => 8,
        'popperOptions' => [
            'modifiers' => [
                [
                    'name' => 'offset',
                    'options' => ['offset' => [0, 24]],
                ],
            ],
        ],
    ],
];
@endphp

<div class="flex h-full flex-col bg-white">
  <x-slot name="pageTitle">{{ $translationRequest->source->title }}</x-slot>

  <x-slot name="picker">
    <x-dropdown align="left" width="48">
      <x-slot name="trigger">
        <x-button>
          {{ __('Menu') }}
        </x-button>
      </x-slot>

      <x-slot name="content">
        <x-dropdown-link href="#" aria-role="button" @click.prevent="$dispatch('change-tab', 'source')">
          {{ __('Original content') }}
        </x-dropdown-link>

        <x-dropdown-link href="#" aria-role="button" @click.prevent="$dispatch('change-tab', 'discussion')">
          {{ __('Discussion') }}
        </x-dropdown-link>

        @can('approve', $translationRequest)
          <div class="border-t border-brand-brown-200"></div>

          <x-dropdown-link href="#" aria-role="button" @click.prevent="Livewire.emit('toggleApprovalModal')">
            {{ __('Approve translation') }}
          </x-dropdown-link>
        @endcan
      </x-slot>
    </x-dropdown>
  </x-slot>

  <div class="flex h-full bg-white" x-data="{ tab: window.location.hash === '#discussion' ? 'discussion' : 'source' }"
    @change-tab.window="
            tab = $event.detail;
            history.replaceState(null, null, window.location.pathname + ('#' + tab).replace('#source', ''));
         ">
    <div class="flex w-full flex-col divide-y divide-brand-brown-200 lg:flex-row lg:divide-x lg:divide-y-0">
      <div class="z-10 flex w-full flex-1 flex-col overflow-hidden">
        <div class="h-full overflow-hidden" id="sourceContent">
          <div class="h-full overflow-auto">
            <div x-show="tab === 'source'" class="flex-1">
              <x-rich-text-editor :content="$translationRequest->source->content" :isReadOnly="true" />
            </div>

            <div class="mx-auto max-w-7xl flex-1" x-show="tab === 'discussion'">
              <livewire:comment-section :commentable="$translationRequest" />
            </div>
          </div>
        </div>

        <div class="order-first hidden border-b border-brand-brown-200 md:flex lg:order-none lg:border-t lg:border-b-0">
          <button class="h-14 flex-1 bg-brand-clay-400 font-bold text-white"
            @click.prevent="$dispatch('change-tab', 'source')"
            x-bind:class="{ 'bg-brand-clay-400 font-bold text-white': tab ===
                'source', 'bg-brand-beige-50 hover:bg-brand-beige-100': tab !== 'source' }">
            {{ __('Original Content') }}
          </button>
          <button class="h-14 flex-1" @click.prevent="$dispatch('change-tab', 'discussion')"
            x-bind:class="{ 'bg-brand-clay-400 font-bold text-white': tab ===
                'discussion', 'bg-brand-beige-50 hover:bg-brand-beige-100': tab !== 'discussion' }">
            {{ __('Discussion') }}
          </button>
        </div>
      </div>

      <div class="flex w-full flex-1 flex-col overflow-hidden">

        <div class="h-full overflow-hidden" id="translationContent">
          <div class="h-full overflow-auto">
            <div class="mx-auto max-w-full flex-1">
              <x-rich-text-editor :content="$translationRequest->content"
                @highlight-annotation.window="highlight($event.detail.index, $event.detail.length)" :isReadOnly="true">
                <x-slot name="inlineToolbar">
                  <x-primary-button @click="$wire.startReviewComment(selection)">
                    {{ __('Comment') }}
                  </x-primary-button>
                </x-slot>
              </x-rich-text-editor>
            </div>
          </div>
        </div>

        <div class="hidden border-t border-brand-brown-200 bg-brand-beige-50 md:flex">
          <div class="flex h-14 w-full items-center justify-end gap-2 px-2">
            @can('approve', $translationRequest)
              <x-tour :steps="$helpTourSteps" element="button" type="button"
                class="-mx-1 mr-auto ml-2 flex rounded-full p-1 text-brand-brown-600 hover:text-brand-brown-800"
                id="helpButton" @click="start()">
                <x-heroicon-o-question-mark-circle class="h-6 w-6" />
              </x-tour>
              <x-button wire:click="toggleApprovalModal" type="button" id="approveButton">
                {{ __('Approve translation') }}
              </x-button>
            @else
              <div class="w-full px-4 text-center">
                @if ($translationRequest->isComplete())
                  {{ __('You approved this translation. Thanks for your contribution!') }}
                @else
                  {{ __('You have approved this translation. It is now awaiting more approvals.') }}
                @endif
              </div>
            @endcan
          </div>
        </div>
      </div>

      <x-dialog-modal wire:model="isConfirmingApproval">
        <x-slot name="title">
          {{ __('Approve Translation') }}
        </x-slot>

        <x-slot name="content">
          {{ __('Are you sure you would like to approve this translation?') }}
          <strong class="mt-3 block">
            {{ __('Make sure you are completely satisfied with the translation, because this cannot be undone.') }}
          </strong>

          <x-validation-errors class="mt-3" />
        </x-slot>

        <x-slot name="footer">
          <x-secondary-button wire:click="toggleApprovalModal" wire:loading.attr="disabled">
            {{ __('Cancel') }}
          </x-secondary-button>

          <x-button class="ml-2" wire:click="approveTranslation" wire:loading.attr="disabled">
            {{ __('Approve') }}
          </x-button>
        </x-slot>
      </x-dialog-modal>
    </div>
  </div>
</div>
