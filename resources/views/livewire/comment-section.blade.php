<div class="p-4"
     x-data="">
    <h2 class="text-2xl font-bold">
        {{ __('Discussion') }}
    </h2>

    <div class="bg-white rounded-md mt-4 shadow border border-brandBrown-200">
        <x-rich-text-editor x-init="$wire.on('comment-saved', () => clear())"
                            wireContentModel="content"
                            wirePlainTextModel="plainText" />
    </div>

    <div class="text-right mt-4">
        <x-jet-button type="submit"
                      :disabled="mb_strlen(trim($plainText)) === 0"
                      wire:loading.attr="disabled"
                      wire:click="saveComment">
            {{ __('Comment') }}
        </x-jet-button>
    </div>

    @if ($commentable->comments->count() > 0)
        <div class="flow-root bg-white mt-4 p-4 rounded-md">
            <ul role="list">
                @foreach ($commentable->comments->reverse() as $comment)
                    <li>
                        <div class="relative {{ $loop->last ? '' : 'pb-8' }}">
                            @if (!$loop->last)
                                <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200"
                                      aria-hidden="true"></span>
                            @endif
                            <div class="relative flex items-start space-x-3">
                                <div class="relative">
                                    <x-user-photo :user="$comment->author"
                                                  class="h-10 w-10 bg-brandClay-200 flex items-center justify-center ring-8 ring-white" />

                                    <span class="absolute -bottom-0.5 -right-1 bg-white rounded-tl px-0.5 py-px">
                                        <x-heroicon-s-chat-alt class="h-5 w-5 text-brandClay-400" />
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div>
                                        <p class="text-sm">
                                            {{ user($comment->author)->name }}
                                        </p>
                                        <p class="mt-0.5 text-sm text-brandBrown-500">
                                            {{ trans_choice('[0] Commented today|[1] Commented yesterday|[*] Commented :value days ago', Carbon\Carbon::now()->diffInDays($comment->created_at)) }}
                                        </p>
                                    </div>
                                    <div class="mt-2 text-sm">
                                        <x-rich-text-editor :wire:key="$comment->id"
                                                            :content="$comment->content"
                                                            :disableStyles="true"
                                                            :isReadOnly="true" />
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
