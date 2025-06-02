<x-layouts.user.main user="mahasiswa">
    <div class="w-full bg-white rounded-lg overflow-hidden flex flex-col h-full">
        <div class="flex items-center justify-between p-4 bg-white border-b border-gray-200 shadow-sm z-10">
            <div class="flex items-center">
                <div class="ml-3">
                    <p class="font-semibold text-gray-800">Prof. Dr. Mulyono, S.H., M.Kom.</p>
                </div>
            </div>
        </div>

        <div id="chat-messages" class="flex-1 p-4 overflow-y-auto custom-scrollbar">
            <div class="text-center text-xs text-gray-500 my-4">69 Dec 2069</div>

            <div class="flex justify-start mb-4">
                <div class="bg-white rounded-lg p-3 shadow-sm max-w-[calc(100%-60px)]">
                    <p class="text-base text-gray-800">P byone</p>
                    <p class="text-right text-xs text-gray-400 mt-2">11:18</p>
                </div>
            </div>

            <div class="flex justify-end mb-4">
                <div class="bg-blue-100 rounded-lg p-3 shadow-sm max-w-[calc(100%-60px)]">
                    <p class="text-base text-gray-800">Shareloc tak parani!</p>
                    <p class="text-right text-xs text-gray-500 mt-2">11:21</p>
                </div>
            </div>
            <div class="flex justify-end mb-4">
                <div class="bg-blue-100 rounded-lg p-3 shadow-sm max-w-[calc(100%-60px)]">
                    <p class="text-base text-gray-800">Aku ijen</p>
                    <p class="text-right text-xs text-gray-500 mt-2">11:21</p>
                </div>
            </div>
            <div class="flex justify-end mb-4">
                <div class="bg-blue-100 rounded-lg p-3 shadow-sm max-w-[calc(100%-60px)]">
                    <p class="text-base text-gray-800">P</p>
                    <p class="text-right text-xs text-gray-500 mt-2">11:21</p>
                </div>
            </div>
            <div class="flex justify-end mb-4">
                <div class="bg-blue-100 rounded-lg p-3 shadow-sm max-w-[calc(100%-60px)]">
                    <p class="text-base text-gray-800">P</p>
                    <p class="text-right text-xs text-gray-500 mt-2">11:21</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-3 border-t border-gray-200 flex items-center">
            <i class="fas fa-smile text-xl text-gray-500 mr-3 cursor-pointer"></i>
            <input type="text" placeholder="Tulis Pesan..."
                class="flex-1 p-2 rounded-full bg-gray-100 border border-gray-200 text-gray-800 focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400"
                id="message-input">
            <i class="fas fa-plus-circle text-xl text-gray-500 mx-3 cursor-pointer"></i>
            <flux:button class="bg-magnet-sky-teal! text-white!" icon="send"></flux:button>
        </div>
    </div>
</x-layouts.user.main>
