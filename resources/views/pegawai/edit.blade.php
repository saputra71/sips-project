@extends ('layouts.AdminLTE.main')
@section ('title', 'Management Documents')

@section ('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="w-100">
            <div class="card">
                <div class="card-header">{{ __('Edit Data') }}</div>

                <div class="card-body">

                    <form method="POST" action="{{ route('dashboard.employees.update', $employee) }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="nip" class="col-md-4 col-form-label text-md-end">{{ __('NIP') }}</label>

                            <div class="col-md-6">
                                <input id="nip" type="text" class="form-control @error ('nip') is-invalid @enderror" name="nip" value="{{ $employee->nip }}" readonly>

                                @error ('nip')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>

                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nama') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error ('name') is-invalid @enderror" name="name" value="{{ $employee->name }}" required>
                            </div>

                            @error ('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>

                        <div class="row mb-3">
                            <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('Alamat') }}</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control @error ('address') is-invalid @enderror" name="address" value="{{ $employee->address }}" required>
                            </div>

                            @error ('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>

                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('No. Hp') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error ('phone') is-invalid @enderror" name="phone" value="{{ $employee->phone }}" required>

                                @error ('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>

                        </div>

                        <input type="hidden" name="employee[nip]" value="{{ $employee->nip }}">

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
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