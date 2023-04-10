@extends ('layouts.AdminLTE.main')
@section ('title', 'Surat Masuk')

@section ('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="w-100">
            <div class="card">
                <div class="card-header">{{ __('Docs') }}</div>
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

                    @if (session('warning'))
                    <div class="alert alert-warning shadow-lg">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ session('warning') }}</span>
                        </div>
                    </div>
                    @endif

                    @if (session('info'))
                    <div class="alert alert-info shadow-lg">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ session('info') }}</span>
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-end">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Filter by Document Type
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('dashboard.ingoing-mails.index') }}">All</a>
                                        @foreach ($documents as $document)
                                        <a class="dropdown-item" href="{{ route('dashboard.ingoing-mails.index', ['document_id' => $document->id]) }}">{{ $document->name }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table id="maintable" class="table">
                            <thead>
                                <tr>
                                    <th width="3%">No</th>
                                    <th width="10%">No. Surat</th>
                                    <th width="10%">Tgl. Surat</th>
                                    <th width="10%">Tgl. Terima</th>
                                    <th width="10%">Pengirim</th>
                                    <th width="10%">Perihal</th>
                                    <th width="5%">Klasifikasi</th>
                                    <th width="22%">Arsip</th>
                                    <th width="20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ingoingMails as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nomor_surat }}</td>
                                    <td>{{ date('d F Y', strtotime($item->tgl_surat)) }}</td>
                                    <td>{{ date('d F Y', strtotime($item->tgl_terima)) }}</td>
                                    <td>{{ $item->pengirim }}</td>
                                    <td>{{ $item->perihal }}</td>
                                    <td>{{ $item->document->name}}</td>
                                    <td>{{ $item->arsip }}</td>
                                    <td>
                                        <div class="row">
                                            <div class="d-flex justify-content-center">
                                                @can ('ingoing-edit')
                                                <div class="col-3">
                                                    <a href="{{ route ('dashboard.ingoing-mails.edit', $item->id) }}" class="btn btn-warning">
                                                        <i class="fas fa-solid fa-pen"></i>
                                                    </a>
                                                </div>
                                                @endcan

                                                @can ('ingoing-dispos')
                                                <div class="col-3">
                                                    <a href="{{ route ('dashboard.ingoing-mails.show', $item->id) }}" class="btn btn-success">
                                                        <i class="fas fa-solid fa-book"></i>
                                                    </a>
                                                </div>
                                                @endcan

                                                @can ('ingoing-delete')
                                                <div class="col-3">
                                                    <form action="{{route ('dashboard.ingoing-mails.destroy', $item->id) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-error">
                                                            <i class="fas fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                                @endcan
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