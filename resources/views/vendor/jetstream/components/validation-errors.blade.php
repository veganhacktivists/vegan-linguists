@if ($errors->any())
    <div {{ $attributes->merge([
    'class' => 'rounded-md bg-brandClay-50 border border-brandClay-500 p-4',
]) }}>
        <div class="flex">
            <div class="flex-shrink-0">
                <x-heroicon-s-x-circle class="h-5 w-5 text-brandClay-500" />
            </div>
            <div class="ml-3 text-brandClay-800">
                <h3 class="text-sm font-medium">
                    {{ __('Whoops! Something went wrong.') }}
                </h3>
                <div class="mt-2 text-sm">
                    <ul role="list"
                        class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif
