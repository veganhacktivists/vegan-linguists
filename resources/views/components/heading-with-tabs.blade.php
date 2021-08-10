@props(['title'])

<div class="border-b border-gray-200">
    <div class="sm:flex sm:items-baseline">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            {{ $title }}
        </h3>
        <div class="mt-4 sm:mt-0 sm:ml-10">
            <nav class="-mb-px flex space-x-4 sm:space-x-8">
                {{ $slot }}
            </nav>
        </div>
    </div>
</div>
