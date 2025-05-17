<div>
    <!-- Form -->
    <form method="POST" action="#" enctype="multipart/form-data">
        @csrf

        <!-- Input fields -->
        <div class="mb-6">
            <flux:input type="file" wire:model="attachments" label="Bukti Surat Selesai Magang"/>
    </form>
</div>