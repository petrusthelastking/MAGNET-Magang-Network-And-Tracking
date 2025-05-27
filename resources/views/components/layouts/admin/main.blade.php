<!DOCTYPE html>
<html lang="{{ str_replace('', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="bg-magnet-frost-mist flex min-h-screen">
    <x-admin.sidebar />

    <div class="w-full">
        <livewire:components.user.topbar />
        <div class="p-8 flex flex-col gap-5">

            {{ $slot }}
        </div>
    </div>

    @fluxScripts
</body>

</html>
