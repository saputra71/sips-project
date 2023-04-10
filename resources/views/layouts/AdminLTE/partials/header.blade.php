<!-- <div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                @if (Route::currentRouteName() == 'dashboard.documents.index')
                <h1 class="m-0">Management Document</h1>
                @elseif (Route::currentRouteName() == 'dashboard.ingoing-mails.index')
                <h1 class="m-0">Surat Masuk</h1>
                @elseif (Route::currentRouteName() == 'dashboard.jabatan.index')
                <h1 class="m-0">Management Jabatan</h1>
                @elseif (Route::currentRouteName() == 'dashboard.menjabat.index')
                <h1 class="m-0">Menjabat</h1>
                @elseif (Route::currentRouteName() == 'index')
                <h1 class="m-0">Welcome, <b>{{ Auth::user()->name }}</b></h1>
                @endif
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                </ol>
            </div>
        </div>
    </div>
</div> -->