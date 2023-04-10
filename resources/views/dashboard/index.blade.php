@extends ('layouts.AdminLTE.main')

@section ('title', 'Dashboard')

@section ('content')

<div class="container-fluid">
    <div class="row py-3"></div>
    <!-- welcome -->
    <div class="row py-2">
        <div class="col-xxl-12 col-xl-12 mb-4">
            <div class="card bg-gradient-primary-to-secondary h-100" style="box-shadow: 1px 2px 3px 4px rgba(0, 0, 0, 0.16);">
                <div class="card-body h-100 p-5">
                    <div class="row align-items-center">
                        <div class="col-xl-8 col-xxl-8">
                            <div class="text-center text-xl-start text-xxl-start mb-4 mb-xl-0 mb-xxl-4">
                                <h1 class="text-light">Selamat Datang {{ Auth::user()->name }}!</h1>
                                <p class="text-gray-1000 mb-0"><b>Di Website Sistem Informasi Pengarsipan Surat</b></p>
                            </div>
                        </div>
                        <div class="col-xl-4 col-xxl-4 d-flex justify-content-end"><img class="img-fluid" src="/admin/assets/img/illustrations/at-work.svg" style="max-width: 26rem" /></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-4 col-4">
                <!-- small box -->
                <div class="card small-box bg-primary" style="box-shadow: 1px 2px 3px 4px rgba(0, 0, 0, 0.16);">
                    <div class="inner">
                        <h3 style="color: white;">{{ $totalSuratKeluar }}</h3>

                        <p>Surat Keluar</p>

                    </div>
                    <div class="icon">
                        <i class="fas fa-inbox" style="color: white;"></i>
                    </div>
                    <a href="{{route ('dashboard.outgoing-mails.index') }}" class="small-box-footer">Info Lebih Lanjut<i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- <div class="col-lg-4 col-4">
                <div class="card small-box bg-primary" style="box-shadow: 1px 2px 3px 4px rgba(0, 0, 0, 0.16);">
                    <div class="inner">
                        <h3 style="color: white;">{{ $total }}</h3>

                        <p>Surat Keluar di buat hari ini</p>

                    </div>
                    <div class="icon">
                        <i class="fas fa-inbox" style="color: white;"></i>
                    </div>
                    <a href="{{route ('dashboard.outgoing-mails.index') }}" class="small-box-footer">Info Lebih Lanjut<i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div> -->
            <!-- ./col -->
            <div class="col-lg-4 col-4">
                <!-- small box -->
                <div class="card small-box" style="background-color: #7A7A7A; box-shadow: 1px 2px 3px 4px rgba(0, 0, 0, 0.16);">
                    <div class="inner" style="color: white;">
                        <h3 style="color: white;">{{ $totalSuratMasuk[0]['COUNT(*)'] }}</h3>

                        <p>Surat Masuk</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-paper" style="color: white;"></i>
                    </div>
                    <a href="{{route ('dashboard.ingoing-mails.index') }}" class="small-box-footer">Info Lebih Lanjut<i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-4">
                <!-- small box -->
                <div class="card small-box" style="background-color: #FF0E0E; box-shadow: 1px 2px 3px 4px rgba(0, 0, 0, 0.16);">
                    <div class="inner" style="color: white;">
                        <h3 style="color: white;">{{ $totalDisposisi }}</h3>

                        <p>Disposisi</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-comments" style="color: white;"></i>
                    </div>
                    <a href="{{route ('dashboard.dispositions.index') }}" class="small-box-footer">Info Lebih Lanjut<i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

        </div><!-- /.col -->

        <!-- Notif -->

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Notif untuk, <b>{{ Auth::user()->name }}</b></h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->

        @forelse($notifications->where('created_at', '>=', Carbon\Carbon::today()) as $notification)
        <div class="col">
            @if($notification->type == 'App\Notifications\NewDispoisiNotification')
            <div class="alert shadow-lg">
                <div>
                    <span class="badge-xs badge-error">{{ $notification->data['status'] }}</span>
                    <div>
                        <h3 class="font-bold">Nomor Surat : {{ $notification->data['nomor_surat'] }}</h3>
                        <div class="text-xs">{{ $notification->data['message'] }}</div>
                    </div>
                </div>
                <div class="flex-none">
                    <form action="{{ route('markNotification', $notification->id) }}" method="POST">
                        @csrf
                        @method('POST')
                        <a class="float-right mark-as-read" data-id="{{ $notification->id }}" class="btn btn-sm">
                            <button>Tandai sudah dibaca</button>
                        </a>
                    </form>
                    <a href="{{ route('showSurat', $notification->id) }}" class="btn btn-sm">
                        Lihat
                    </a>
                </div>
                @endif
            </div>
            @empty
            <div class="mx-1">
                Tidak ada notifikasi baru
            </div>
            @endforelse

            <!-- end notif -->
            <!-- ./col -->
        </div>
    </div><!-- /.container-fluid -->
    </section>


    @endsection