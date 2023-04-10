@extends ('layouts.AdminLTE.main')
@section ('title', 'Management Documents')

@section ('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="w-100">
            <div class="card">
                <div class="card-header">{{ __('Tambah Data') }}</div>

                <div class="card-body">

                    <form method="POST" action="{{ route('dashboard.menjabat.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label for="nip" class="col-md-4 col-form-label text-md-end">{{ __('Nama Pegawai') }}</label>

                            <div class="col-md-6">

                                <select name="nip" id="nip" class="form-control">
                                    <option>{{ __('--PILIH PEGAWAI--') }}</option>
                                    @foreach($employees as $item)
                                    <option value="{{ $item->nip }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>

                                @error ('nip')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>

                        </div>

                        <div class="row mb-3">
                            <label for="nama_jabatan" class="col-md-4 col-form-label text-md-end">{{ __('Jabatan') }}</label>

                            <div class="col-md-6">

                                <select name="jabatan_id" id="jabatan_id" class="form-control">
                                    <option>{{ __('--PILIH Jabatan--') }}</option>
                                    @foreach($jabatans as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>

                                @error ('jabatan_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>

                        </div>

                        <div class="row mb-3">

                            <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Qr Code') }}</label>
                            <div class="col-md-6">
                                <input type="file" name="qrcode" id="inputFile" class="form-control @error('qrcode') is-invalid @enderror">
                            </div>

                            @error('qrcode')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Tambah') }}
                                </button>

                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection