@php
$secondTourStepText = __('This is the translation that you are reviewing. If you think anything can be approved, simply select the relevant text and click the "Comment" button that appears above it.');

$secondTourStepImageAlt = __('Demonstration of the review functionality');

$secondTourStepHtml = <<<HTML
<p>$secondTourStepText</p>

<img src="/img/review-demonstration.gif" alt="$secondTourStepImageAlt" class="w-full mt-2 border border-brand-brown-400" />
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

<div class="bg-white h-full flex flex-col">
    <x-slot name="pageTitle">{{ $translationRequest->source->title }}</x-slot>

    <x-slot name="picker">
        <x-jet-dropdown align="left"
                        width="48">
            <x-slot name="trigger">
                <x-jet-button>
                    {{ __('Menu') }}
                </x-jet-button>
            </x-slot>

            <x-slot name="content">
                <x-jet-dropdown-link href="#"
                                     aria-role="button"
                                     @click.prevent="$dispatch('change-tab', 'source')">
                    {{ __('Original content') }}
                </x-jet-dropdown-link>

                <x-jet-dropdown-link href="#"
                                     aria-role="button"
                                     @click.prevent="$dispatch('change-tab', 'discussion')">
                    {{ __('Discussion') }}
                </x-jet-dropdown-link>

                @can('approve', $translationRequest)
                    <div class="border-t border-brand-brown-200"></div>

                    <x-jet-dropdown-link href="#"
                                         aria-role="button"
                                         @click.prevent="Livewire.emit('toggleApprovalModal')">
                        {{ __('Approve translation') }}
                    </x-jet-dropdown-link>
                @endcan
            </x-slot>
        </x-jet-dropdown>
    </x-slot>

    <div class="bg-white flex h-full"
         x-data="{ tab: window.location.hash === '#discussion' ? 'discussion' : 'source' }"
         @change-tab.window="
            tab = $event.detail;
            history.replaceState(null, null, window.location.pathname + ('#' + tab).replace('#source', ''));
         ">
        <div class="flex flex-col lg:flex-row divide-y lg:divide-x lg:divide-y-0 divide-brand-brown-200 w-full">
            <div class="flex flex-col flex-1 w-full overflow-hidden z-10">
                <div class="overflow-hidden h-full"
                     id="sourceContent">
                    <div class="overflow-auto h-full">
                        <div x-show="tab === 'source'"
                             class="flex-1">
                            <x-rich-text-editor :content="$translationRequest->source->content"
                                                :isReadOnly="true" />
                        </div>

                        <div class="max-w-7xl mx-auto flex-1"
                             x-show="tab === 'discussion'">
                            <livewire:comment-section :commentable="$translationRequest" />
                        </div>
                    </div>
                </div>

                <div
                     class="hidden md:flex order-first lg:order-none border-b lg:border-t lg:border-b-0 border-brand-brown-200">
                    <button class="bg-brand-clay-400 font-bold text-white h-14 flex-1"
                            @click.prevent="$dispatch('change-tab', 'source')"
                            x-bind:class="{ 'bg-brand-clay-400 font-bold text-white': tab === 'source', 'bg-brand-beige-50 hover:bg-brand-beige-100': tab !== 'source' }">
                        {{ __('Original Content') }}
                    </button>
                    <button class="h-14 flex-1"
                            @click.prevent="$dispatch('change-tab', 'discussion')"
                            x-bind:class="{ 'bg-brand-clay-400 font-bold text-white': tab === 'discussion', 'bg-brand-beige-50 hover:bg-brand-beige-100': tab !== 'discussion' }">
                        {{ __('Discussion') }}
                    </button>
                </div>
            </div>

            <div class="flex flex-col flex-1 w-full overflow-hidden">

                <div class="overflow-hidden h-full"
                     id="translationContent">
                    <div class="overflow-auto h-full">
                        <div class="mx-auto flex-1 max-w-full">
                            <x-rich-text-editor :content="$translationRequest->content"
                                                @highlight-annotation.window="highlight($event.detail.index, $event.detail.length)"
                                                :isReadOnly="true">
                                <x-slot name="inlineToolbar">
                                    <x-jet-primary-button @click="$wire.startReviewComment(selection)">
                                        {{ __('Comment') }}
                                    </x-jet-primary-button>
                                </x-slot>
                            </x-rich-text-editor>
                        </div>
                    </div>
                </div>

                <div class="hidden md:flex bg-brand-beige-50 border-t border-brand-brown-200">
                    <div class="flex items-center justify-end gap-2 px-2 h-14 w-full">
                        @can('approve', $translationRequest)
                            <div class="mr-auto">
                                <x-tour :steps="$helpTourSteps"
                                        element="button"
                                        type="button"
                                        id="helpButton"
                                        @click="start()">
                                    <x-heroicon-o-question-mark-circle class="h-6 w-6" />
                                </x-tour>
                            </div>
                            <x-jet-button wire:click="toggleApprovalModal"
                                          type="button"
                                          id="approveButton">
                                {{ __('Approve translation') }}
                            </x-jet-button>
                        @else
                            <div class="w-full text-center px-4">
                                {{ __('You have approved this translation. It is now awaiting more approvals.') }}
                            </div>
                        @endcan
                    </div>
                </div>
            </div>

            <x-jet-dialog-modal wire:model="isConfirmingApproval">
                <x-slot name="title">
                    {{ __('Approve Translation') }}
                </x-slot>

                <x-slot name="content">
                    {{ __('Are you sure you would like to approve this translation?') }}
                    <strong class="block mt-3">
                        {{ __('Make sure you are completely satisfied with the translation, because this cannot be undone.') }}
                    </strong>

                    <x-jet-validation-errors class="mt-3" />
                </x-slot>

                <x-slot name="footer">
                    <x-jet-secondary-button wire:click="toggleApprovalModal"
                                            wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-jet-secondary-button>

                    <x-jet-button class="ml-2"
                                  wire:click="approveTranslation"
                                  wire:loading.attr="disabled">
                        {{ __('Approve') }}
                    </x-jet-button>
                </x-slot>
            </x-jet-dialog-modal>
        </div>
    </div>
</div>
