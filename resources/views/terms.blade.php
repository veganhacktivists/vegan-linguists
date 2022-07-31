<x-guest-layout>
  <div class="py-4">
    <div class="flex min-h-screen flex-col items-center pt-6 sm:pt-0">
      <a href="{{ route('home') }}">
        <x-icon-logo-with-text class="w-56 sm:w-80" />
      </a>

      <div class="prose mt-6 w-full overflow-hidden bg-white p-6 shadow-md sm:max-w-2xl sm:rounded-lg">
        {!! $terms !!}
      </div>
    </div>
  </div>
</x-guest-layout>
