@extends ('layouts.AdminLTE.main')

@section ('title', 'Show')

@section ('content')

<div class="py-12">
    <div class="row"></div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-3">
            @if (session()->has('message'))
            <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
                <div class="flex">
                    <div>
                        <p class="text-sm">{{ session('message') }}</p>
                    </div>
                </div>
            </div>
            @endif
            <!-- DETAIL -->
            <div class="mb-4">
                <b>DETAIL</b>
            </div>
            <div class="mb-4">
                <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">SURAT MASUK:</label>
                <input value="{{ $disposition->IngoingMail->nomor_surat }}" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" readonly>
            </div>
            <div class="mb-4">
                <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">SURAT KELUAR:</label>
                @if ($disposition->surat_keluar_id)
                <!-- <input value="{{ $disposition->OutgoingMail->nomor_surat }}" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" readonly> -->
                <a href="{{ route('dashboard.outgoing-mails.view', $disposition->OutgoingMail->id) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >{{ $disposition->OutgoingMail->nomor_surat }}</a>
                @else
                <input value="Belum ada surat keluar" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" readonly>
                @endif
            </div>
            <div class="mb-4">
                <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">STATUS:</label>
                <input value="{{ $disposition->status }}" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" readonly>
            </div>
        </div>
    </div>
</div>


@endsection
