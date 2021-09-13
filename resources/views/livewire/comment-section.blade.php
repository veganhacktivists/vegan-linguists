<div class="p-4" x-data="">
    <h2 class="text-2xl font-bold">
        {{ __('Discussion') }}
    </h2>

    <div class="bg-white rounded-md overflow-hidden mt-4 shadow border border-gray-200">
        <x-rich-text-editor wire:ignore
                            x-init="$wire.on('comment-saved', () => editor.clear())"
                            x-on:change="e => { $wire.set('content', e.detail.content); $wire.set('plainText', e.detail.plainText) }" />
    </div>

    <div class="text-right mt-4">
        <x-jet-button type="submit"
                      wire:click="saveComment"
                      :disabled="mb_strlen(trim($plainText)) === 0">
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
                                <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                            @endif
                            <div class="relative flex items-start space-x-3">
                                <div class="relative">
                                    <x-user-photo
                                        :user="$comment->author"
                                        class="h-10 w-10 bg-gray-400 flex items-center justify-center ring-8 ring-white" />

                                        <span class="absolute -bottom-0.5 -right-1 bg-white rounded-tl px-0.5 py-px">
                                            <x-heroicon-s-chat-alt class="h-5 w-5 text-gray-400" />
                                        </span>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div>
                                        <div class="text-sm">
                                            <p class="font-medium text-gray-900">
                                                {{ user($comment->author)->name }}
                                            </p>
                                        </div>
                                        <p class="mt-0.5 text-sm text-gray-500">
                                            {{ trans_choice(
                                                '[0] Commented today|[1] Commented yesterday|[*] Commented :value days ago',
                                            Carbon\Carbon::now()->diffInDays($comment->created_at)
                                        ) }}
                                        </p>
                                    </div>
                                    <div class="mt-2 text-sm text-gray-700">
                                        <x-rich-text-editor
                                            wire:ignore
                                            :wire:key="$comment->id"
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
