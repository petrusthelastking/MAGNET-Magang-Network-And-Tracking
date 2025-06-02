<x-layouts.user.main user="{{ $role }}">
    @if ($role == 'admin')
        <livewire:pages.admin.profile />
    @elseif ($role == 'dosen')
        <livewire:pages.dosen.profile />
    @elseif ($role == 'mahasiswa')
        <livewire:pages.mahasiswa.profile />
    @endif
</x-layouts.user.main>
