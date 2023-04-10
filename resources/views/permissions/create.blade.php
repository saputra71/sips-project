@extends ('layouts.AdminLTE.main')
@section ('title', 'Management Documents')

@section ('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="w-100">
            <div class="card">
                <div class="card-body">

                    <form method="POST" action="{{ route('dashboard.permissions.store') }}">
                        @csrf
                        <div class="row mb-3">

                            <label for="arsip" class="col-md-4 col-form-label text-md-end">{{ __('Permission Name') }}</label>

                            <div class="col-md-6">
                                <x-jet-input id="guard_name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />

                                @error('guard_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <x-jet-button>
                                    {{ __('Create') }}
                                </x-jet-button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection