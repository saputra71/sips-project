<div class="z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <form>
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="">
                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">NIP:</label>
                            <select wire:model="nip" class="select select-bordered w-full max-w-xs">
                                <option selected>-- Select Employee --</option>
                                @foreach ($employees as $employee)
                                <option value="{{ $employee->nip }}">{{ $employee->nip }} - {{ $employee->name }}</option>
                                @endforeach
                            </select>
                            @error('nip')
                            <p class="text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">JABATAN:</label>
                            <select wire:model="jabatan_id" class="select select-bordered w-full max-w-xs">
                                <option>-- Select Jabatan --</option>
                                @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('jabatan_id')
                            <p class="text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <div class="flex items-center gap-2">
                                @if ($qrCode)
                                <div class="avatar">
                                    <div class="w-24 h-24 mask mask-square">
                                        <img class="w-full h-full object-cover" src="{{ $qrCode->temporaryUrl() }}">
                                    </div>
                                </div>
                                @endif
                                <label class="btn btn-sm" for="photo">Upload</label>
                                <input class="absolute pointer-events-none opacity-0" type="file" wire:model="qrCode" id="photo">
                            </div>
                            @error('qrCode')
                            <p class="text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-400 text-base leading-6 font-bold text-white shadow-sm hover:bg-red-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Store
                        </button>
                    </span>
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                        <button wire:click="$emit('closeForm')" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-bold text-gray-700 shadow-sm hover:text-gray-700 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Close
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>