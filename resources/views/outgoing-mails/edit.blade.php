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

                        <form method="POST" action="{{ route('dashboard.outgoing-mails.update', $outgoingMail) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">

                                <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Surat') }}</label>

                                <div class="col-md-6">
                                    <x-jet-input id="nomor_surat" class="block mt-1 w-full" type="text" name="nomor_surat" :value="old('nomor_surat')" value="{{ $outgoingMail->nomor_surat }}" required readonly />

                                    @error('nomor_surat')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row mb-3">

                                <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Surat') }}</label>

                                <div class="col-md-6">
                                    <x-jet-input id="tgl_surat" class="block mt-1 w-full" type="date" name="tgl_surat" :value="old('tgl_surat')" value="{{ $outgoingMail->tgl_surat }}" required />

                                    @error('tgl_surat')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row mb-3">

                                <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Perihal') }}</label>

                                <div class="col-md-6">
                                    <x-jet-input id="perihal" class="block mt-1 w-full" type="text" name="perihal" :value="old('perihal')" value="{{ $outgoingMail->perihal }}" required />

                                    @error('perihal')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row mb-3">

                                <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Lampiran') }}</label>

                                <div class="col-md-6">
                                    <x-jet-input id="lampiran" class="block mt-1 w-full" type="text" name="lampiran" :value="old('lampiran')" value="{{ $outgoingMail->lampiran }}" required />

                                    @error('lampiran')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row mb-3">
                                <label for="nama_menjabat" class="col-md-4 col-form-label text-md-end">{{ __('Menjabat') }}</label>

                                <div class="col-md-6">

                                    <select name="menjabat_id" id="menjabat_id" class="form-control selectx">
                                        @foreach($employees as $item)
                                        <option value="{{ $item->nip }}" {{ $item->nip == $outgoingMail->menjabat_id ? 'selected' : '' }}>{{ $item->name }} - {{ $item->role->name }}</option>
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
                                        @foreach($documents as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $outgoingMail->document_id ? 'selected' : '' }}>{{ $item->name }}</option>
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
                                <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Penerima') }}</label>

                                <div class="col-md-6">
                                    <select class="select2-multiple select-bordered w-full form-control" name="penerima[]" id="penerima" multiple="multiple">
                                        @foreach($outgoingMail->penerima as $id)
                                        @foreach($users as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $id ? 'selected' : '' }}>{{ $item->name }} - {{ $item->role }}</option>
                                        @endforeach
                                        @endforeach
                                    </select>

                                    @error ('penerima_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row mb-3">

                                <label for="content" class="col-md-4 col-form-label text-md-end">{{ __('Content') }}</label>

                                <div class="col-md-6">
                                    <textarea class="form-control" name="content" id="editor" cols="30" rows="10">{{ $outgoingMail->content }}</textarea>

                                    @error('perihal')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

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