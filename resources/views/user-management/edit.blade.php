@extends ('layouts.AdminLTE.main')

@section ('title', 'Management Users')

@section ('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />

<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <img src="{{asset('AdminLTE/dist')}}/img/kewzlogo_black.png" alt="AdminLTE Logo" class="brand-image" style="opacity: .8; weight: 75px; height: 75px;">
            <h1 style="text-align: center;">Ar-Roji Arsip</h1>
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('dashboard.users.update', $user) }}">
            @csrf
            @method('PUT')

            <div>
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" value="{{ $user->name }}" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" value="{{ $user->email }}" required />
            </div>


            <div class="mt-4">
                <x-jet-label for="role" value="{{ __('Role') }}" />

                <select class="select select-bordered w-full form-control selectx" name="roles[]" id="roles[]">
                    <option disabled selected>Pilih Jabatan</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ $user->roles->contains($role) ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>

            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button class="ml-4">
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
    <div class="row py-3"></div>
</x-guest-layout>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(".selectx").select2({
        theme: "bootstrap-5"
    });
</script>

@endsection