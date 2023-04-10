@extends ('layouts.AdminLTE.main')
@section ('title', 'Management Documents')

@section ('content')
<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="w-100">
                <div class="card">
                    <div class="card-header">{{ __('View Document') }}</div>

                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="arsip" class="col-md-4 col-form-label text-md-end"><a href="{{ asset('storage/' . $outgoingMail->arsip) }}" target="_blank">{{ __('PDF Full') }}</a></label>
                                <embed src="{{ asset('storage/' . $outgoingMail->arsip) }}" type="application/pdf" width="200%" height="600px" />
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('dashboard.outgoing-mails.edit', $outgoingMail) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ route('dashboard.outgoing-mails.index') }}" class="btn btn-primary">Close</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

@endsection