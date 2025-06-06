<div class="space-y-6">
    <flux:breadcrumbs class="mb-6">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('profile') }}" class="text-gray-600">Profil Anda</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Banner Notification System -->
    <div id="notification-banner"
        class="hidden fixed top-4 left-1/2 transform -translate-x-1/2 z-50 max-w-md w-full mx-4">
        <div id="notification-content" class="rounded-lg shadow-lg border p-4 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg id="notification-icon" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <!-- Icon will be updated by JavaScript -->
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <p id="notification-title" class="text-sm font-medium"></p>
                    <p id="notification-message" class="text-sm mt-1"></p>
                </div>
                <div class="ml-4 flex-shrink-0">
                    <button type="button" onclick="closeBanner()"
                        class="inline-flex text-gray-400 hover:text-gray-600 focus:outline-none">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Photo Confirmation Modal -->
    <flux:modal name="delete-photo-modal" class="md:w-96">
        <div class="space-y-6">
            <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 rounded-full bg-red-100">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                    </path>
                </svg>
            </div>
            <div class="text-center">
                <flux:heading size="lg">Hapus Foto Profil</flux:heading>
                <flux:text class="mt-2 text-gray-600">Apakah Anda yakin ingin menghapus foto profil? Tindakan ini tidak
                    dapat dibatalkan.</flux:text>
            </div>
            <div class="flex space-x-3">
                <flux:modal.close>
                    <flux:button variant="ghost" class="flex-1">Batal</flux:button>
                </flux:modal.close>
                <flux:modal.close>
                    <flux:button onclick="confirmDeletePhoto()" variant="danger" class="flex-1" id="confirm-delete-btn">
                        Hapus Foto
                    </flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Header Section with Centered Avatar -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-8">
                <!-- Centered Photo Section -->
                <div class="flex flex-col items-center space-y-4">

                    <!-- Avatar -->
                    <div class="relative">
                        <div class="w-32 h-32 rounded-full ring-4 ring-white shadow-lg overflow-hidden bg-gray-200">
                            <img id="avatar-preview"
                                src="{{ auth('dosen')->user()->foto ? asset('foto_dosen/' . auth('dosen')->user()->foto) : asset('img/user/lecturer-man.png') }}"
                                alt="Profile Photo" class="w-full h-full object-cover" />
                        </div>
                        <div class="absolute bottom-2 right-2 w-6 h-6 bg-green-400 border-2 border-white rounded-full">
                        </div>
                    </div>
                    <!-- User Info Header -->
                    <div class="text-center mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-1">{{ auth('dosen')->user()->nama }}</h2>
                        <p class="text-sm text-gray-600 mb-2">NIDN: {{ auth('dosen')->user()->nidn }}</p>
                        <div class="flex items-center justify-center">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="w-1.5 h-1.5 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3" />
                                </svg>
                                Aktif
                            </span>
                        </div>
                    </div>

                    <!-- Photo Upload Controls -->
                    <div class="flex flex-col items-center space-y-3">
                        <div class="flex items-center space-x-3">
                            <label for="foto-input"
                                class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 transition-colors">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Ganti Foto
                                <input type="file" id="foto-input" name="foto"
                                    accept="image/jpeg,image/png,image/jpg" class="sr-only"
                                    onchange="previewImage(this)">
                            </label>

                            <flux:modal.trigger name="delete-photo-modal">
                                <flux:button variant="danger" id="delete-photo-btn"
                                    style="display: {{ auth('dosen')->user()->foto ? 'flex' : 'none' }}"
                                    class="inline-flex items-center">
                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                    Hapus Foto
                                </flux:button>
                            </flux:modal.trigger>
                        </div>

                        <div class="text-center">
                            <p class="text-xs text-gray-500">Format: JPG, PNG. Maksimal 2MB.</p>
                            @error('foto')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
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
                            <p class="text-xs text-gray-500">Minimal 8 karakter</p>
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
    // Global variable to track current image state
    let currentImageSrc =
        '{{ auth('dosen')->user()->foto ? asset('foto_dosen/' . auth('dosen')->user()->foto) : asset('img/user/lecturer-man.png') }}';
    let hasPhoto = {{ auth('dosen')->user()->foto ? 'true' : 'false' }};
    let bannerTimeout;

    // Banner Notification System
    function showBanner(type, title, message) {
        const banner = document.getElementById('notification-banner');
        const content = document.getElementById('notification-content');
        const icon = document.getElementById('notification-icon');
        const titleEl = document.getElementById('notification-title');
        const messageEl = document.getElementById('notification-message');

        // Set content
        titleEl.textContent = title;
        messageEl.textContent = message;

        // Clear any existing timeout
        if (bannerTimeout) {
            clearTimeout(bannerTimeout);
        }

        // Set icon and colors based on type
        if (type === 'success') {
            content.className =
                'rounded-lg shadow-lg border p-4 transition-all duration-300 bg-green-50 border-green-200';
            titleEl.className = 'text-sm font-medium text-green-800';
            messageEl.className = 'text-sm mt-1 text-green-700';
            icon.className = 'h-5 w-5 text-green-400';
            icon.innerHTML =
                '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />';
        } else if (type === 'error') {
            content.className = 'rounded-lg shadow-lg border p-4 transition-all duration-300 bg-red-50 border-red-200';
            titleEl.className = 'text-sm font-medium text-red-800';
            messageEl.className = 'text-sm mt-1 text-red-700';
            icon.className = 'h-5 w-5 text-red-400';
            icon.innerHTML =
                '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />';
        } else if (type === 'warning') {
            content.className =
                'rounded-lg shadow-lg border p-4 transition-all duration-300 bg-yellow-50 border-yellow-200';
            titleEl.className = 'text-sm font-medium text-yellow-800';
            messageEl.className = 'text-sm mt-1 text-yellow-700';
            icon.className = 'h-5 w-5 text-yellow-400';
            icon.innerHTML =
                '<path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />';
        } else if (type === 'info') {
            content.className =
                'rounded-lg shadow-lg border p-4 transition-all duration-300 bg-blue-50 border-blue-200';
            titleEl.className = 'text-sm font-medium text-blue-800';
            messageEl.className = 'text-sm mt-1 text-blue-700';
            icon.className = 'h-5 w-5 text-blue-400';
            icon.innerHTML =
                '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />';
        }

        // Show banner with animation
        banner.classList.remove('hidden');
        setTimeout(() => {
            banner.style.transform = 'translateX(-50%) translateY(0)';
        }, 10);

        // Auto hide after 10 seconds
        bannerTimeout = setTimeout(() => {
            closeBanner();
        }, 10000);
    }

    function closeBanner() {
        const banner = document.getElementById('notification-banner');
        banner.style.transform = 'translateX(-50%) translateY(-100%)';

        setTimeout(() => {
            banner.classList.add('hidden');
        }, 300);

        if (bannerTimeout) {
            clearTimeout(bannerTimeout);
        }
    }

    // Check for Laravel session messages and show notifications
    @if (session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            const message = '{{ session('success') }}';
            // Check if the message indicates no changes
            if (message.includes('Tidak ada perubahan') || message.includes('tidak ada perubahan')) {
                showBanner('info', 'Informasi', message);
            } else {
                showBanner('success', 'Berhasil!', message);
            }
        });
    @endif

    @if (session('error'))
        document.addEventListener('DOMContentLoaded', function() {
            showBanner('error', 'Terjadi Kesalahan!', '{{ session('error') }}');
        });
    @endif

    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            const errorMessages = [];
            @foreach ($errors->all() as $error)
                errorMessages.push('{{ $error }}');
            @endforeach

            if (errorMessages.length === 1) {
                showBanner('error', 'Terjadi Kesalahan!', errorMessages[0]);
            } else {
                showBanner('error', 'Terjadi Kesalahan!',
                    'Silakan periksa form dan perbaiki kesalahan yang ada.');
            }
        });
    @endif

    // Enhanced image preview function
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];

            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!allowedTypes.includes(file.type)) {
                showBanner('error', 'Format Tidak Valid!', 'Harap pilih file dengan format JPG, PNG, atau JPEG');
                input.value = ''; // Clear the input
                return;
            }

            // Validate file size (2MB = 2097152 bytes)
            if (file.size > 2097152) {
                showBanner('error', 'File Terlalu Besar!', 'Ukuran file tidak boleh lebih dari 2MB');
                input.value = ''; // Clear the input
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const avatar = document.getElementById('avatar-preview');
                const deleteBtn = document.getElementById('delete-photo-btn');

                if (avatar) {
                    avatar.src = e.target.result;
                }

                // Show delete button since we now have an image
                if (deleteBtn) {
                    const triggerContainer = deleteBtn.closest('flux\\:modal\\:trigger');
                    if (triggerContainer) {
                        triggerContainer.style.display = 'flex';
                    } else {
                        deleteBtn.style.display = 'flex';
                    }
                }

                // Update tracking variables
                currentImageSrc = e.target.result;
                hasPhoto = true;

                showBanner('success', 'Foto Dipilih!',
                    'Jangan lupa klik "Simpan Perubahan" untuk menyimpan foto baru.');
            }
            reader.readAsDataURL(file);
        }
    }

    // Form submission handler to prevent unnecessary submissions
    function handleFormSubmit(event) {
        const form = event.target;
        const formData = new FormData(form);

        // Get current values
        const currentData = {
            nama: '{{ old('nama', auth('dosen')->user()->nama) }}',
            nidn: '{{ old('nidn', auth('dosen')->user()->nidn) }}',
            jenis_kelamin: '{{ old('jenis_kelamin', auth('dosen')->user()->jenis_kelamin) }}'
        };

        // Check if anything has actually changed
        let hasChanges = false;

        // Check basic fields
        if (formData.get('nama') !== currentData.nama ||
            formData.get('nidn') !== currentData.nidn ||
            formData.get('jenis_kelamin') !== currentData.jenis_kelamin) {
            hasChanges = true;
        }

        // Check password
        if (formData.get('password') && formData.get('password').trim() !== '') {
            hasChanges = true;
        }

        // Check photo
        if (formData.get('foto') && formData.get('foto').size > 0) {
            hasChanges = true;
        }

        // If no changes, show info message and prevent submission
        if (!hasChanges) {
            event.preventDefault();
            showBanner('info', 'Tidak Ada Perubahan', 'Tidak ada data yang diubah untuk disimpan.');
            return false;
        }

        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML =
                '<svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Menyimpan...';

            // Reset button after 30 seconds as fallback
            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }, 30000);
        }

        return true;
    }

    // Confirm delete photo function called from modal
    function confirmDeletePhoto() {
        // Show loading state
        const confirmBtn = document.getElementById('confirm-delete-btn');
        const originalText = confirmBtn.innerHTML;
        confirmBtn.disabled = true;
        confirmBtn.innerHTML =
            '<svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Menghapus...';

        fetch('{{ route('profile.delete-photo') }}', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Update avatar to default
                    const avatar = document.getElementById('avatar-preview');
                    const deleteBtn = document.getElementById('delete-photo-btn');
                    const photoInput = document.getElementById('foto-input');

                    if (avatar) {
                        avatar.src = '{{ asset('img/user/lecturer-man.png') }}';
                    }

                    // Hide delete button (the trigger container)
                    if (deleteBtn && deleteBtn.closest('flux\\:modal\\:trigger')) {
                        deleteBtn.closest('flux\\:modal\\:trigger').style.display = 'none';
                    } else if (deleteBtn) {
                        deleteBtn.style.display = 'none';
                    }

                    // Clear file input
                    if (photoInput) {
                        photoInput.value = '';
                    }

                    // Update tracking variables
                    currentImageSrc = '{{ asset('img/user/lecturer-man.png') }}';
                    hasPhoto = false;

                    // Close modal and show success message
                    closeModal();
                    showBanner('success', 'Berhasil!', data.message || 'Foto profil berhasil dihapus');
                } else {
                    showBanner('error', 'Gagal!', data.message || 'Gagal menghapus foto');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showBanner('error', 'Kesalahan!', 'Terjadi kesalahan saat menghapus foto. Silakan coba lagi.');
            })
            .finally(() => {
                // Restore button state
                confirmBtn.disabled = false;
                confirmBtn.innerHTML = originalText;
            });
    }

    // Helper function to close modal
    function closeModal() {
        const modal = document.querySelector('[name="delete-photo-modal"]');
        if (modal && modal.close) {
            modal.close();
        }
    }

    // Reset form function
    function resetPhotoPreview() {
        const avatar = document.getElementById('avatar-preview');
        const deleteBtn = document.getElementById('delete-photo-btn');
        const photoInput = document.getElementById('foto-input');

        if (avatar) {
            avatar.src = currentImageSrc;
        }

        if (deleteBtn) {
            const triggerContainer = deleteBtn.closest('flux\\:modal\\:trigger');
            if (triggerContainer) {
                triggerContainer.style.display = hasPhoto ? 'flex' : 'none';
            } else {
                deleteBtn.style.display = hasPhoto ? 'flex' : 'none';
            }
        }

        if (photoInput) {
            photoInput.value = '';
        }
    }

    // Add event listeners when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('reset', resetPhotoPreview);
            form.addEventListener('submit', handleFormSubmit);
        }
    });
</script>
