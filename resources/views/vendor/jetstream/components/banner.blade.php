@props(['style' => session('flash.bannerStyle', 'success'), 'message' => session('flash.banner')])

<div x-data="{{ json_encode(['show' => true, 'style' => $style, 'message' => $message]) }}" :class="{ 'bg-brand-green-400': style == 'success', 'bg-red-700': style == 'danger' }"
  style="display: none;" x-show="show && message" x-init="document.addEventListener('banner-message', event => {
      style = event.detail.style;
      message = event.detail.message;
      show = true;
  });">
  <div class="mx-auto py-2 px-3 sm:px-4">
    <div class="flex flex-wrap items-center justify-between">
      <div class="flex w-0 min-w-0 flex-1 items-center">
        <span class="flex rounded-lg p-2"
          :class="{ 'bg-brand-green-500': style == 'success', 'bg-red-600': style == 'danger' }">
          <x-heroicon-o-check-circle class="h-5 w-5 text-white" />
        </span>

        <p class="ml-3 truncate text-sm text-white" x-text="message"></p>
      </div>

      <div class="flex-shrink-0 sm:ml-3">
        <button type="button" class="-mr-1 flex rounded-md p-2 transition focus:outline-none sm:-mr-2"
          :class="{ 'hover:bg-brand-green-500 focus:bg-brand-green-500': style ==
              'success', 'hover:bg-red-600 focus:bg-red-600': style == 'danger' }"
          aria-label="Dismiss" x-on:click="show = false">
          <x-heroicon-o-x-mark class="h-5 w-5 text-white" />
        </button>
      </div>
    </div>
  </div>
</div>
