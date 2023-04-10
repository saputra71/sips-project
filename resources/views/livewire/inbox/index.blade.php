<div id="main-content">
    <div class="py-12">
        <div class="row"></div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-lg font-medium leading-tight mb-4 text-center bg-white p-2">INBOX
                <span><button wire:click="refreshContent" onclick="refreshContent()"><i class="fas fa-sync-alt"></i></button></span>
                <a href="{{ route('dashboard.outgoing-mails.index') }}" class="float-right text-sm p-2 bg-white">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </h1>
            <div class="mb-4 relative">
                <select wire:model="sort" class="bg-gray-200 rounded-full px-4 py-2">
                    <option value="">Sort By Document</option>
                    @foreach ($documents as $document)
                    <option value="{{ $document->id }}">{{ $document->name ?? '' }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293l-3. 3.793L. 564 5.37 7. 707z" />
                    </svg>
                </div>
                <input wire:model="search" type="text" class="bg-gray-200 rounded-full w-64 px-4 py-2 ml-2" placeholder="Search">
            </div>

            @forelse ($outgoingMails as $outgoingMail)
            @if (in_array(Auth::user()->id, ($outgoingMail->penerima)))
            <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
                <div class="flex items-center mb-4">
                    <img class="w-12 h-12 rounded-full mr-4" src="{{ $outgoingMail->authUser->profile_photo_url }}" alt="{{ $outgoingMail->authUser->name }}">
                    <div>
                        <h3 class="text-lg font-medium leading-tight">{{ $outgoingMail->document ? $outgoingMail->document->name : '' }} ({{ $outgoingMail->document ? $outgoingMail->document->code : '' }})</h3>
                        <p class="text-gray-700">{{ $outgoingMail->authUser->name }} - {{ $outgoingMail->authUser->roles->first()->name  }}</p>
                    </div>
                </div>
                <p class="mt-2 text-gray-700">Mohon di cek <a href="{{ asset('storage/' . $outgoingMail->arsip) }}" target="_blank"> <b>{{ $outgoingMail->nomor_surat }}</b> </a></p>
                <!-- <div class="mt-4">
                    <button class="bg-blue-500 text-white py-2 px-4 rounded-full">Learn More</button>
                </div> -->
                <!-- <p class="float-right text-xs text-gray-600 mt-2 mr-6">February 10, 2023</p> -->
                <p class="float-right text-xs text-gray-600 mt-2 mr-6">{{ $outgoingMail->created_at->diffForHumans() }}</p>
            </div>
            @endif
            @empty
            Tidak ada data
            @endforelse
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