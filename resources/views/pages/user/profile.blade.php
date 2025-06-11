<?php

use function Livewire\Volt\{state, mount, layout};
use App\Helpers\Auth\UserAuthenticationHelper;


state([
    'role'
]);

mount(function () {
    $this->role = UserAuthenticationHelper::getUserRole();
});

layout('components.layouts.user.main');

?>

<div>
    <x-slot:user>{{ $role }}</x-slot:user>

    @if ($role == 'admin')
        <livewire:pages.admin.profile />
    @elseif ($role == 'dosen')
        <livewire:pages.dosen.profile />
    @elseif ($role == 'mahasiswa')
        <livewire:pages.mahasiswa.profile />
    @endif
</div>
