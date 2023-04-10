@extends ('layouts.AdminLTE.main')
@section ('title', 'Management Documents')

@section ('content')
<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="w-100">

                <div class="card mt-5">
                    <div class="card-header">{{ __('Preview Disposisi Surat Masuk') }}</div>

                    <div class="card-body">
                        <div class="row mb-3">

                            <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Surat') }}</label>

                            <div class="col-md-6">
                                <x-jet-input id="nomor_surat" class="block mt-1 w-full" type="text" name="nomor_surat" :value="old('nomor_surat')" value="{{ $ingoingMail->nomor_surat }}" readonly />

                                @error('nomor_surat')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="row mb-3">

                            <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Surat') }}</label>

                            <div class="col-md-6">
                                <x-jet-input id="tgl_surat" class="block mt-1 w-full" type="date" name="tgl_surat" :value="old('tgl_surat')" value="{{ $ingoingMail->tgl_surat }}" readonly />

                                @error('tgl_surat')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="row mb-3">

                            <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Terima') }}</label>

                            <div class="col-md-6">
                                <x-jet-input id="tgl_terima" class="block mt-1 w-full" type="date" name="tgl_terima" :value="old('tgl_terima')" value="{{ $ingoingMail->tgl_terima }}" readonly />

                                @error('tgl_terima')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="row mb-3">

                            <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Pengirim') }}</label>

                            <div class="col-md-6">
                                <x-jet-input id="pengirim" class="block mt-1 w-full" type="text" name="pengirim" :value="old('pengirim')" value="{{ $ingoingMail->pengirim }}" readonly />

                                @error('pengirim')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="row mb-3">

                            <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Lampiran') }}</label>

                            <div class="col-md-6">
                                <x-jet-input id="lampiran" class="block mt-1 w-full" type="text" name="lampiran" :value="old('lampiran')" value="{{ $ingoingMail->lampiran }}" readonly />

                                @error('lampiran')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="row mb-3">

                            <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Perihal') }}</label>

                            <div class="col-md-6">
                                <x-jet-input id="perihal" class="block mt-1 w-full" type="text" name="perihal" :value="old('perihal')" value="{{ $ingoingMail->perihal }}" readonly />

                                @error('perihal')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">

                            <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Status') }}</label>

                            <div class="col-md-6">
                                <x-jet-input id="perihal" class="block mt-1 w-full" type="text" name="perihal" :value="old('perihal')" value="{{ $notification->data['status'] }}" readonly />

                                @error('perihal')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">

                            <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Kepada') }}</label>

                            <div class="col-md-6">
                                <x-jet-input id="perihal" class="block mt-1 w-full" type="text" name="perihal" :value="old('perihal')" value="{{ $notification->data['kepada'] }}" readonly />

                                @error('perihal')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">

                            <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Catatan') }}</label>

                            <div class="col-md-6">
                                <textarea disabled class="form-control" name="catatan" id="editor" cols="30" rows="10">{{ $notification->data['catatan'] }}</textarea>

                                @error('perihal')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card previewer">
                    <div class="card-header">{{ __('Preview Arsip') }}</div>

                    <div class="card-body">
                        <div class="row mb-3 d-flex justify-content-center">

                            <div class="col">
                                <label class="col-md-4 col-form-label text-md-end" for="inputFile">{{ __('Arsip') }}&nbsp;:<a href="{{ asset('storage/' . $ingoingMail->arsip) }}" target="_blank">&nbsp;Clik Me to Fullscreen</a></label>
                                <iframe src="{{ asset('storage/' . $ingoingMail->arsip) }}" frameborder="0" width="100%" height="500px"></iframe>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>

@endsection

@section ('scripts')
<script>
    ClassicEditor
        .create(document.querySelector('#editor', ))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection