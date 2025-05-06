<!DOCTYPE html>
<html lang="{{ str_replace('', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white flex">

    <x-sidebar> </x-sidebar>

    <div class="w-full">
        <x-topbar> </x-topbar>
        <div class="p-8">
            {{ $slot }}

        </div>
    </div>
    @fluxScripts
</body>

</html>