<!DOCTYPE html>
<html lang="{{ str_replace('', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="bg-magnet-frost-mist">
    <div class="flex min-h-screen">
        <x-admin.sidebar />

        <div class="w-full">
            <x-user.topbar />
            <div class="p-8 flex flex-col gap-5">

                {{ $slot }}
            </div>
        </div>
    </div>
    @fluxScripts
</body>

</html>