<div class="space-y-6">
    <flux:breadcrumbs class="mb-6">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('profile') }}" class="text-gray-600">Profil Anda</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="mb-8">
        <h1 class="text-2xl font-bold leading-7 text-gray-900 mb-2">Edit Profil Anda</h1>
        <p class="text-sm text-gray-600">Perbarui informasi profil dan data pribadi Anda</p>
    </div>

    @if (session('success'))
        <div class="bg-green-50 border border-green-200 rounded-md p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-50 border border-red-200 rounded-md p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Header Section with Avatar -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-8">
                <div class="flex items-center space-x-6">
                    <div class="relative">
                        <flux:avatar circle
                            src="{{ auth('dosen')->user()->foto ? asset('storage/' . auth('dosen')->user()->foto) : asset('img/user/lecturer-man.png') }}"
                            class="w-24 h-24 ring-4 ring-white shadow-lg" />
                        <div class="absolute bottom-0 right-0 w-6 h-6 bg-green-400 border-2 border-white rounded-full">
                        </div>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-xl font-semibold text-gray-900 mb-1">{{ auth('dosen')->user()->nama }}</h2>
                        <p class="text-sm text-gray-600 mb-2">NIDN: {{ auth('dosen')->user()->nidn }}</p>
                        <div class="flex items-center space-x-2">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="w-1.5 h-1.5 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3" />
                                </svg>
                                Aktif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="px-6 py-6">
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Personal</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <flux:input name="nama" value="{{ old('nama', auth('dosen')->user()->nama) }}"
                                type="text" label="Nama Lengkap" required />
                            @error('nama')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1">
                            <flux:input name="nidn" value="{{ old('nidn', auth('dosen')->user()->nidn) }}"
                                type="text" label="NIDN" required />
                            @error('nidn')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                            <flux:select name="jenis_kelamin" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L"
                                    {{ old('jenis_kelamin', auth('dosen')->user()->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                                    Laki-Laki</option>
                                <option value="P"
                                    {{ old('jenis_kelamin', auth('dosen')->user()->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </flux:select>
                            @error('jenis_kelamin')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Password Section -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Keamanan Akun</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <flux:input name="password" type="password" label="Password Baru"
                                placeholder="Kosongkan jika tidak ingin mengubah" />
                            @error('password')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500">Minimal 6 karakter</p>
                        </div>

                        <div class="space-y-1">
                            <flux:input name="password_confirmation" type="password" label="Konfirmasi Password Baru"
                                placeholder="Ulangi password baru" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="bg-gray-50 px-6 py-4 flex justify-between items-center">
                <div class="text-sm text-gray-500">
                    Terakhir diperbarui:
                    {{ auth('dosen')->user()->updated_at ? auth('dosen')->user()->updated_at->format('d M Y, H:i') : '-' }}
                </div>
                <div class="flex space-x-3">
                    <flux:button type="button" onclick="window.location.href='{{ route('dashboard') }}'"
                        class="bg-gray-100 text-gray-700 hover:bg-gray-200" icon="arrow-left">
                        Kembali
                    </flux:button>
                    <flux:button type="submit" class="bg-magnet-sky-teal! text-white! hover:bg-teal-700!"
                        icon="check">
                        Simpan Perubahan
                    </flux:button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Update avatar preview
                const avatar = document.querySelector('flux\\:avatar img, .flux-avatar img');
                if (avatar) {
                    avatar.src = e.target.result;
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function deletePhoto() {
        if (confirm('Apakah Anda yakin ingin menghapus foto profil?')) {
            fetch('{{ route('profile.delete-photo') }}', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update avatar to default
                        const avatar = document.querySelector('flux\\:avatar img, .flux-avatar img');
                        if (avatar) {
                            avatar.src = 'https://unavatar.io/x/Jane Doe';
                        }

                        // Hide delete button
                        const deleteBtn = document.querySelector('flux\\:button[onclick="deletePhoto()"]');
                        if (deleteBtn) {
                            deleteBtn.style.display = 'none';
                        }

                        alert('Foto berhasil dihapus');
                    } else {
                        alert('Gagal menghapus foto: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus foto');
                });
        }
    }
</script>
