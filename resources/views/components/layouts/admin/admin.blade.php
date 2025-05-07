<!DOCTYPE html>
<html lang="{{ str_replace('', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white flex">
    <x-admin.sidebar />

    <div class="w-full">
        <x-topbar /> 
        <div class="p-8">
            @yield('content')
            
            {{ $slot }}
        </div>
    </div>
    @fluxScripts
</body>

</html>