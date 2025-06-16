<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-magnet-frost-mist">

<head>
    @include('partials.head')
    {{ $topScript ?? '' }}
</head>

<body class="min-h-screen text-black">
    <x-guest.navbar />
    {{ $slot }}

    {{ $bottomScript ?? '' }}
    @fluxScripts
</body>

</html>
