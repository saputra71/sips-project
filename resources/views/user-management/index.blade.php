@extends ('layouts.AdminLTE.main')
@section ('title', 'Management Documents')

@section ('content')
<div class="container">
    <div class="row py-5"></div>
    <div class="row py-2"></div>
    <div class="row justify-content-center">
        <div class="w-100">
            <div class="card">
                <div class="card-header">{{ __('Docs') }}</div>
                <div class="card-body">

                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong> {{ session ('success') }} </strong>
                    </div>
                    @endif

                    <a href="{{route ('dashboard.users.create') }}" class="btn btn-success mb-4">+ Tambah Data</a>
                    <table id="maintable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    @if(!empty($user->getRoleNames()))
                                    @foreach($user->getRoleNames() as $v)
                                    <label class="badge badge-success">{{ $v }}</label>
                                    @endforeach
                                    @endif
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col">
                                            <form action="{{route ('dashboard.users.destroy', $user) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-error">
                                                    <i class="fas fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col">
                                            <a href="{{ route ('dashboard.users.edit', $user) }}" class="btn btn-info">
                                                <i class="fas fa-solid fa-pen"></i>
                                            </a>
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


@endsection