@extends ('layouts.AdminLTE.main')
@section ('title', 'View Surat Keluar')

@section ('content')
<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="w-100">
                <div class="card">
                    <div class="card-header">{{ __('Surat Keluar : ') }} <b>{{ $outgoingMail->nomor_surat }}</b></div>

                    <div class="card-body">
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

                            <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Pengirim') }}</label>

                            <div class="col-md-6">
                                <x-jet-input id="pengirim" class="block mt-1 w-full" type="text" name="pengirim" :value="old('pengirim')" value="{{ $outgoingMail->pengirim }}" required />

                                @error('pengirim')
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
                            <label for="nama_menjabat" class="col-md-4 col-form-label text-md-end">{{ __('Menjabat') }}</label>

                            <div class="col-md-6">

                                <select name="menjabat_id" id="menjabat_id" class="form-control">
                                    @foreach($menjabats as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == $outgoingMail->menjabat_id ? 'selected' : '' }}>{{ $item->employee->name }} - {{ $item->role->name }}</option>
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

                                <select class="select select-bordered w-full form-control" name="document_id" id="document_id">
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

                            <!-- <div class="col-md-6">
                                <x-jet-input id="penerima" class="block mt-1 w-full" type="text" name="penerima" :value="old('penerima')" value="{{ $outgoingMail->menjabat->role->name }} - {{ $outgoingMail->menjabat->employee->name }}" required />

                                @error('penerima')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div> -->

                            <div class="col-md-6">
                                <select class="select select-bordered w-full form-control" name="penerima" id="penerima">
                                    <option disabled selected>PILIH PEGAWAI</option>
                                    @foreach($users as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == $outgoingMail->penerima ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
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

                        @if($outgoingMail->arsip != null)
                        <div class="row mb-3">
                            <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Arsip') }}</label>

                            <div class="col-md-6">
                                <iframe src="{{ asset('storage/' . $outgoingMail->arsip) }}" width="100%" height="500px"></iframe>
                            </div>
                        </div>
                        @else

                        <div class="row mb-3">
                            <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Arsip') }}</label>

                            <div class="col-md-6">

                                <label class="btn btn-sm" for="photo">Upload File</label>
                                <input class="absolute pointer-events-none opacity-0" type="file" name="arsip" id="photo" value="{{ $outgoingMail->arsip }}">

                                @error('arsip')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

@endsection