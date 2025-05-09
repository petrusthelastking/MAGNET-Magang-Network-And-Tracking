<!DOCTYPE html>
<html lang="{{ str_replace('', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="bg-[linear-gradient(245deg,_#AEE1FC_8.6%,_#FFF_82.92%)]">
    <div class="flex min-h-screen">
        <x-admin.sidebar />

        <div class="w-full">
            <x-topbar />
            <div class="p-8">
                @yield('content')

                {{ $slot }}
            </div>
        </div>
    </div>
    @fluxScripts
</body>

</html>