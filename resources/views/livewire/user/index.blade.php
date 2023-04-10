<div class="max-w-3xl mx-auto py-5">
    <div class="row py-2"></div>
    <div class="space-y-4">
        <h1 class="text-2xl font-black text-gray-800 py-4">User Management</h1>
        @if ($formVisible)
        @if ($formVisible === 'edit')
        <livewire:user.edit />
        @else
        <livewire:user.create />
        @endif
        @else
        <button wire:click="create" class="btn btn-accent">New</button>
        @endif
    </div>
    <hr class="my-6">
    <div class="space-y-6">
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
        <div class="grid grid-cols-2 gap-2">
            <select wire:model="paginate" class="select select-bordered max-w-max">
                <option>5</option>
                <option>10</option>
                <option>15</option>
            </select>
            <input wire:model="search" type="search" placeholder="Search..." class="input input-bordered">
        </div>
        <div class="overflow-x-auto">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Handle</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $i)
                    <tr>
                        <td class="align-baseline">{{ $loop->iteration }}</td>
                        <td class="align-baseline">{{$i->name}}</td>
                        <td class="align-baseline">{{$i->email}}</td>
                        <td class="align-baseline">
                            @if(!empty($i->getRoleNames()))
                            @foreach($i->getRoleNames() as $v)
                            <label class="badge badge-success">{{ $v }}</label>
                            @endforeach
                            @endif
                        </td>
                        <td class="align-baseline">
                            <button wire:click="edit({{ $i->id }})" class="btn btn-info"><i class="fas fa-solid fa-pen"></i></button>
                            <button wire:click="confirmUserDeletion({{ $i->id }})" class="btn btn-error"><i class="fas fa-solid fa-trash"></i></button>
                            <!-- <x-jet-danger-button wire:click="confirmMenjabatDeletion({{ $i->id }})" wire:loading.attr="disabled">
                                <i class="fas fa-solid fa-trash"></i>
                            </x-jet-danger-button> -->
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
        {{ $users->links() }}
    </div>
    <x-jet-dialog-modal wire:model="confirmingUserDeletion">
        <x-slot name="title">
            {{ __('Delete User') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete ?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingUserDeletion', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click="destroy ({{ $confirmingUserDeletion }})" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>