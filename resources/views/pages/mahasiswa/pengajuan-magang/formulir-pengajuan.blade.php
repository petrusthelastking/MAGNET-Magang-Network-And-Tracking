<?php

use function Livewire\Volt\{layout, rules, state, protect};

layout('components.layouts.user.main');

state([
    'mahasiswa' => auth('mahasiswa')->user(),
]);

?>

<div class="text-black flex flex-col gap-6">
    <x-slot:user>mahasiswa</x-slot:user>

    <div class="card bg-white shadow-md">
        <form action="{{ route('mahasiswa.store-pengajuan-magang') }}" method="POST" enctype="multipart/form-data"
            id="pengajuan-form" onsubmit="return handleFormSubmit(event)">
            @csrf
            <div class="card-body">
                <flux:input readonly value="{{ $mahasiswa->nama }}" type="text" label="Nama Lengkap" />
                <flux:input readonly value="{{ $mahasiswa->nim }}" type="text" label="NIM" />
                <flux:input readonly value="Teknologi Informasi" type="text" label="Jurusan" />
                <flux:input readonly value="{{ $mahasiswa->program_studi ?? '-' }}" type="text"
                    label="Program Studi" />

                <flux:field>
                    <flux:input type="file" name="cv" label="CV" accept=".pdf"
                        description="Format: PDF. Maksimal ukuran file: 2 MB." onchange="validateFile(this, 'cv')" />
                    @error('cv')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:field>

                <flux:field>
                    <flux:input type="file" name="transkrip_nilai" label="Transkrip Nilai" accept=".pdf"
                        description="Format: PDF. Maksimal ukuran file: 2 MB."
                        onchange="validateFile(this, 'transkrip_nilai')" />
                    @error('transkrip_nilai')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:field>

                <flux:field>
                    <flux:input type="file" name="portfolio" label="Portofolio (Opsional)" accept=".pdf"
                        description="Format: PDF. Maksimal ukuran file: 2 MB."
                        onchange="validateFile(this, 'portfolio')" />
                    @error('portfolio')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:field>

                <div class="card-actions flex justify-end p-5">
                    <flux:button type="button" class="bg-magnet-sky-teal! text-white!"
                        onclick="window.history.back();">
                        Kembali</flux:button>
                    <flux:modal.trigger name="confirm-form" class="mr-2">
                        <flux:button type="button" class="bg-magnet-sky-teal! text-white!"
                            onclick="validateFormBeforeModal()">Kirim</flux:button>
                    </flux:modal.trigger>

                    <flux:modal name="confirm-form" class="min-w-[22rem]">
                        <div class="space-y-6">
                            <div>
                                <flux:heading size="lg">Kirim Pengajuan Magang</flux:heading>
                                <flux:text class="mt-2">
                                    <p>Apakah anda sudah yakin ingin mengirim pengajuan magang?</p>
                                </flux:text>
                            </div>

                            <div class="flex gap-2">
                                <flux:spacer />
                                <flux:modal.close>
                                    <flux:button variant="ghost">Batal</flux:button>
                                </flux:modal.close>
                                <flux:modal.close>
                                    <flux:button type="button" onclick="submitFormWithDebug()"
                                        class="bg-magnet-sky-teal! text-white!">
                                        Ya, Kirim
                                    </flux:button>
                                </flux:modal.close>
                            </div>
                        </div>
                    </flux:modal>
                </div>
        </form>
    </div>

    <!-- Enhanced Success/Error Handling -->
    @if (session('success'))
        <script>
            console.log('Success message received:', '{{ session('success') }}');
            alert('✅ SUCCESS: {{ session('success') }}');
        </script>
    @endif

    @if (session('error'))
        <script>
            console.log('Error message received:', '{{ session('error') }}');
            alert('❌ ERROR: {{ session('error') }}');
        </script>
    @endif

    @if ($errors->any())
        <script>
            console.log('Validation errors detected:');
            let errors = '';
            let errorDetails = [];
            @foreach ($errors->all() as $error)
                console.log('Error:', '{{ $error }}');
                errors += '{{ $error }}\n';
                errorDetails.push('{{ $error }}');
            @endforeach

            console.log('All errors:', errorDetails);
            alert('❌ VALIDATION ERRORS:\n' + errors);
        </script>
    @endif

    <script>
        // File validation with debugging
        function validateFile(input, fieldName) {
            console.log(`File selected for ${fieldName}:`, input.files[0]);

            const debugDiv = document.getElementById('file-debug');
            const statusDiv = document.getElementById('file-status');

            if (input.files[0]) {
                const file = input.files[0];
                const fileInfo = {
                    name: file.name,
                    size: file.size,
                    type: file.type,
                    lastModified: new Date(file.lastModified).toISOString()
                };

                console.log(`File info for ${fieldName}:`, fileInfo);

                // Show debug info
                debugDiv.classList.remove('hidden');
                statusDiv.innerHTML +=
                    `<p><strong>${fieldName}:</strong> ${file.name} (${(file.size/1024/1024).toFixed(2)} MB)</p>`;

                // Validate file size (2MB limit)
                if (file.size > 2 * 1024 * 1024) {
                    alert(`❌ File ${file.name} terlalu besar! Maksimal 2MB.`);
                    input.value = '';
                    return false;
                }

                // Validate file type
                if (file.type !== 'application/pdf') {
                    alert(`❌ File ${file.name} bukan PDF! Hanya file PDF yang diperbolehkan.`);
                    input.value = '';
                    return false;
                }

                console.log(`✅ File ${fieldName} valid`);
            }
            return true;
        }

        // Form validation before showing modal
        function validateFormBeforeModal() {
            console.log('Validating form before modal...');

            const cvFile = document.querySelector('input[name="cv"]').files[0];
            const transkripFile = document.querySelector('input[name="transkrip_nilai"]').files[0];

            if (!cvFile) {
                alert('❌ CV harus diupload!');
                return false;
            }

            if (!transkripFile) {
                alert('❌ Transkrip nilai harus diupload!');
                return false;
            }

            // Update modal with file info
            const modalInfo = document.getElementById('modal-file-info');
            modalInfo.innerHTML = `
                <br>CV: ${cvFile.name} (${(cvFile.size/1024/1024).toFixed(2)} MB)
                <br>Transkrip: ${transkripFile.name} (${(transkripFile.size/1024/1024).toFixed(2)} MB)
            `;

            console.log('✅ Form validation passed');
            return true;
        }

        // Enhanced form submission with debugging
        function submitFormWithDebug() {
            console.log('=== FORM SUBMISSION DEBUG ===');

            const form = document.getElementById('pengajuan-form');
            const formData = new FormData(form);

            console.log('Form action:', form.action);
            console.log('Form method:', form.method);
            console.log('Form encoding:', form.enctype);

            // Log all form data
            console.log('Form data contents:');
            for (let [key, value] of formData.entries()) {
                if (value instanceof File) {
                    console.log(`${key}:`, {
                        name: value.name,
                        size: value.size,
                        type: value.type
                    });
                } else {
                    console.log(`${key}:`, value);
                }
            }

            // Show loading indicator
            const submitBtn = event.target;
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Mengirim...';
            submitBtn.disabled = true;

            console.log('Submitting form...');

            // Submit the form
            form.submit();
        }

        // Alternative: Handle form submission event
        function handleFormSubmit(event) {
            console.log('Form submit event triggered');
            console.log('Event target:', event.target);
            console.log('Timestamp:', new Date().toISOString());

            // Let the form submit normally
            return true;
        }

        // Debug: Monitor for any JavaScript errors
        window.onerror = function(msg, url, lineNo, columnNo, error) {
            console.error('JavaScript Error:', {
                message: msg,
                source: url,
                line: lineNo,
                column: columnNo,
                error: error
            });
            return false;
        };

        // Debug: Log when page is about to unload
        window.addEventListener('beforeunload', function(e) {
            console.log('Page unloading at:', new Date().toISOString());
        });
    </script>
</div>
