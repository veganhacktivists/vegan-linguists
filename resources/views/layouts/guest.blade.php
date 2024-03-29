<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  {{-- Fonts --}}
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

  {{-- Scripts --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  {{-- Styles --}}
  @livewireStyles

  <x-google-analytics />
</head>

<body class="bg-brand-beige-100 bg-opacity-60 text-brand-brown-900">
  <div class="font-sans antialiased">
    {{ $slot }}
  </div>

  <x-cookie-banner />
  @livewireScripts
</body>
</html>
