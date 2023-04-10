@extends ('layouts.AdminLTE.main')
@section ('title', 'Management Documents')

@section ('content')
<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="w-100">
                <div class="card">
                    <div class="card-header">{{ __('Tambah Data') }}</div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('dashboard.outgoing-mails.template', $outgoingMail) }}" enctype="multipart/form-data">
                            @csrf


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

                                <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Perihal') }}</label>

                                <div class="col-md-6">
                                    <x-jet-input id="nomor_surat" class="block mt-1 w-full" type="text" name="nomoperihalr_surat" :value="old('perihal')" value="{{ $outgoingMail->perihal }}" required readonly />

                                    @error('perihal')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row mb-3">

                                <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Isi') }}</label>

                                <div class="col-md-6">
                                    <textarea name="content" class="w-full form-control" id="editor" cols="30" rows="10">{{ $outgoingMail->content }}</textarea>

                                    @error('content')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row mb-3">
                                <label for="nama_menjabat" class="col-md-4 col-form-label text-md-end">{{ __('Incharge') }}</label>

                                <div class="col-md-6">
                                    <x-jet-input id="menjabat" class="block mt-1 w-full" type="text" name="menjabat" :value="old('menjabat')" value="{{ $outgoingMail->menjabat->name }} - {{ $outgoingMail->menjabat->role->name }}" required readonly />


                                    @error ('menjabat_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
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

@endsection