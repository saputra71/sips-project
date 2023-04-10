@extends ('layouts.AdminLTE.main')
@section ('title', 'Management Documents')

@section ('content')
<div class="container">
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

                    @can ('document-create')
                    <a href="{{route ('dashboard.documents.create') }}" class="btn btn-success mb-4">+ Tambah Data</a>
                    @endcan
                    <table id="maintable" class="table-fixed table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Code</th>
                                <th>Nama</th>
                                @canany(['document-edit', 'document-delete'])
                                <th width="280px">Action</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documents as $doc)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{$doc->code}}</td>
                                <td>{{$doc->name}}</td>
                                <td>
                                    <div class="row">
                                        @can ('document-delete')
                                        <div class="col">
                                            <form action="{{route ('dashboard.documents.destroy', $doc->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        @endcan

                                        @can ('document-edit')
                                        <div class="col">
                                            <a href="{{ route ('dashboard.documents.edit', $doc->id) }}" class="btn btn-warning">
                                                <i class="fas fa-solid fa-pen"></i>
                                            </a>
                                        </div>
                                        @endcan
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