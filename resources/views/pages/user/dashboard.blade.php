<?php

use function Livewire\Volt\{state, mount, layout};
use App\Helpers\Auth\UserAuthenticationHelper;


state([
    'currentRole'
]);

mount(function () {
    $this->currentRole = UserAuthenticationHelper::getUserRole();
});

layout('components.layouts.user.main');

?>

<div>
    <x-slot:user>{{ $currentRole }}</x-slot:user>

    @if ($currentRole == 'admin')
        <livewire:pages.admin.dashboard />
    @elseif ($currentRole == 'dosen')
        <livewire:pages.dosen.dashboard />
    @elseif ($currentRole == 'mahasiswa')
        <livewire:pages.mahasiswa.dashboard />
    @endif
</div>
