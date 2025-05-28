<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-magnet-frost-mist text-black">
        <x-guest.navbar />
        {{ $slot }}

        @fluxScripts
    </body>
</html>
