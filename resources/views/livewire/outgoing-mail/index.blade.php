@section ('title', 'Surat Keluar')
<div class="container">
    <div class="mx-auto py-4 px-2">
        <div class="bg-white shadow-xl sm:rounded-lg px-4 py-3">
            <!-- @if ($formVisible)
                    @if ($formVisible === 'edit')
                    <livewire:outgoing-mail.edit />
                    @elseif ($formVisible === 'show')
                    <livewire:outgoing-mail.show />
                    @else
                    <livewire:outgoing-mail.create />
                    @endif
                    @else
                    <button wire:click="create" class="btn btn-accent">New</button>
                    @endif -->
            @if (session()->has('message'))
            <div class="alert alert-success">
                <div class="flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-6 h-6 mx-2 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                    </svg>
                    <label>{{ session('message') }}</label>
                </div>
            </div>
            @endif
            <div class="card-body">
                <div class="row">
                    <div class="flex">
                        <a href="{{route ('dashboard.outgoing-mails.create') }}" class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-500 text-base font-bold text-white shadow-sm hover:bg-light-700">
                            Tambah Data
                        </a>
                        <a href="{{route ('dashboard.inbox.index') }}" class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-500 text-base font-bold text-white shadow-sm hover:bg-light-700">
                            Inbox
                        </a>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <select wire:model="paginate" class="select select-bordered max-w-max">
                            <option>5</option>
                            <option>10</option>
                            <option>15</option>
                        </select>
                        <input wire:model="search" type="search" placeholder="Search..." class="input input-bordered">
                        <select wire:model="sort" class="select select-bordered max-w-max">
                            <option value="">Sort By Document</option>
                            @foreach ($documents as $document)
                            <option value="{{ $document->id }}">{{ $document->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="3%">No</th>
                                    <th width="10%">No. Surat</th>
                                    <th width="10%">Tgl. Surat</th>
                                    <th width="10%">Pengirim</th>
                                    <th width="10%">Perihal</th>
                                    <th width="10%">Lampiran</th>
                                    <th width="5%">Menjabat</th>
                                    <th width="5%">Jenis Document</th>
                                    <th width="22%">Arsip</th>
                                    <th width="20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($outgoingMails as $item)
                                <tr>
                                    <td class="align-baseline">{{ $loop->iteration }}</td>
                                    <td class="align-baseline">{{ $item->nomor_surat }}</td>
                                    <td class="align-baseline">{{ date('d F Y', strtotime($item->tgl_surat)) }}</td>
                                    @if ($item->pengirim == null)
                                    <td class="align-baseline">-</td>
                                    @else
                                    <td class="align-baseline">{{ $item->authUser->name }}</td>
                                    @endif
                                    <td class="align-baseline">{{ $item->perihal }}</td>
                                    <td class="align-baseline">{{ $item->lampiran ?? '-' }}</td>
                                    <td class="align-baseline">{{ $item->menjabat->name ?? '-'}}</td>
                                    <td class="align-baseline">{{ $item->document ? $item->document->name . ' - ' . $item->document->code_number : '-' }}</td>
                                    <td class="align-baseline">{{ $item->arsip }}</td>
                                    <td class="align-baseline">
                                        <div class="d-flex">
                                            @can ('outgoing-edit')
                                            <a href="{{ route ('dashboard.outgoing-mails.edit', $item->id) }}" class="btn btn-info edit">
                                                <i class="fas fa-solid fa-pen"></i>
                                            </a>
                                            @endcan

                                            <a href="{{ route ('dashboard.outgoing-mails.view-template', $item->id) }}" class="btn btn-success view">
                                                <i class="fas fa-solid fa-book"></i>
                                            </a>

                                            @can ('outgoing-delete')
                                            <button class="btn btn-error delete" data-id="{{ $item->id }}" data-nama="{{ $item->nomor_surat }}"> <i class="fas fa-solid fa-trash"></i></button>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5">Not Found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $outgoingMails->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card -->
</div>


<script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $('.delete').click(function() {
        var skid = $(this).attr('data-id');
        var sknama = $(this).attr('data-nama');
        swal({
                title: "Yakin ?",
                text: "Kamu akan menghapus data surat " + sknama + "",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.livewire.emit('destroy', skid)
                    swal("Data berhasil dihapus!", {
                        icon: "success",
                    });
                } else {
                    swal("Data tidak jadi dihapus !");
                }
            });
    });
</script>
