<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-magnet-frost-mist">

<head>
    @include('partials.head')
</head>

<body class="text-black">
    {{ $slot }}

    @fluxScripts
</body>

</html>
