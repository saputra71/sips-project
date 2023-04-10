<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-3">
            <h1 class="text-2xl font-black text-gray-800 py-4">Tambah Pegawai</h1>
            @if (session()->has('message'))
            <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
                <div class="flex">
                    <div>
                        <p class="text-sm">{{ session('message') }}</p>
                    </div>
                </div>
            </div>
            @endif
            @can ('pegawai-create')
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
            </div>
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th></th>
                            <th>NIP</th>
                            <th>Name</th>
                            <th>address</th>
                            <th>phone</th>
                            <th>email</th>
                            <th>jabatan</th>
                            <th>Handle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employees as $employee)
                        <tr>
                            <th class="align-baseline"></th>
                            <td class="align-baseline">{{ $employee->nip }}</td>
                            <td class="align-baseline">{{ $employee->name }}</td>
                            <td class="align-baseline">{{ $employee->address }}</td>
                            <td class="align-baseline">{{ $employee->phone }}</td>
                            <td class="align-baseline">{{ $employee->email }}</td>
                            <td class="align-baseline">{{ $employee->role->name }}</td>
                            <td class="align-baseline">
                                <div class="d-flex justify-content-around">
                                    @can ('pegawai-edit')
                                    <button wire:click="edit({{ $employee->nip }})" class="btn btn-info edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @endcan
                                    @can ('pegawai-delete')
                                    <button class="btn btn-error delete" data-id="{{ $employee->nip }}" data-nama="{{ $employee->name }}">
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
                {{ $employees->links() }}
            </div>
        </div>
        <x-jet-dialog-modal wire:model="isModal">
            <x-slot name="title">
                {{ __('Create') }}
            </x-slot>

            <x-slot name="content">
                <div class="mb-4">
                    <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">NIP/NUPTK/NIK:</label>
                    <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter NIP" wire:model="nip">
                    @error('nip') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput2" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                    <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput2" wire:model="name" placeholder="Enter Name"></textarea>
                    @error('name') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput2" class="block text-gray-700 text-sm font-bold mb-2">Address:</label>
                    <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput2" wire:model="address" placeholder="Enter Employee Address"></textarea>
                    @error('address') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput2" class="block text-gray-700 text-sm font-bold mb-2">Phone:</label>
                    <input type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Phone Number" wire:model="phone">
                    @error('phone') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput2" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                    <input type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Email" wire:model="email">
                    @error('email') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">JABATAN:</label>
                    <select wire:model="jabatan" class="select select-bordered w-full max-w-xs">
                        <option>-- Select Jabatan --</option>
                        @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('jabatan')
                    <p class="text-sm">{{ $message }}</p>
                    @enderror
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="closeForm()" wire:loading.attr="disabled">
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
                    <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">NIP:</label>
                    <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter NIP" wire:model="nip" readonly>
                    @error('nip') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput2" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                    <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput2" wire:model="name" placeholder="Enter Name"></textarea>
                    @error('name') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput2" class="block text-gray-700 text-sm font-bold mb-2">Address:</label>
                    <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput2" wire:model="address" placeholder="Enter Employee Address"></textarea>
                    @error('address') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput2" class="block text-gray-700 text-sm font-bold mb-2">Phone:</label>
                    <input type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Phone Number" wire:model="phone">
                    @error('phone') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput2" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                    <input type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Email" wire:model="email">
                    @error('email') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput2" class="block text-gray-700 text-sm font-bold mb-2">Jabatan:</label>
                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" wire:model="jabatan">
                        <option value="">Select Jabatan</option>
                        @foreach($roles as $jabatan)
                        <option value="{{ $jabatan->id }}">{{ $jabatan->name }}</option>
                        @endforeach
                    </select>
                    @error('jabatan') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="closeForm()" wire:loading.attr="disabled">
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
                    title: "Yakin ?",
                    text: "Kamu akan menghapus data pegawai " + pegawainama + "",
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