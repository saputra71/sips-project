<div>
    <div class="py-12">
        <div class="row"></div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-3">
                <div class="mb-4">
                    <b>NOTIFICATION LOG</b>
                    <span><button onclick="refreshContent()"><i class="fas fa-sync-alt"></i></button></span>
                </div>
                <div class="mb-2">
                    Today
                </div>
                <div class="main-content" id="main-content">
                    @forelse ($todayNotifications as $notification)
                    <!-- New Disposisi -->
                    @if($notification->type == 'App\Notifications\NewDispoisiNotification')
                    <div class="mb-2">
                        {{ $notification->created_at }} - {{ $notification->data['type'] }} - {{ $notification->data['status'] }} => {{ $notification->data['nomor_surat'] }}
                    </div>
                    @endif
                    <!-- Disposisi -->
                    @if($notification->type == 'App\Notifications\DisposisiNotification')
                    <div class="mb-2">
                        {{ $notification->created_at }} - {{ $notification->data['sender'] }} => {{ $notification->data['message'] }}
                    </div>
                    @endif

                    <!-- Status Disposisi -->
                    @if($notification->type == 'App\Notifications\StatusDisposisiNotification')
                    <div class="mb-2">
                        {{ $notification->created_at }} - {{ $notification->data['message'] }}
                    </div>
                    @endif

                    @empty
                    <div class="mb-2">
                        No notification
                    </div>
                    @endforelse
                    <div class="mb-2">
                        History
                    </div>
                    @forelse ($notifications as $notification)
                    <!-- New Disposisi -->
                    @if($notification->type == 'App\Notifications\NewDispoisiNotification')
                    <div class="mb-2">
                        {{ $notification->created_at }} - {{ $notification->data['type'] }} - {{ $notification->data['status'] }} - {{ $notification->data['nomor_surat'] }}
                    </div>
                    @endif
                    <!-- Disposisi -->
                    @if($notification->type == 'App\Notifications\DisposisiNotification')
                    <div class="mb-2">
                        {{ $notification->created_at }} - {{ $notification->data['sender'] }} - {{ $notification->data['message'] }}
                    </div>
                    @endif

                    <!-- Status Disposisi -->
                    @if($notification->type == 'App\Notifications\StatusDisposisiNotification')
                    <div class="mb-2">
                        {{ $notification->created_at }} - {{ $notification->data['message'] }}
                    </div>
                    @endif

                    @empty
                    <div class="mb-2">
                        No notification
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function refreshContent() {
        // if clicked then show loading then refresh content
        $('#main-content').html('<div class="mb-2">Loading...</div>');

        $('#main-content').load(location.href + ' #main-content');
    }
</script>