<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
    {{ $topScript ?? '' }}
</head>

<body class="min-h-screen bg-magnet-frost-mist text-black">
    <x-guest.navbar />
    {{ $slot }}

    {{ $bottomScript ?? '' }}
    @fluxScripts
</body>

</html>
