@extends ('layouts.AdminLTE.main')
@section ('title', 'Management Documents')

@section ('content')
<div class="container">
    <div class="mx-auto py-4 px-2">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-3">
            <h1 class="text-2xl font-black text-gray-800 py-4">Tambah Hak Akses Pengguna</h1>
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
            <a href="{{ route('dashboard.roles.create') }}" class="btn btn-success mb-4">Tambah +</a>
            @endcan

            <div class="overflow-x-auto">
                <table id="maintable" class="table">
                    <thead>
                        <tr>
                            <th width="3%">No</th>
                            <th width="10%">Role Name</th>
                            <th width="20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                <div class="row">
                                    <div class="d-flex justify-content-center">
                                        <div class="col-3">
                                            <a href="{{ route('dashboard.roles.show',$role->id) }}" class="btn btn-success">
                                                View
                                            </a>
                                        </div>
                                        <div class="col-3">
                                            <a href="{{ route('dashboard.roles.edit',$role->id) }}" class="btn btn-info">
                                                Edit
                                            </a>
                                        </div>
                                        <div class="col-3">
                                            <button type="submit" class="btn btn-error delete" data-id="{{ $role->id }}" data-nama="{{ $role->name }}">
                                                Hapus
                                            </button>
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

    <script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $('.delete').click(function() {
            var rolesid = $(this).attr('data-id');
            var rolesnama = $(this).attr('data-nama');
            swal({
                    title: "Yakin ?",
                    text: "Kamu akan menghapus data pengguna " + rolesnama + "",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location = "/dashboard/roles/destroy/" + rolesid + ""
                        swal("Data berhasil dihapus!", {
                            icon: "success",
                        });
                    } else {
                        swal("Data tidak jadi dihapus !");
                    }
                });
        });
    </script>
    @endsection