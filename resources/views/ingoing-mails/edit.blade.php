@extends ('layouts.AdminLTE.main')
@section ('title', 'Management Documents')

@section ('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />

<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="w-100">
                <div class="card">
                    <div class="card-header">{{ __('Tambah Data') }}</div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('dashboard.ingoing-mails.update', $ingoingMail) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">

                                <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Surat') }}</label>

                                <div class="col-md-6">
                                    <x-jet-input id="nomor_surat" class="block mt-1 w-full" type="text" name="nomor_surat" :value="old('nomor_surat')" value="{{ $ingoingMail->nomor_surat }}" required autofocus autocomplete="nomor_surat" />

                                    @error('nomor_surat')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row mb-3">

                                <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Surat') }}</label>

                                <div class="col-md-6">
                                    <x-jet-input id="tgl_surat" class="block mt-1 w-full" type="date" name="tgl_surat" :value="old('tgl_surat')" value="{{ $ingoingMail->tgl_surat }}" required />

                                    @error('tgl_surat')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row mb-3">

                                <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Terima') }}</label>

                                <div class="col-md-6">
                                    <x-jet-input id="tgl_terima" class="block mt-1 w-full" type="date" name="tgl_terima" :value="old('tgl_terima')" value="{{ $ingoingMail->tgl_terima }}" required />

                                    @error('tgl_terima')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row mb-3">

                                <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Pengirim') }}</label>

                                <div class="col-md-6">
                                    <x-jet-input id="pengirim" class="block mt-1 w-full" type="text" name="pengirim" :value="old('pengirim')" value="{{ $ingoingMail->pengirim }}" required />

                                    @error('pengirim')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row mb-3">

                                <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Lampiran') }}</label>

                                <div class="col-md-6">
                                    <x-jet-input id="lampiran" class="block mt-1 w-full" type="text" name="lampiran" :value="old('lampiran')" value="{{ $ingoingMail->lampiran }}" required />

                                    @error('lampiran')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row mb-3">

                                <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Perihal') }}</label>

                                <div class="col-md-6">
                                    <x-jet-input id="perihal" class="block mt-1 w-full" type="text" name="perihal" :value="old('perihal')" value="{{ $ingoingMail->perihal }}" required />

                                    @error('perihal')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row mb-3">
                                <label for="nama_jabatan" class="col-md-4 col-form-label text-md-end">{{ __('Klasifikasi') }}</label>

                                <div class="col-md-6">

                                    <select class="select select-bordered w-full form-control selectx" name="document_id" id="document_id" value="old('document_id')">
                                        <option disabled selected>Pilih Klasifikasi</option>
                                        @foreach($documents as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $ingoingMail->document_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>

                                    @error ('document_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>

                            @if($ingoingMail->arsip != null)
                            <div class="row mb-3">
                                <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Arsip') }}</label>

                                <div class="col-md-6">
                                    <img src="{{ asset('storage/' . $ingoingMail->arsip) }}" alt="{{ $ingoingMail->arsip }}" class="img-thumbnail">
                                </div>
                            </div>
                            @else

                            <div class="row mb-3">
                                <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Arsip') }}</label>

                                <div class="col-md-6">

                                    <label class="btn btn-sm" for="photo">Upload File</label>
                                    <input class="absolute pointer-events-none opacity-0" type="file" name="arsip" id="photo" value="{{ $ingoingMail->arsip }}">

                                    @error('arsip')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                            @endif

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <x-jet-button>
                                        {{ __('Edit') }}
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