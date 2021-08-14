<div class="bg-white h-full flex flex-col">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $source->title }}
            </h2>
            @if ($isViewingTranslation)
                <div>
                    <a href="{{ route('source', [$source->id, $source->slug]) }}" class="group flex items-center gap-1">
                        <x-heroicon-o-arrow-sm-left
                            class="h-6 w-6 hidden sm:block transform transition-transform group-hover:-translate-x-1" />
                        {{ __('View original') }}
                    </a>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="bg-white">
        <div class="flex flex-col lg:flex-row max-w-7xl mx-auto">
            <div class="pl-6 pr-6 lg:pr-0 pt-6 flex-1">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-2">
                    @foreach ($source->translationRequests as $translationRequest)
                        <x-dashboard.translation-request-row
                            class=""
                            :translationRequest="$translationRequest"
                            :source="$source" />
                    @endforeach
                </div>
            </div>
            <div class="prose prose-lg prose-indigo p-6 w-full break-words">
                <x-rich-text-editor :content="$content" :isReadOnly="true" />
            </div>
        </div>
    </div>
</div>
