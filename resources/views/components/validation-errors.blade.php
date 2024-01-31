@if ($errors->any())
  <div
    {{ $attributes->merge([
        'class' => 'rounded-md bg-brand-clay-50 border border-brand-clay-500 p-4',
    ]) }}>
    <div class="flex">
      <div class="flex-shrink-0">
        <x-heroicon-s-x-circle class="h-5 w-5 text-brand-clay-500" />
      </div>
      <div class="ml-3 text-brand-clay-800">
        <h3 class="text-sm">
          {{ __('Whoops! Something went wrong.') }}
        </h3>
        <div class="mt-2 text-sm">
          @if ($errors->count() > 1)
            <ul role="list" class="list-disc space-y-1 pl-5">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          @else
            <strong>
              {{ $errors->first() }}
            </strong>
          @endif
        </div>
      </div>
    </div>
  </div>
@endif
