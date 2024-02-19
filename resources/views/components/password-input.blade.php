<div class="{{ $containerClass ?? '' }} relative" x-data="{ show: false }">
  <x-input x-bind:type="show ? 'text' : 'password'" {{ $attributes->merge([
      'class' => 'pr-10 w-full',
  ]) }} />
  <button class="absolute right-2 top-2" type="button" @click="show = !show"
    x-bind:title="show ? '{{ __('Hide password') }}' : '{{ __('Show password') }}'">
    <x-heroicon-o-eye class="h-6 w-6" x-bind:class="{ hidden: show }" />
    <x-heroicon-o-eye-slash class="hidden h-6 w-6" x-bind:class="{ hidden: !show }" />
  </button>
</div>
