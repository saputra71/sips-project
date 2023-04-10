@extends ('layouts.AdminLTE.main')
@section ('title', 'Surat Keluar')

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
                    <div class="alert alert-success shadow-lg">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                    @endif

                    <!-- <a href="{{route ('dashboard.outgoing-mails.create') }}" class="btn btn-success mb-4">+ Tambah Data</a> -->
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle mb-4" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            + Tambah Data
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{route ('dashboard.outgoing-mails.create') }}">Surat Umum</a>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table id="maintable" class="table">
                            <thead>
                                <tr>
                                    <th width="3%">No</th>
                                    <th width="10%">No. Surat</th>
                                    <th width="10%">Tgl. Surat</th>
                                    <th width="10%">Pengirim</th>
                                    <th width="10%">Perihal</th>
                                    <th width="10%">Lampiran</th>
                                    <th width="5%">Menjabat</th>
                                    <th width="5%">Jenis Document</th>
                                    <th width="22%">Arsip</th>
                                    <th width="10%">Penerima</th>
                                    <th width="20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($outgoingMails as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nomor_surat }}</td>
                                    <td>{{ date('d F Y', strtotime($item->tgl_surat)) }}</td>
                                    <td>{{ $item->pengirim }}</td>
                                    <td>{{ $item->perihal }}</td>
                                    <td>{{ $item->lampiran ?? '-' }}</td>
                                    <td>{{ $item->menjabat->employee->name }}</td>
                                    <td class="align-baseline">{{ $item->document ? $item->document->name . ' - ' . $item->document->code_number : '-' }}</td>
                                    <td>{{ $item->arsip }}</td>
                                    <td>{{ $item->penerima }}</td>
                                    <td>
                                        <div class="row">
                                            <div class="d-flex justify-content-center">
                                                <div class="col-3">
                                                    <a href="{{ route ('dashboard.outgoing-mails.edit', $item->id) }}" class="btn btn-info">
                                                        <i class="fas fa-solid fa-pen"></i>
                                                    </a>
                                                </div>
                                                <div class="col-3">
                                                    <a href="{{ route ('dashboard.outgoing-mails.view-template', $item->id) }}" class="btn btn-success">
                                                        <i class="fas fa-solid fa-book"></i>
                                                    </a>
                                                </div>
                                                <div class="col-3">
                                                    <form action="{{route ('dashboard.outgoing-mails.destroy', $item->id) }}" method="post">
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