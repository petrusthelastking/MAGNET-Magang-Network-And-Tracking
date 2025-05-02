<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="bg-pale-yellow">
    {{ $slot }}
    
    @fluxScripts
</body>

</html>