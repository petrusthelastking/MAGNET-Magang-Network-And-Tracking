<x-layouts.mahasiswa.mahasiswa>

    <div class="card bg-white shadow-md">
        <div class="card-body">
            <flux:input readonly value="Yanto" type="text" label="Nama Lengkap" />
            <flux:input readonly value="Teknologi Informasi" type="text" label="Jurusan" />
            <flux:input readonly value="D4 Teknik Informatika" type="text" label="Program Studi" />
            <flux:input type="file" wire:model="attachments" label="Transkrip Nilai" />
            <flux:input type="file" wire:model="attachments" label="CV" />
            <flux:input type="file" wire:model="attachments" label="Portofolio" />
        </div>
        <div class="card-actions flex justify-end p-5">
            <flux:modal.trigger name="confirm-form" class="mr-2">
                <flux:button class="bg-magnet-sky-teal! text-white!">Kirim</flux:button>
            </flux:modal.trigger>

            <flux:modal name="confirm-form" class="min-w-[22rem]">
                <div class="space-y-6">
                    <div>
                        <flux:heading size="lg">Kirim Pengajuan Magang</flux:heading>

                        <flux:text class="mt-2">
                            <p>Apakah anda sudah yakin?</p>
                        </flux:text>
                    </div>

                    <div class="flex gap-2">
                        <flux:spacer />

                        <flux:modal.close>
                            <flux:button variant="ghost">Batal</flux:button>
                        </flux:modal.close>
                        <flux:modal.close>
                            <flux:modal.trigger name="show-success">
                                <flux:button type="submit" class="bg-magnet-sky-teal! text-white!">Kirim</flux:button>
                            </flux:modal.trigger>
                        </flux:modal.close>
                    </div>
                </div>
            </flux:modal>

            <flux:modal name="show-success" class="min-w-[22rem]">
                <div class="space-y-6">
                    <div>
                        <flux:heading size="lg">Pengajuan Magang Anda Telah Dikirim</flux:heading>
                    </div>

                    <div class="flex gap-2">
                        <flux:spacer />
                        <flux:modal.close>
                            <flux:button type="submit" class="bg-magnet-sky-teal! text-white!">Oke</flux:button>
                        </flux:modal.close>
                    </div>
                </div>
            </flux:modal>

        </div>
    </div>
</x-layouts.mahasiswa.mahasiswa>