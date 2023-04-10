@extends ('layouts.AdminLTE.main')
@section ('title', 'Management Documents')

@section ('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="w-100">
            <div class="card">
                <div class="card-header">{{ __('Menjabat') }}</div>
                <div class="card-body">

                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong> {{ session ('success') }} </strong>
                    </div>
                    @endif

                    <a href="{{route ('dashboard.menjabat.create') }}" class="btn btn-success mb-4">+ Tambah Data</a>
                    <table id="maintable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th width='5%'>No</th>
                                <th width='15%'>Nama Pegawai</th>
                                <th width='15%'>Jabatan</th>
                                <th width='35%'>QR</th>
                                <th width='30%'>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($menjabat as $menjabat)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{$menjabat->employee->name}}</td>
                                <td>{{$menjabat->role->name}}</td>
                                <td>
                                    @if($menjabat->qrcode == null)
                                    <a href="{{route ('dashboard.menjabat.edit', $menjabat->id) }}" class="btn btn-primary">Upload QR</a>
                                    @else
                                    {{$menjabat->qrcode}}
                                    @endif
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="d-flex justify-content-center">
                                            <div class="col">
                                                <form action="{{route ('dashboard.menjabat.destroy', $menjabat->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="col">
                                                <a href="{{ route ('dashboard.menjabat.edit', $menjabat->id) }}" class="btn btn-warning">
                                                    <i class="fas fa-solid fa-pen"></i>
                                                </a>
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


@endsection