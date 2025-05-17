<div>
    <form method="POST" action="#" enctype="multipart/form-data">
        @csrf

        <!-- Input fields -->
        <flux:input type="text" label="Perusahaan Tempat Magang" />
        <flux:input type="text" label="lokasi Perusahaan" />
        <flux:input type="file" wire:model="attachments" label="Bukti Surat Izin Magang"/>
    </form>
</div>