<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-3">
            <h1 class="text-2xl font-black text-gray-800 py-4">Tambah Surat Masuk</h1>
            <a href="{{ route('data.export') }}" class="btn btn-success">Export</a>
            @if (session()->has('message'))
            <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
                <div class="flex">
                    <div>
                        <p class="text-sm">{{ session('message') }}</p>
                    </div>
                </div>
            </div>
            @endif
            @can ('ingoing-create')
            <button wire:click="create()" class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-500 text-base font-bold text-white shadow-sm hover:bg-light-700">
                Tambah +
            </button>
            @endcan

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
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th width="3%"></th>
                            <th width="10%">No. Surat</th>
                            <th width="10%">Tgl. Surat</th>
                            <th width="10%">Tgl. Terima</th>
                            <th width="10%">Pengirim</th>
                            <th width="10%">Perihal</th>
                            <th width="5%">Klasifikasi</th>
                            <th width="22%">Arsip</th>
                            <th width="20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ingoingMails as $ingoingMail)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $ingoingMail->nomor_surat }}</td>
                            <td>{{ date('d F Y', strtotime($ingoingMail->tgl_surat)) }}</td>
                            <td>{{ date('d F Y', strtotime($ingoingMail->tgl_terima)) }}</td>
                            <td>{{ $ingoingMail->pengirim }}</td>
                            <td>{{ $ingoingMail->perihal }}</td>
                            <td>{{ $ingoingMail->document ? $ingoingMail->document->name : '-' }}</td>
                            <td>{{ $ingoingMail->arsip }}</td>
                            <td class="align-baseline">
                                <div class="d-flex">
                                    @can ('ingoing-edit')
                                    <button wire:click="edit({{ $ingoingMail->id }})" class="btn btn-info mr-2 edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @endcan

                                    @can ('ingoing-dispos')
                                    <a href="{{ route ('dashboard.ingoing-mails.show', $ingoingMail->id) }}" class="btn btn-success mr-2 disposisi">
                                        <i class="fas fa-file-alt"></i>
                                    </a>
                                    @endcan

                                    @can ('ingoing-delete')
                                    <button class="btn btn-error delete" data-id="{{ $ingoingMail->id }}" data-nama="{{ $ingoingMail->nomor_surat }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
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
                {{ $ingoingMails->links() }}
            </div>
        </div>
    </div>
    <x-jet-dialog-modal wire:model="isModal">
        <x-slot name="title">
            {{ __('Create') }}
        </x-slot>

        <x-slot name="content">
            <form enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Nomor Surat:</label>
                    <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Nomor Surat" wire:model="nomor_surat">
                    @error('nomor_surat') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Surat:</label>
                    <input type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Tanggal Surat" wire:model="tgl_surat">
                    @error('tgl_surat') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Terima:</label>
                    <input type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Tanggal Terima" wire:model="tgl_terima">
                    @error('tgl_terima') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Pengirim:</label>
                    <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Pengirim" wire:model="pengirim">
                    @error('pengirim') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Lampiran:</label>
                    <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Lampiran" wire:model="lampiran">
                    @error('lampiran') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Perihal:</label>
                    <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Perihal" wire:model="perihal">
                    @error('perihal') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Perihal:</label>
                    <select wire:model="document_id" class="select select-bordered w-full max-w-xs">
                        <option>-- Jenis Dokumen --</option>
                        @foreach ($documents as $doc)
                        <option value="{{ $doc->id }}">{{ $doc->name }}</option>
                        @endforeach
                    </select>
                    @error('jabatan')
                    <p class="text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Arsip:
                        <span class="text-xs text-gray-500">Max 20MB</span>
                    </label>
                    <input type="file" wire:model="arsip" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">

                    @error('arsip')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="closeModal()" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click.prevent="store()" wire:loading.attr="enabled">
                {{ __('Save') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
    <x-jet-dialog-modal wire:model="editModal">
        <x-slot name="title">
            {{ __('Create') }}
        </x-slot>

        <x-slot name="content">
            <div class="mb-4">
                <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Nomor Surat:</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Nomor Surat" wire:model="nomor_surat">
                @error('nomor_surat') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>
            <div class="mb-4">
                <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Surat:</label>
                <input type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Tanggal Surat" wire:model="tgl_surat">
                @error('tgl_surat') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>
            <div class="mb-4">
                <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Terima:</label>
                <input type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Tanggal Terima" wire:model="tgl_terima">
                @error('tgl_terima') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>
            <div class="mb-4">
                <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Pengirim:</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Pengirim" wire:model="pengirim">
                @error('pengirim') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>
            <div class="mb-4">
                <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Lampiran:</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Lampiran" wire:model="lampiran">
                @error('lampiran') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>
            <div class="mb-4">
                <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Perihal:</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Perihal" wire:model="perihal">
                @error('perihal') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>
            <div class="mb-4">
                <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Perihal:</label>
                <select wire:model="document_id" class="select select-bordered w-full max-w-xs">
                    <option>-- Jenis Dokumen --</option>
                    @foreach ($documents as $doc)
                    <option value="{{ $doc->id }}">{{ $doc->name }}</option>
                    @endforeach
                </select>
                @error('document_id')
                <p class="text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Download File:</label>
                <a href="{{ asset('storage/' . $arsip) }}" target="_blank" class="text-blue-500">{{ $arsip }}</a>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="closeModal()" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click.prevent="update()" wire:loading.attr="enabled">
                {{ __('Save') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $('.delete').click(function() {
        var pegawaiid = $(this).attr('data-id');
        var pegawainama = $(this).attr('data-nama');
        swal({
                title: "Yakin?",
                text: "Kamu akan menghapus data surat " + pegawainama + "",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.livewire.emit('destroy', pegawaiid)
                    swal("Data berhasil dihapus!", {
                        icon: "success",
                    });
                } else {
                    swal("Data tidak jadi dihapus !");
                }
            });
    });

    window.addEventListener('swal:modal', event => {
        swal({
            title: event.detail.message,
            text: event.detail.text,
            icon: event.detail.type,
        });
    });
</script>