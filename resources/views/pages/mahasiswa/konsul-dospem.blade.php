<?php

use function Livewire\Volt\{state, layout, mount};
use App\Models\Chat;
use App\Models\KontrakMagang;
use Illuminate\Support\Facades\Auth;

layout('components.layouts.user.main');

state([
    'messageText' => '',
    'messages' => [],
    'kontrakMagangId' => null,
    'kontrakData' => null,
    'dosenPembimbing' => null,
    'isAuthorized' => false,
    'canSendMessage' => false,
    'mahasiswaStatus' => null,
    'lastMessageId' => 0,
    'isPolling' => true,
]);

mount(function () {
    $this->initializeChat();
});

$initializeChat = function () {
    try {
        $currentUserId = Auth::id();

        // Ambil kontrak magang terbaru beserta data dosen dan mahasiswa
        $kontrak = KontrakMagang::with(['dosenPembimbing', 'mahasiswa'])
            ->where('mahasiswa_id', $currentUserId)
            ->latest()
            ->first();

        if (!$kontrak) {
            session()->flash('error', 'Anda belum memiliki kontrak magang aktif.');
            return;
        }

        // Store mahasiswa status
        $this->mahasiswaStatus = $kontrak->mahasiswa->status;

        // Allow access to chat regardless of status (for viewing history)
        $this->kontrakMagangId = $kontrak->id;
        $this->kontrakData = $kontrak;
        $this->dosenPembimbing = $kontrak->dosenPembimbing;
        $this->isAuthorized = true;

        // Only allow sending messages if status is 'sedang magang'
        $this->canSendMessage = $kontrak->mahasiswa->status === 'sedang magang';

        if (!$this->dosenPembimbing) {
            session()->flash('error', 'Dosen pembimbing tidak ditemukan.');
            return;
        }

        // Load initial messages
        $this->loadMessages();

        // Show appropriate status message
        $this->showStatusMessage();
    } catch (\Exception $e) {
        \Log::error('Error initializing chat', [
            'mahasiswa_id' => Auth::id(),
            'error' => $e->getMessage(),
        ]);
        session()->flash('error', 'Terjadi kesalahan saat memuat chat.');
    }
};

$showStatusMessage = function () {
    if (!$this->canSendMessage) {
        $statusMessage = match ($this->mahasiswaStatus) {
            'selesai magang' => 'Anda dapat melihat riwayat chat, namun tidak dapat mengirim pesan karena sudah menyelesaikan magang.',
            'menunggu' => 'Anda dapat melihat riwayat chat, namun tidak dapat mengirim pesan karena status magang masih menunggu.',
            'ditolak' => 'Anda dapat melihat riwayat chat, namun tidak dapat mengirim pesan karena magang ditolak.',
            default => 'Anda dapat melihat riwayat chat, namun tidak dapat mengirim pesan saat ini.',
        };

        session()->flash('info', $statusMessage);
    }
};

$loadMessages = function () {
    if (!$this->isAuthorized || !$this->dosenPembimbing) {
        return;
    }

    try {
        $mahasiswaId = Auth::id();
        $dosenId = $this->dosenPembimbing->id;

        // Load messages for this kontrak between mahasiswa and dosen
        $messages = Chat::where('kontrak_magang_id', $this->kontrakMagangId)
            ->where(function ($query) use ($mahasiswaId, $dosenId) {
                $query
                    ->where(function ($q) use ($mahasiswaId, $dosenId) {
                        $q->where('sender_id', $mahasiswaId)->where('receiver_id', $dosenId);
                    })
                    ->orWhere(function ($q) use ($mahasiswaId, $dosenId) {
                        $q->where('sender_id', $dosenId)->where('receiver_id', $mahasiswaId);
                    });
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $this->messages = $messages
            ->map(function ($chat) use ($mahasiswaId) {
                return [
                    'id' => $chat->id,
                    'message' => $chat->message,
                    'sender_id' => $chat->sender_id,
                    'receiver_id' => $chat->receiver_id,
                    'is_mine' => $chat->sender_id == $mahasiswaId,
                    'created_at' => $chat->created_at->format('H:i'),
                    'created_date' => $chat->created_at->format('Y-m-d'),
                    'sender_name' => $chat->sender_id == $mahasiswaId ? 'Saya' : $this->dosenPembimbing->nama,
                ];
            })
            ->toArray();

        // Update last message ID for polling
        if (!empty($this->messages)) {
            $this->lastMessageId = max(array_column($this->messages, 'id'));
        }
    } catch (\Exception $e) {
        \Log::error('Error loading messages', [
            'error' => $e->getMessage(),
            'kontrak_magang_id' => $this->kontrakMagangId,
        ]);
        $this->messages = [];
    }
};

$checkNewMessages = function () {
    if (!$this->isAuthorized || !$this->dosenPembimbing || !$this->isPolling) {
        return;
    }

    try {
        $mahasiswaId = Auth::id();
        $dosenId = $this->dosenPembimbing->id;

        // Check for new messages since last known message
        $newMessages = Chat::where('kontrak_magang_id', $this->kontrakMagangId)
            ->where('id', '>', $this->lastMessageId)
            ->where(function ($query) use ($mahasiswaId, $dosenId) {
                $query
                    ->where(function ($q) use ($mahasiswaId, $dosenId) {
                        $q->where('sender_id', $mahasiswaId)->where('receiver_id', $dosenId);
                    })
                    ->orWhere(function ($q) use ($mahasiswaId, $dosenId) {
                        $q->where('sender_id', $dosenId)->where('receiver_id', $mahasiswaId);
                    });
            })
            ->orderBy('created_at', 'asc')
            ->get();

        if ($newMessages->count() > 0) {
            // Add new messages to existing messages array
            foreach ($newMessages as $chat) {
                $this->messages[] = [
                    'id' => $chat->id,
                    'message' => $chat->message,
                    'sender_id' => $chat->sender_id,
                    'receiver_id' => $chat->receiver_id,
                    'is_mine' => $chat->sender_id == $mahasiswaId,
                    'created_at' => $chat->created_at->format('H:i'),
                    'created_date' => $chat->created_at->format('Y-m-d'),
                    'sender_name' => $chat->sender_id == $mahasiswaId ? 'Saya' : $this->dosenPembimbing->nama,
                ];
            }

            // Update last message ID
            $this->lastMessageId = $newMessages->max('id');

            // Trigger scroll to bottom for new messages
            $this->dispatch('new-message-received');
        }
    } catch (\Exception $e) {
        \Log::error('Error checking new messages', [
            'error' => $e->getMessage(),
            'kontrak_magang_id' => $this->kontrakMagangId,
        ]);
    }
};

$sendMessage = function () {
    // Double check authorization first
    if (!$this->isAuthorized) {
        session()->flash('error', 'Anda tidak memiliki akses untuk mengirim pesan.');
        return;
    }

    // Check if user can send messages based on status
    if (!$this->canSendMessage) {
        $errorMessage = match ($this->mahasiswaStatus) {
            'selesai magang' => 'Anda tidak dapat mengirim pesan karena sudah menyelesaikan magang.',
            'menunggu' => 'Anda tidak dapat mengirim pesan karena status magang masih menunggu persetujuan.',
            'ditolak' => 'Anda tidak dapat mengirim pesan karena magang ditolak.',
            default => 'Anda tidak dapat mengirim pesan pada status saat ini.',
        };

        session()->flash('error', $errorMessage);
        return;
    }

    // Validate input
    if (empty(trim($this->messageText))) {
        session()->flash('error', 'Pesan tidak boleh kosong.');
        return;
    }

    if (!$this->dosenPembimbing || !$this->kontrakMagangId) {
        session()->flash('error', 'Data tidak lengkap untuk mengirim pesan.');
        return;
    }

    try {
        $mahasiswaId = Auth::id();
        $dosenId = $this->dosenPembimbing->id;

        // Periksa ulang status mahasiswa dari database untuk memastikan konsistensi
        $kontrak = KontrakMagang::with('mahasiswa')->find($this->kontrakMagangId);
        if (!$kontrak || $kontrak->mahasiswa->status !== 'sedang magang') {
            $this->canSendMessage = false;
            $this->mahasiswaStatus = $kontrak ? $kontrak->mahasiswa->status : null;
            session()->flash('error', 'Status magang Anda telah berubah. Anda tidak dapat mengirim pesan.');
            return;
        }

        $chatData = [
            'kontrak_magang_id' => $this->kontrakMagangId,
            'sender_id' => $mahasiswaId,
            'receiver_id' => $dosenId,
            'message' => trim($this->messageText),
        ];

        // Create message
        $chat = Chat::create($chatData);

        // Add message to current messages array immediately
        $this->messages[] = [
            'id' => $chat->id,
            'message' => $chat->message,
            'sender_id' => $chat->sender_id,
            'receiver_id' => $chat->receiver_id,
            'is_mine' => true,
            'created_at' => $chat->created_at->format('H:i'),
            'created_date' => $chat->created_at->format('Y-m-d'),
            'sender_name' => 'Saya',
        ];

        // Update last message ID
        $this->lastMessageId = $chat->id;

        // Clear input
        $this->messageText = '';

        // Trigger frontend events
        $this->dispatch('focus-input');
        $this->dispatch('scroll-to-bottom');
    } catch (\Illuminate\Database\QueryException $e) {
        \Log::error('Database error when sending message', [
            'error' => $e->getMessage(),
            'kontrak_magang_id' => $this->kontrakMagangId,
        ]);
        session()->flash('error', 'Gagal mengirim pesan. Silakan coba lagi.');
    } catch (\Exception $e) {
        \Log::error('General error sending message', [
            'error' => $e->getMessage(),
            'kontrak_magang_id' => $this->kontrakMagangId,
        ]);
        session()->flash('error', 'Gagal mengirim pesan. Silakan coba lagi.');
    }
};

$refreshStatus = function () {
    try {
        $kontrak = KontrakMagang::with('mahasiswa')->find($this->kontrakMagangId);
        if ($kontrak) {
            $oldStatus = $this->mahasiswaStatus;
            $this->mahasiswaStatus = $kontrak->mahasiswa->status;
            $this->canSendMessage = $kontrak->mahasiswa->status === 'sedang magang';

            // Show message if status changed
            if ($oldStatus !== $this->mahasiswaStatus) {
                $this->showStatusMessage();
            }
        }
    } catch (\Exception $e) {
        \Log::error('Error refreshing status', [
            'error' => $e->getMessage(),
            'kontrak_magang_id' => $this->kontrakMagangId,
        ]);
    }
};

$togglePolling = function () {
    $this->isPolling = !$this->isPolling;
};

?>

<x-slot:user>mahasiswa</x-slot:user>
<div x-data="{
    isVisible: true,
    pollingInterval: null,
    statusCheckInterval: null,

    init() {
        this.startPolling();
        this.startStatusCheck();
        this.handleVisibilityChange();

        // Listen for new message events
        this.$wire.on('new-message-received', () => {
            this.scrollToBottom();
            this.showNotification();
        });

        // Listen for other events
        this.$wire.on('focus-input', () => {
            this.focusInput();
        });

        this.$wire.on('scroll-to-bottom', () => {
            this.scrollToBottom();
        });
    },

    startPolling() {
        this.pollingInterval = setInterval(() => {
            if (this.isVisible && $wire.isPolling) {
                $wire.checkNewMessages();
            }
        }, 2000); // Check every 2 seconds
    },

    startStatusCheck() {
        // Check status every 30 seconds to ensure consistency
        this.statusCheckInterval = setInterval(() => {
            $wire.refreshStatus();
        }, 30000);
    },

    stopPolling() {
        if (this.pollingInterval) {
            clearInterval(this.pollingInterval);
            this.pollingInterval = null;
        }
        if (this.statusCheckInterval) {
            clearInterval(this.statusCheckInterval);
            this.statusCheckInterval = null;
        }
    },

    handleVisibilityChange() {
        document.addEventListener('visibilitychange', () => {
            this.isVisible = !document.hidden;
            if (this.isVisible) {
                // Check for new messages and refresh status when tab becomes visible
                $wire.checkNewMessages();
                $wire.refreshStatus();
            }
        });
    },

    handleKeydown(event) {
        if (event.key === 'Enter' && !event.shiftKey) {
            event.preventDefault();
            if ($wire.canSendMessage) {
                $wire.sendMessage();
            }
        }
    },

    scrollToBottom() {
        const chatContainer = document.getElementById('chat-container');
        if (chatContainer) {
            setTimeout(() => {
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }, 100);
        }
    },

    focusInput() {
        const messageInput = document.getElementById('message-input');
        if (messageInput && $wire.canSendMessage) {
            messageInput.focus();
        }
    },

    showNotification() {
        // Only show notification if tab is not visible
        if (!this.isVisible && 'Notification' in window) {
            if (Notification.permission === 'granted') {
                new Notification('Pesan Baru', {
                    body: 'Anda menerima pesan baru dari dosen pembimbing',
                    icon: '/img/user/lecturer-man.png'
                });
            }
        }
    },

    requestNotificationPermission() {
        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission();
        }
    }
}" x-init="init()" x-on:beforeunload="stopPolling()">
    {{-- Header --}}
    <div
        class="fixed top-14 left-0 right-4 lg:left-56 backdrop-blur-md bg-white/80 border-b border-white/20 shadow-md z-40">
        <div class="flex items-center gap-4 px-6 py-4">
            <div class="relative">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 p-0.5">
                    <flux:avatar src="{{ asset('img/user/lecturer-man.png') }}"
                        class="w-full h-full rounded-full border-2 border-white" />
                </div>
                <div
                    class="absolute -bottom-1 -right-1 w-4 h-4 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full border-2 border-white shadow-sm">
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <flux:heading class="truncate font-semibold text-gray-800">
                    {{ $dosenPembimbing ? $dosenPembimbing->nama : 'Dosen Pembimbing' }}
                </flux:heading>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <flux:subheading class="text-green-600 font-medium">
                        Dosen Pembimbing
                    </flux:subheading>
                </div>
            </div>
            {{-- Status and Polling Indicator --}}
            <div class="flex items-center gap-3">
                {{-- Status Badge --}}
                @if ($mahasiswaStatus)
                    <div class="flex items-center gap-1">
                        <flux:badge :variant="$mahasiswaStatus === 'sedang magang' ? 'solid' : 'outline'"
                            class="{{ $mahasiswaStatus === 'sedang magang' ? 'bg-green-500 text-white' : 'bg-yellow-100 text-yellow-700 border-yellow-300' }}">
                            {{ ucfirst(str_replace('_', ' ', $mahasiswaStatus)) }}
                        </flux:badge>
                    </div>
                @endif

                {{-- Polling Status --}}
                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-1" x-show="$wire.isPolling" x-transition>
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-xs text-green-600 font-medium">Online</span>
                    </div>
                    <button @click="requestNotificationPermission()"
                        class="p-1 text-gray-400 hover:text-gray-600 transition-colors" title="Aktifkan notifikasi">
                        <flux:icon.bell class="w-4 h-4" />
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Chat Container --}}
    <div id="chat-container"
        class="fixed top-[140px] bottom-20 left-0 right-4 lg:left-56 overflow-y-auto z-30 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-transparent">
        <div class="px-6 py-8 space-y-6 min-h-full">
            @if (!$isAuthorized)
                {{-- Unauthorized state --}}
                <div class="flex flex-col items-center justify-center h-full text-center py-12">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-red-100 to-red-200 rounded-full flex items-center justify-center mb-4">
                        <flux:icon.exclamation-triangle class="w-8 h-8 text-red-500" />
                    </div>
                    <flux:heading class="text-red-600 mb-2">Akses Ditolak</flux:heading>
                    <flux:subheading class="text-red-500">
                        Anda tidak memiliki akses ke chat ini
                    </flux:subheading>
                </div>
            @elseif (empty($messages))
                {{-- Empty state --}}
                <div class="flex flex-col items-center justify-center h-full text-center py-12">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full flex items-center justify-center mb-4">
                        <flux:icon.chat-bubble-left-right class="w-8 h-8 text-blue-500" />
                    </div>
                    <flux:heading class="text-gray-600 mb-2">Belum ada percakapan</flux:heading>
                    <flux:subheading class="text-gray-500">
                        @if ($canSendMessage)
                            Mulai percakapan dengan dosen pembimbing Anda
                        @else
                            Belum ada riwayat percakapan dengan dosen pembimbing
                        @endif
                    </flux:subheading>
                </div>
            @else
                @php $currentDate = null; @endphp
                @foreach ($messages as $message)
                    {{-- Date Separator --}}
                    @if ($currentDate !== $message['created_date'])
                        @php $currentDate = $message['created_date']; @endphp
                        <div class="flex justify-center my-8">
                            <flux:badge variant="outline"
                                class="bg-white/90 backdrop-blur-sm border-white/20 shadow-md px-4 py-2 font-medium text-gray-700">
                                {{ \Carbon\Carbon::parse($message['created_date'])->format('d M Y') }}
                            </flux:badge>
                        </div>
                    @endif

                    {{-- Message --}}
                    <div class="message-item" x-data="{ isNew: false }" x-init="// Mark as new if this is a recent message
                    if ({{ $message['id'] }} > {{ $lastMessageId - 1 }} && !{{ $message['is_mine'] ? 'true' : 'false' }}) {
                        isNew = true;
                        setTimeout(() => isNew = false, 3000);
                    }">
                        @if ($message['is_mine'])
                            {{-- Outgoing Message (Mahasiswa) --}}
                            <div class="flex justify-end group">
                                <div class="max-w-[75%] sm:max-w-[65%]">
                                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-3xl rounded-tr-md p-4 shadow-md"
                                        :class="{ 'animate-pulse': isNew }">
                                        <p class="text-sm leading-relaxed">{{ $message['message'] }}</p>
                                    </div>
                                    <div class="flex justify-end items-center gap-2 mt-2 px-3">
                                        <span
                                            class="text-xs text-gray-500 font-medium">{{ $message['created_at'] }}</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- Incoming Message (Dosen) --}}
                            <div class="flex justify-start group">
                                <div class="max-w-[75%] sm:max-w-[65%]">
                                    <div class="bg-white/90 backdrop-blur-sm border border-white/20 rounded-3xl rounded-tl-md p-4 shadow-md"
                                        :class="{ 'ring-2 ring-blue-400 ring-opacity-75': isNew }">
                                        <p class="text-sm text-gray-800 leading-relaxed">{{ $message['message'] }}</p>
                                    </div>
                                    <div class="flex justify-start items-center gap-2 mt-2 px-3">
                                        <span
                                            class="text-xs text-gray-500 font-medium">{{ $message['sender_name'] }}</span>
                                        <span
                                            class="text-xs text-gray-500 font-medium">{{ $message['created_at'] }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    {{-- Input Area --}}
    @if ($isAuthorized)
        <div
            class="fixed bottom-0 left-0 right-4 lg:left-56 backdrop-blur-md bg-white/90 border-t border-white/20 shadow-md z-40">
            @if ($canSendMessage)
                {{-- Active Input Area --}}
                <div class="flex items-end gap-3 px-6 py-4">
                    {{-- Message Input --}}
                    <div class="flex-1 relative">
                        <flux:textarea wire:model="messageText" @keydown="handleKeydown($event)"
                            placeholder="Ketik pesan Anda..." rows="1"
                            class="w-full resize-none min-h-[48px] max-h-32 rounded-2xl border-0 bg-white/80 backdrop-blur-sm shadow-inner focus:bg-white/90 focus:ring-2 focus:ring-blue-500/50 focus:border-transparent transition-all duration-200 px-4 py-3 text-sm placeholder-gray-500"
                            id="message-input" x-ref="messageInput" x-init="$el.addEventListener('input', function() {
                                this.style.height = 'auto';
                                this.style.height = Math.min(this.scrollHeight, 128) + 'px';
                            });" />
                    </div>

                    {{-- Send Button --}}
                    <div class="flex-shrink-0">
                        <flux:button wire:click="sendMessage" variant="primary" icon="paper-airplane"
                            wire:loading.attr="disabled"
                            class="w-12 h-12 rounded-full !bg-gradient-to-r !from-blue-500 !to-blue-600 hover:!from-blue-600 hover:!to-blue-700 !text-white !shadow-md hover:!shadow-md !transition-all !duration-200" />
                    </div>
                </div>
            @else
                {{-- Disabled Input Area --}}
                <div class="flex items-center gap-3 px-6 py-4 bg-gray-50/90">
                    <div class="flex-1 relative">
                        <div
                            class="w-full min-h-[48px] rounded-2xl border border-gray-200 bg-gray-100 px-4 py-3 text-sm text-gray-500 flex items-center">
                            <flux:icon.lock-closed class="w-4 h-4 mr-2" />
                            <span>Pengiriman pesan dinonaktifkan - Status: Selesai Magang</span>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <flux:button disabled variant="outline" icon="paper-airplane"
                            class="w-12 h-12 rounded-full !bg-gray-200 !text-gray-400 !cursor-not-allowed" />
                    </div>
                </div>
            @endif
        </div>
    @endif

    {{-- Loading Indicator --}}
    <div wire:loading wire:target="sendMessage" class="fixed bottom-24 left-1/2 transform -translate-x-1/2 z-50">
        <div class="bg-blue-500 text-white px-4 py-2 rounded-full shadow-md flex items-center gap-2">
            <div class="animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent"></div>
            <span class="text-sm">Mengirim...</span>
        </div>
    </div>

    {{-- Info Message --}}
    @if (session('info'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 8000)"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed top-20 right-4 z-50 bg-blue-500 text-white px-4 py-3 rounded-md shadow-md max-w-sm">
            <div class="flex items-start gap-2">
                <flux:icon.information-circle class="w-5 h-5 mt-0.5 flex-shrink-0" />
                <span class="text-sm">{{ session('info') }}</span>
            </div>
        </div>
    @endif

    {{-- Success Message --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed top-20 right-4 z-50 bg-green-500 text-white px-4 py-2 rounded-md shadow-md">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error Message --}}
    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed top-20 right-4 z-50 bg-red-500 text-white px-4 py-2 rounded-md shadow-md">
            {{ session('error') }}
        </div>
    @endif
</div>
