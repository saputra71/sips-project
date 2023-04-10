<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-3">
            <h1 class="text-2xl font-black text-gray-800 py-4">Tambah Klasifikasi Surat</h1>
            @if (session()->has('message'))
            <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
                <div class="flex">
                    <div>
                        <p class="text-sm">{{ session('message') }}</p>
                    </div>
                </div>
            </div>
            @endif
            <button wire:click="create()" class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-500 text-base font-bold text-white shadow-sm hover:bg-light-700">
                Tambah +
            </button>

            <div class="grid grid-cols-2 gap-2">
                <select wire:model="paginate" class="select select-bordered max-w-max">
                    <option>5</option>
                    <option>10</option>
                    <option>15</option>
                </select>
                <input wire:model="search" type="search" placeholder="Search..." class="input input-bordered">
            </div>
            <table class="table w-full mt-2">
                <thead>
                    <tr class="bg-gray-100">
                        <th class=" w-20"></th>
                        <th class="">Name</th>
                        <th class="">Klasifikasi</th>
                        <th class="">Number</th>
                        <th class="">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($docs as $e)
                    <tr>
                        <th class="align-baseline">{{ $loop->iteration }}</th>
                        <td class="align-baseline">{{ $e->name }}</td>
                        <td class="align-baseline">{{ $e->code }}</td>
                        <td class="align-baseline">{{ $e->code_number }}</td>
                        <td class="align-baseline">
                            <div class="row">
                                <div class="d-flex justify-content-start">
                                    @can ('document-edit')
                                    <div class="col-3">
                                        <button wire:click="edit({{ $e->id }})" class="btn btn-info edit"><i class="fas fa-solid fa-pen"></i></button>
                                    </div>
                                    @endcan
                                    @can ('document-delete')
                                    <div class="col-3">
                                        <a class="btn btn-error delete" data-id="{{ $e->id }}" data-nama="{{ $e->name }}"><i class="fas fa-solid fa-trash"></i></a>
                                    </div>
                                    @endcan
                                </div>
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
            {{ $docs->links() }}
        </div>
    </div>
    <x-jet-dialog-modal wire:model="isModal">
        <x-slot name="title">
            {{ __('Create') }}
        </x-slot>

        <x-slot name="content">
            <div class="mb-4">
                <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Name" wire:model="name">
                @error('name') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>
            <div class="mb-4">
                <label for="exampleFormControlInput2" class="block text-gray-700 text-sm font-bold mb-2">Klasifikasi:</label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput2" wire:model="code" placeholder="Enter Code"></textarea>
                @error('code') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>
            <div class="mb-4">
                <label for="exampleFormControlInput2" class="block text-gray-700 text-sm font-bold mb-2">Number:</label>
                <input type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Code Number" wire:model="code_number">
                @error('code') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('isModal', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click.prevent="store()" wire:loading.attr="enabled">
                {{ __('Save') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>

@section ('js')
<script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $('.delete').click(function() {
        var documentid = $(this).attr('data-id');
        var documentnama = $(this).attr('data-nama');
        swal({
                title: "Yakin ?",
                text: "Kamu akan menghapus data document " + documentnama + "",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.livewire.emit('delete', documentid)
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
@endsection