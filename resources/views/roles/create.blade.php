@extends ('layouts.AdminLTE.main')
@section ('title', 'Management Documents')

@section ('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="w-100">
            <div class="card">
                <div class="card-header">{{ __('Tambah Data') }}
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('dashboard.roles.index') }}" class="btn btn-primary">
                            <- Back</a>
                    </div>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('dashboard.roles.store') }}">
                        @csrf

                        <div class="row mb-3">

                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nama Jabatan') }}</label>

                            <div class="col-md-6">
                                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />

                                @error('nomor_surat')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        @foreach ($permission as $value)
                        <div class="row mb-3">
                            <label for="permission[]" class="col-md-4 col-form-label text-md-end">
                                <span class="whitespace-no-wrap">{{ $value->name }}</span>
                            </label>
                            <div class="col-md-6">
                                <label class="checkbox">
                                    <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="checkbox">
                                    <i class="checkbox-mark"></i>
                                </label>
                            </div>
                        </div>
                        @endforeach


                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <x-jet-button>
                                    {{ __('Tambah') }}
                                </x-jet-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection