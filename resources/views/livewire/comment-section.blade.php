<div class="p-4" x-data="">
  <h2 class="text-2xl font-bold">
    {{ __('Discussion') }}
  </h2>

  <div class="mt-4 rounded-md border border-brand-brown-200 bg-white shadow">
    <x-rich-text-editor x-init="$wire.on('comment-saved', () => clear())" wireContentModel="content" wirePlainTextModel="plainText"
      @comment-quote.window="
       setContent($event.detail.content, 'blockquote', true).then(() => {
        $wire.set('metadata', $event.detail.metadata);
        insertText('\n\n');
        setTimeout(() => focus(), 0)
       })
       " />
  </div>

  <div class="mt-4 text-right">
    <x-button type="submit" :disabled="mb_strlen(trim($plainText)) === 0" wire:loading.attr="disabled" wire:click="saveComment">
      {{ __('Comment') }}
    </x-button>
  </div>

  @if ($commentable->comments->count() > 0)
    <div class="mt-4 flow-root rounded-md bg-white p-4">
      <ul role="list">
        @foreach ($commentable->comments->reverse() as $comment)
          <li>
            <div class="{{ $loop->last ? '' : 'pb-8' }} relative">
              @if (!$loop->last)
                <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
              @endif
              <div class="relative flex items-start space-x-3">
                <div class="relative">
                  <x-user-photo :user="$comment->author"
                    class="flex h-10 w-10 items-center justify-center bg-brand-clay-200 ring-8 ring-white" />

                  <span class="absolute -bottom-0.5 -right-1 rounded-tl bg-white px-0.5 py-px">
                    <x-heroicon-s-chat-bubble-left-ellipsis class="h-5 w-5 text-brand-clay-400" />
                  </span>
                </div>
                <div class="min-w-0 flex-1">
                  <div>
                    <p class="text-sm">
                      {{ user($comment->author)->name }}
                    </p>
                    <p class="mt-0.5 text-sm text-brand-brown-500">
                      {{ trans_choice('{0} Commented today|{1} Commented yesterday|[2,*] Commented :count days ago', Carbon\Carbon::now()->diffInDays($comment->created_at)) }}
                    </p>
                  </div>
                  <div class="mt-2 text-sm">
                    <x-rich-text-editor :wire:key="$comment->id" :content="$comment->content" :disableStyles="true"
                      :isReadOnly="true" />

                    @if ($comment->hasAnnotation())
                      <div class="mt-2">
                        <div class="flex gap-2">
                          @php($index = $comment->metadata['annotation']['index'])
                          @php($length = $comment->metadata['annotation']['length'])
                          <x-secondary-button
                            @click="$dispatch('highlight-annotation', { index: {{ $index }}, length: {{ $length }} })">
                            {{ __('Jump to annotation') }}
                          </x-secondary-button>

                          @if (!$comment->is_resolved)
                            @can('resolveComment', $commentable)
                              <x-button wire:click="resolveComment({{ $comment->id }})">
                                {{ __('Mark resolved') }}
                              </x-button>
                            @else
                              <div
                                class="flex items-center gap-2 rounded bg-brand-clay-400 px-4 text-xs font-bold text-white">
                                {{ __('Pending resolution') }}
                              </div>
                            @endcan
                          @else
                            <div
                              class="flex items-center gap-2 rounded bg-brand-green-400 px-4 text-xs font-bold text-white">
                              {{ __('Resolved') }}
                              <x-heroicon-o-check-circle class="h-5 w-5" />
                            </div>
                          @endif
                        </div>
                      </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </li>
        @endforeach
      </ul>
    </div>
  @endif
</div>
