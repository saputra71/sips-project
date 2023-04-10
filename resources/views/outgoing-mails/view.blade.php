@extends ('layouts.AdminLTE.main')

@section ('title', 'VIEW')

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
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="arsip" class="col-md-4 col-form-label text-md-end"><a href="{{ asset('storage/' . $outgoingMail->arsip) }}" target="_blank">{{ __('PDF Full') }}</a></label>
                    <embed src="{{ asset('storage/' . $outgoingMail->arsip) }}" type="application/pdf" width="200%" height="600px" />
                </div>
            </div>
        </div>
    </div>
</div>

@endsection