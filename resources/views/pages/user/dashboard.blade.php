<x-layouts.user.main user="{{ $role }}">
    @if ($role == 'admin')
        <livewire:pages.admin.dashboard />
    @elseif ($role == 'dosen')
        <livewire:pages.dosen.dashboard />
    @elseif ($role == 'mahasiswa')
        <livewire:pages.mahasiswa.dashboard />
    @endif
</x-layouts.user.main>
