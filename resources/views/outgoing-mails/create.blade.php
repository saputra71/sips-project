@extends ('layouts.AdminLTE.main')
@section ('title', 'Management Documents')

@section ('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />

<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="w-100">
                <div class="card mt-5">
                    <div class="card-header">{{ __('Tambah Data') }}</div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('dashboard.outgoing-mails.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">

                                <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Surat') }}</label>

                                <div class="col-md-6">
                                    <x-jet-input id="tgl_surat" class="block mt-1 w-full" type="date" name="tgl_surat" :value="old('tgl_surat')" required />

                                    @error('tgl_surat')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row mb-3">

                                <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Perihal') }}</label>

                                <div class="col-md-6">
                                    <x-jet-input id="perihal" class="block mt-1 w-full" type="text" name="perihal" :value="old('perihal')" required />

                                    @error('perihal')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row mb-3">

                                <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Lampiran') }}</label>

                                <div class="col-md-6">
                                    <x-jet-input id="lampiran" class="block mt-1 w-full" type="text" name="lampiran" :value="old('lampiran')" required />

                                    @error('lampiran')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row mb-3">
                                <label for="nama_menjabat" class="col-md-4 col-form-label text-md-end">{{ __('Menjabat') }}</label>

                                <div class="col-md-6">

                                    <select name="menjabat_id" id="menjabat_id" class="select select-bordered w-full form-control selectx">
                                        <option disabled selected>Pilih</option>
                                        @foreach($employees as $item)
                                        <option value="{{ $item->nip }}">{{ $item->name }} - {{ $item->role->name }}</option>
                                        @endforeach
                                    </select>

                                    @error ('menjabat_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>

                            </div>

                            <div class="row mb-3">
                                <label for="nama_jabatan" class="col-md-4 col-form-label text-md-end">{{ __('Klasifikasi') }}</label>

                                <div class="col-md-6">

                                    <select class="select select-bordered w-full form-control selectx" name="document_id" id="document_id">
                                        <option disabled selected>Pilih Klasifikasi</option>
                                        @foreach($documents as $item)
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
                                <label for="nama_jabatan" class="col-md-4 col-form-label text-md-end">{{ __('Kepada') }}</label>

                                <div class="col-md-6">

                                    <select class="select2-multiple select-bordered w-full form-control" name="penerima[]" id="penerima" multiple="multiple">
                                        @foreach($users as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }} - {{ $item->role }}</option>
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
                                <label for="nama_jabatan" class="col-md-4 col-form-label text-md-end">{{ __('Referensi') }}</label>

                                <div class="col-md-6">

                                    <select class="select select-bordered w-full form-control" name="reference" id="reference">
                                        <option disabled selected>PILIH REFERENSI</option>
                                        <option value="0">Tidak Ada Referensi</option>
                                        @foreach($disposisi as $item)
                                        <option value="{{ $item->id }}">{{ $item->IngoingMail->nomor_surat }} - {{ $item->IngoingMail->document->name }}</option>
                                        @endforeach
                                    </select>

                                    @error ('jabatan_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>

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
</x-guest-layout>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(".selectx").select2({
        theme: "bootstrap-5"
    });
</script>
@endsection