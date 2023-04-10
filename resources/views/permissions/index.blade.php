@extends ('layouts.AdminLTE.main')
@section ('title', 'Management Documents')

@section ('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="w-100">
            <div class="card">
                <div class="card-header">{{ __('Permissions') }}</div>
                <div class="card-body">

                    @if (session('success'))
                    <div class="alert alert-success shadow-lg">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                    @endif

                    @can ('role-create')
                    <a href="{{ route('dashboard.permissions.create') }}" class="btn btn-success mb-4">+ Tambah Data</a>
                    @endcan

                    <div class="overflow-x-auto">
                        <table id="maintable" class="table">
                            <thead>
                                <tr>
                                    <th width="3%">No</th>
                                    <th width="10%">Permission Name</th>
                                    <th width="20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>
                                        <div class="row">
                                                <div class="col-3">
                                                    <a href="{{ route('dashboard.permissions.edit',$permission->id) }}" class="btn btn-warning">
                                                        <i class="fas fa-solid fa-pen"></i>
                                                    </a>
                                                </div>
                                                <div class="col-3">
                                                    <form action="{{ route('dashboard.permissions.destroy',$permission->id) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-error">
                                                            <i class="fas fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection