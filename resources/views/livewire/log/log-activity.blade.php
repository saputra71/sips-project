<div>
    <div class="py-12">
        <div class="row"></div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-3">
                <div class="mb-4">
                    <b>ACTIVITY LOG</b>
                    <span><button onclick="refreshContent()"><i class="fas fa-sync-alt"></i></button></span>
                </div>
                <div class="main-content" id="main-content">   
                    <div class="mb-2">
                        @foreach($logs as $log)
                            <p>{{ $log->created_at }} - <b>{{ $log->causer->name }}</b> {{ $log->description }}  </p>
                        @endforeach
                    </div>
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