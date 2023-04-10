@extends ('layouts.AdminLTE.main')

@section ('title', 'Dispositions Log')

@section ('content')

<div>
    <div class="py-12">
        <div class="row"></div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-3">
                <div class="mb-4">
                    <b>DISPOSITIONS LOG</b>
                </div>
                @forelse ($dispositions as $item)
                <div class="alert shadow-lg">
                    <div>
                        <span class="badge-xs badge-error">{{ $item->status }}</span>
                        <div>
                            <h3 class="font-bold">{{ $item->Sender->name }} to {{ $item->User->name }}</h3>
                            <p>{{ $item->IngoingMail->nomor_surat }}</p>
                            <a href="{{ route('dashboard.dispositions.show', $item->id) }}" class="btn btn-primary btn-sm">Detail</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="alert shadow-lg">
                    <div>
                        <div>
                            <h3 class="font-bold">Tidak ada disposisi</h3>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection