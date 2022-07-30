<x-guest-layout>
    <div class="py-4">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            <a href="{{ route('home') }}">
                <x-icon-logo-with-text class="w-56 sm:w-80" />
            </a>

            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                {!! $policy !!}
            </div>
        </div>
    </div>
</x-guest-layout>
