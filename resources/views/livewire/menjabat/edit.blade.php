<div class="z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <form>
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="">
                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">test:</label> <select wire:model="nip" class="select select-bordered w-full max-w-xs shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option disabled selected>-- Select Employee --</option>
                                @foreach ($employees as $employee)
                                <option value="{{ $employee->nip }}" {{ $nip == $employee->nip ? 'selected' : '' }}>{{ $employee->nip }} - {{ $employee->name }}</option>
                                @endforeach
                            </select>

                            @error('nip')
                            <p class="text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="exampleFormControlInput2" class="block text-gray-700 text-sm font-bold mb-2">Address:</label>
                            <select wire:model="jabatan_id" class="select select-bordered w-full max-w-xs">
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
                                    <div class="w-24 h-24 mask mask-hexagon">
                                        <img class="w-full h-full object-cover" src="{{ $qrCode->temporaryUrl() }}">
                                    </div>
                                </div>
                                @else
                                <div class="avatar">
                                    <div class="w-24 h-24 mask mask-square">
                                        <img class="w-full h-full object-cover" src="{{ asset('storage/' . $photoOld) }}">
                                    </div>
                                </div>
                                @endif
                                <label class="btn btn-sm" for="photo">Upload Photo</label>
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
                        <button wire:click.prevent="update({{ $menjabatId }})" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-400 text-base leading-6 font-bold text-white shadow-sm hover:bg-red-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Update
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