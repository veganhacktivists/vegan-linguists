@props(['source', 'translationRequest'])

<li {{ $attributes->except('href') }}>
    <a class="block hover:bg-brandClay-50 hover:bg-opacity-50 focus:bg-brandClay-50 focus:outline-none"
       {{ $attributes->only('href') }}>
        <div class="px-4 py-4 sm:px-6">
            <div class="flex items-center justify-between">
                <p class="text-brandClay-600 truncate">
                    {{ $translationRequest->source->title }}
                </p>
                <div class="ml-2 flex-shrink-0 flex">
                    <p class="inline-flex text-lg leading-5 font-semibold text-brandClay-700">
                        {{ $translationRequest->language->native_name }}
                    </p>
                </div>
            </div>
            <div class="mt-2 sm:flex sm:justify-between">
                <div class="sm:flex">
                    <p class="flex items-center text-brandBrown-600">
                        <x-heroicon-o-translate class="flex-shrink-0 mr-1.5 h-5 w-5 text-brandBrown-500" />
                        {{ $translationRequest->source->language->native_name }}
                    </p>
                    <p class="mt-2 flex items-center text-brandBrown-600 sm:mt-0 sm:ml-6">
                        <x-heroicon-o-user-circle class="flex-shrink-0 mr-1.5 h-5 w-5 text-brandBrown-500" />
                        {{ $translationRequest->source->author->name }}
                    </p>
                </div>
            </div>
        </div>
    </a>
</li>
