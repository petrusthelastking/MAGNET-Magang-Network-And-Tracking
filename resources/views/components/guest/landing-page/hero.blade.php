<section class="lg:min-h-screen px-4 sm:px-6 lg:px-8 pt-6 mb-10 sm:mb-10 flex justify-around items-start">
    <div class="container mx-auto">
        <div
            class="bg-gradient-to-br from-magnet-deep-ocean-blue via-blue-900 to-magnet-deep-ocean-blue text-white rounded-2xl pb-32 sm:pb-48 lg:pb-72">
            <div class="navbar px-5 py-0">
                <div class="navbar-start">
                    <a href="/" class="text-white flex items-center gap-2">
                        <flux:icon.magnet class="rotate-180" />
                        MAGNET
                    </a>
                </div>
                <div class="navbar-center hidden lg:flex">
                    <ul class="menu menu-horizontal px-1 flex">
                        <flux:button variant="ghost" class="text-white!" href="#petunjuk">Pedoman Magang</flux:button>
                        <flux:button variant="ghost" class="text-white!" href="#kendala">FAQ</flux:button>
                        <flux:button variant="ghost" class="text-white!" href="#about">Tentang Kami</flux:button>
                    </ul>
                </div>
                <div class="navbar-end">
                    <img src="{{ asset('img/logo/jti.png') }}" alt="" class="w-10">
                </div>
            </div>

            <div class="text-center pt-6 sm:pt-8 px-4">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-medium mb-4 sm:mb-6 italic">
                    Langkah Awal Kariermu<br>Dimulai Di Sini!
                </h1>
                <p class="max-w-xs sm:max-w-md mx-auto text-center text-xs sm:text-sm text-white mb-4 sm:mb-6 px-2">
                    Magang nggak harus ribet. Cukup sesuaikan minatmu, dan kami bantu carikan yang paling cocok buat
                    kamu!
                </p>
                <flux:button
                    class="text-black! bg-white! rounded-full! hover:bg-gray-200 border-0 text-xs sm:text-sm px-4 py-2 sm:px-6 sm:py-3"
                    href="{{ route('login') }}" wire:navigate>
                    <span class="hidden sm:inline">Cari tempat magang impianmu Sekarang</span>
                    <span class="sm:hidden">Cari Magang Sekarang</span>
                </flux:button>
            </div>

        </div>

        <!-- Floating Cards -->
        <div
            class="bg-white rounded-lg p-4 sm:p-6 lg:p-8 shadow-lg -mt-24 sm:-mt-40 lg:-mt-64 relative z-10 mx-16 sm:mx-24 md:mx-32 lg:mx-72">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                <!-- Card 1 - Selalu tampil -->
                <div
                    class="rounded-lg h-60 w-48 md:h-72 md:w-full flex justify-center items-center overflow-hidden mx-auto relative photo-container">
                    <img src="{{ asset('img/card/man-1.png') }}" alt="Mobile Development"
                        class="object-cover w-full h-full photo-card active" data-set="1">
                    <img src="{{ asset('img/card/man-4.png') }}" alt="Backend Development"
                        class="object-cover w-full h-full photo-card" data-set="2">
                    <!-- Job Label -->
                    <div class="job-label absolute bottom-4 left-4 right-4 text-white p-3 rounded-lg">
                        <h3 class="font-semibold text-sm job-title">Mobile Developer</h3>
                        <p class="text-xs opacity-80 job-desc">iOS & Android</p>
                    </div>
                </div>
                <!-- Card 2 - Tampil mulai md -->
                <div class="rounded-lg h-72 justify-center items-center overflow-hidden hidden md:flex relative photo-container">
                    <img src="{{ asset('img/card/man-2.png') }}" alt="UI UX" 
                        class="object-cover w-full h-full photo-card active" data-set="1">
                    <img src="{{ asset('img/card/man-5.jpg') }}" alt="Frontend Developer"
                        class="object-cover w-full h-full photo-card" data-set="2">
                    <!-- Job Label -->
                    <div class="job-label absolute bottom-4 left-4 right-4 text-white p-3 rounded-lg">
                        <h3 class="font-semibold text-sm job-title">UI/UX Designer</h3>
                        <p class="text-xs opacity-80 job-desc">User Experience</p>
                    </div>
                </div>
                <!-- Card 3 - Tampil mulai lg -->
                <div class="rounded-lg h-72 justify-center items-center overflow-hidden hidden lg:flex relative photo-container">
                    <img src="{{ asset('img/card/woman-1.png') }}" alt="Security Engineer"
                        class="object-cover w-full h-full photo-card active" data-set="1">
                    <img src="{{ asset('img/card/woman-2.png') }}" alt="Data Analyst"
                        class="object-cover w-full h-full photo-card" data-set="2">
                    <!-- Job Label -->
                    <div class="job-label absolute bottom-4 left-4 right-4 text-white p-3 rounded-lg">
                        <h3 class="font-semibold text-sm job-title">Security Engineer</h3>
                        <p class="text-xs opacity-80 job-desc">Cybersecurity</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Styles untuk transisi foto dan label -->
<style>
    .photo-container {
        position: relative;
    }
    
    .photo-card {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        opacity: 0;
        transition: opacity 0.8s ease-in-out;
    }
    
    .photo-card.active {
        opacity: 1;
    }
    

    
    .job-title, .job-desc {
        transition: all 0.3s ease;
    }
</style>

<!-- Script untuk transisi foto otomatis -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Konfigurasi pekerjaan untuk setiap set
        const jobSets = [
            {
                jobs: ['Mobile Developer', 'UI/UX Designer', 'Security Engineer'],
                descriptions: ['iOS & Android', 'User Experience', 'Cybersecurity']
            },
            {
                jobs: ['Backend Developer', 'Frontend Developer', 'Data Analyst'],
                descriptions: ['Server & Database', 'User Interface', 'Data Science']
            }
        ];

        let currentSet = 1;
        let isTransitioning = false;

        function switchPhotoSet() {
            if (isTransitioning) return;
            
            isTransitioning = true;
            
            // Tentukan set berikutnya
            const nextSet = currentSet === 1 ? 2 : 1;
            
            // Get semua container foto
            const containers = document.querySelectorAll('.photo-container');
            
            containers.forEach((container, index) => {
                // Fade out foto aktif
                const activePhoto = container.querySelector('.photo-card.active');
                if (activePhoto) {
                    activePhoto.classList.remove('active');
                }
                
                // Fade in foto berikutnya
                setTimeout(() => {
                    const nextPhoto = container.querySelector(`[data-set="${nextSet}"]`);
                    if (nextPhoto) {
                        nextPhoto.classList.add('active');
                    }
                    
                    // Update label pekerjaan
                    const jobTitle = container.querySelector('.job-title');
                    const jobDesc = container.querySelector('.job-desc');
                    
                    if (jobTitle && jobDesc && jobSets[nextSet - 1]) {
                        jobTitle.textContent = jobSets[nextSet - 1].jobs[index];
                        jobDesc.textContent = jobSets[nextSet - 1].descriptions[index];
                    }
                }, 400);
            });
            
            // Update current set
            setTimeout(() => {
                currentSet = nextSet;
                isTransitioning = false;
            }, 1500);
        }

        // Mulai rotasi foto setiap 5 detik
        setInterval(switchPhotoSet, 1500);
    });
</script>