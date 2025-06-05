<?php

use function Livewire\Volt\{state, mount};
use App\Models\LowonganMagang;
use App\Http\Controllers\LowonganMultiMooraController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

state(['my_state', 'debug_info', 'lowongan_data', 'categorized_data', 'numeric_data', 'ranking_results', 'error_messages', 'file_status']);

$startMCDMInternshipRecommendation = function () {
    $this->my_state = 'Processing MCDM...';
    $this->debug_info = [];
    $this->error_messages = [];
    $this->file_status = [];

    try {
        // Debug: Check if we can access the controller
        $this->debug_info[] = 'Step 1: Initializing LowonganMultiMooraController...';

        $controller = new LowonganMultiMooraController();
        $this->debug_info[] = 'Step 2: Controller initialized successfully';

        // Debug: Check database connection and data
        $this->debug_info[] = 'Step 3: Checking database connection...';

        $dataCount = \DB::table('lowongan_magang')->count();
        $this->debug_info[] = "Step 4: Found {$dataCount} records in lowongan_magang table";

        if ($dataCount == 0) {
            $this->error_messages[] = 'No data found in lowongan_magang table';
            return;
        }

        // Debug: Check if storage directory exists
        $this->debug_info[] = 'Step 5: Checking storage directories...';

        if (!Storage::disk('public')->exists('json')) {
            Storage::disk('public')->makeDirectory('json');
            $this->debug_info[] = 'Step 6: Created json directory';
        } else {
            $this->debug_info[] = 'Step 6: JSON directory already exists';
        }

        // Debug: Process the data step by step
        $this->debug_info[] = 'Step 7: Starting data processing...';

        // Call the process method and capture response
        $response = $controller->process();

        if ($response instanceof \Illuminate\Http\JsonResponse) {
            $responseData = $response->getData(true);
            if (isset($responseData['success']) && $responseData['success']) {
                $this->debug_info[] = 'Step 8: Data processed successfully';

                // Extract data from response
                if (isset($responseData['data'])) {
                    $this->lowongan_data = collect($responseData['data']['original'])->take(5); // Show first 5 for debug
                    $this->categorized_data = collect($responseData['data']['categorized'])->take(5);
                    $this->numeric_data = collect($responseData['data']['numeric'])->take(5);
                    $this->ranking_results = collect($responseData['data']['ranking'])->take(10); // Top 10 rankings
                }
            } else {
                $this->error_messages[] = 'Processing failed: ' . ($responseData['message'] ?? 'Unknown error');
            }
        }

        // Debug: Check if files were created
        $this->debug_info[] = 'Step 9: Checking generated files...';

        $files = ['lowongan_data_original.json', 'lowongan_data_categorized.json', 'lowongan_data_numeric.json', 'lowongan_ranking_results.json'];

        foreach ($files as $file) {
            $path = "json/{$file}";
            if (Storage::disk('public')->exists($path)) {
                $size = Storage::disk('public')->size($path);
                $this->file_status[$file] = "✅ Created ({$size} bytes)";
                $this->debug_info[] = "File {$file}: Created successfully ({$size} bytes)";
            } else {
                $this->file_status[$file] = '❌ Not found';
                $this->error_messages[] = "File {$file}: Not created";
            }
        }

        $this->my_state = 'MCDM Processing Complete';
        $this->debug_info[] = 'Step 10: All processing completed';
    } catch (\Exception $e) {
        $this->error_messages[] = 'Exception: ' . $e->getMessage();
        $this->error_messages[] = 'File: ' . $e->getFile() . ' Line: ' . $e->getLine();
        $this->my_state = 'Error occurred';

        // Log the error
        Log::error('MCDM Processing Error', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
        ]);
    }
};

$checkStoragePermissions = function () {
    try {
        // Test write permissions
        $testContent = json_encode(['test' => 'data', 'timestamp' => now()]);
        Storage::disk('public')->put('json/test_write.json', $testContent);

        if (Storage::disk('public')->exists('json/test_write.json')) {
            $this->debug_info[] = '✅ Storage write permissions: OK';
            Storage::disk('public')->delete('json/test_write.json'); // Clean up
        } else {
            $this->error_messages[] = '❌ Storage write permissions: FAILED';
        }
    } catch (\Exception $e) {
        $this->error_messages[] = 'Storage permission error: ' . $e->getMessage();
    }
};

$checkDatabaseTables = function () {
    try {
        $tables = ['lowongan_magang', 'lokasi_magang', 'pekerjaan', 'perusahaan', 'bidang_industri'];

        foreach ($tables as $table) {
            $count = \DB::table($table)->count();
            $this->debug_info[] = "Table {$table}: {$count} records";
        }
    } catch (\Exception $e) {
        $this->error_messages[] = 'Database check error: ' . $e->getMessage();
    }
};

mount(function () {
    $this->checkStoragePermissions();
    $this->checkDatabaseTables();
    $this->startMCDMInternshipRecommendation();
});

?>

<div>
    <div class="flex flex-col gap-8">

        <!-- Debug Panel (Remove this in production) -->
        <div class="bg-gray-100 p-4 rounded-lg">
            <h3 class="font-bold text-lg mb-4">🐛 Debug Information</h3>

            <!-- Current State -->
            <div class="mb-4">
                <strong>Current State:</strong> {{ $my_state }}
            </div>

            <!-- Debug Steps -->
            @if (count($debug_info) > 0)
                <div class="mb-4">
                    <strong>Debug Steps:</strong>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($debug_info as $info)
                            <li class="text-green-600">{{ $info }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Error Messages -->
            @if (count($error_messages) > 0)
                <div class="mb-4">
                    <strong class="text-red-600">Errors:</strong>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($error_messages as $error)
                            <li class="text-red-600">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- File Status -->
            @if (count($file_status) > 0)
                <div class="mb-4">
                    <strong>File Status:</strong>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($file_status as $file => $status)
                            <li>{{ $file }}: {!! $status !!}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Sample Data -->
            @if ($ranking_results && count($ranking_results) > 0)
                <div class="mb-4">
                    <strong>Top 3 Recommendations (Debug):</strong>
                    <div class="text-xs bg-white p-2 rounded mt-2">
                        @foreach ($ranking_results->take(3) as $rank)
                            <div class="mb-2 p-2 border rounded">
                                <strong>Lowongan ID:</strong> {{ $rank['lowongan_id'] ?? 'N/A' }}<br>
                                <strong>Total Score:</strong> {{ $rank['total_score'] ?? 'N/A' }}<br>
                                <strong>Scores:</strong>
                                L:{{ $rank['lokasi_score'] ?? 0 }}
                                R:{{ $rank['remote_score'] ?? 0 }}
                                J:{{ $rank['jenis_magang_score'] ?? 0 }}
                                P:{{ $rank['pekerjaan_score'] ?? 0 }}
                                I:{{ $rank['industri_score'] ?? 0 }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <h2 class="font-semibold leading-6 text-black w-full flex-shrink-0">
            Pemberitahuan Terbaru
        </h2>
        <div class="w-full h-40 flex-shrink-0 rounded-lg bg-white s p-4 flex flex-col justify-between shadow-lg">
            <p class="text-black text-base font-medium">
                Isi pemberitahuan terbaru
            </p>
        </div>

        <div class="w-full flex justify-center">
            <form action="{{ route('mahasiswa.hasil-pencarian') }}" method="GET" class="flex w-full justify-center">
                <flux:input type="submit" icon="magnifying-glass" name="query" class="w-1/3!"
                    placeholder="Cari Tempat Magang Yang Anda Inginkan" />
            </form>
        </div>

        <h2 class="font-extrabold leading-6 text-black w-full">Rekomendasi Tempat Magang</h2>

        <!-- Show processing status -->
        @if ($my_state !== 'a')
            <div class="bg-blue-100 p-4 rounded-lg">
                <p><strong>Status:</strong> {{ $my_state }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            @if ($ranking_results && count($ranking_results) > 0)
                <!-- Show recommendations based on MCDM results -->
                @foreach ($ranking_results->take(21) as $index => $recommendation)
                    <div onclick="window.location='{{ route('mahasiswa.detail-perusahaan') }}'" role="button"
                        class="card shadow-lg hover:cursor-pointer">
                        <div class="card-body bg-white hover:bg-gray-100 transition-colors rounded-md">
                            <div class="flex align-middle items-center gap-4">
                                <img src="{{ asset('img/company/company-kimia-farma.png') }}" alt="Logo Perusahaan"
                                    class="w-10 h-10 object-contain">
                                <p>Lowongan #{{ $recommendation['lowongan_id'] ?? 'N/A' }}</p>
                                <span class="ml-auto text-xs bg-green-100 px-2 py-1 rounded">
                                    Score: {{ $recommendation['total_score'] ?? 'N/A' }}
                                </span>
                            </div>
                            <div>
                                <p class="font-bold text-base">Recommended Position</p>
                                <p class="text-sm text-gray-600">Based on your preferences</p>
                                <p class="text-xs text-gray-500">Rank: {{ $index + 1 }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Fallback to static data -->
                @for ($i = 0; $i < 21; $i++)
                    <div onclick="window.location='{{ route('mahasiswa.detail-perusahaan') }}'" role="button"
                        class="card shadow-lg hover:cursor-pointer">
                        <div class="card-body bg-white hover:bg-gray-100 transition-colors rounded-md">
                            <div class="flex align-middle items-center gap-4">
                                <img src="{{ asset('img/company/company-kimia-farma.png') }}" alt="Logo Perusahaan"
                                    class="w-10 h-10 object-contain">
                                <p>PT. Kimia Farma</p>
                            </div>
                            <div>
                                <p class="font-bold text-base">Frontend Web Developer</p>
                                <p class="text-sm text-gray-600">Jakarta</p>
                            </div>
                        </div>
                    </div>
                @endfor
            @endif
        </div>
    </div>
</div>
