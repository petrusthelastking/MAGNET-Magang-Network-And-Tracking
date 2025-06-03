<!DOCTYPE html>
<html lang="{{ str_replace('', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="bg-magnet-frost-mist flex min-h-screen text-black">
    @if ($user == 'admin')
        <x-admin.sidebar />
    @elseif ($user == 'dosen')
        <x-dosen.sidebar />
    @elseif ($user == 'mahasiswa')
        <x-mahasiswa.sidebar />
    @endif

    <div class="w-full">
        <livewire:components.user.topbar />
        <div class="{{ $isFullPage??'p-8 flex flex-col gap-5'}}">

            {{ $slot }}
        </div>
    </div>

    @fluxScripts
</body>

</html>
