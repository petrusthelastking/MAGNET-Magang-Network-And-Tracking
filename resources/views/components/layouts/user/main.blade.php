<!DOCTYPE html>
<html lang="{{ str_replace('', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-magnet-frost-mist flex h-screen text-black">
    @if ($user == 'admin')
        <x-admin.sidebar />
    @elseif ($user == 'dosen')
        <x-dosen.sidebar />
    @elseif ($user == 'mahasiswa')
        <x-mahasiswa.sidebar />
    @endif

    <div class="w-full h-full overflow-auto">
        <livewire:components.user.topbar />
        <div class="{{ $customContainerClass ?? 'p-8 flex flex-col gap-5'}}">

            {{ $slot }}
        </div>
    </div>

    @yield('script')
    @fluxScripts
</body>

</html>
