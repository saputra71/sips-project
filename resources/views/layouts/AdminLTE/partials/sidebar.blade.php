<nav class="">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <br>
        <li class="nav-item">
            @if (Route::currentRouteName() == 'index')
            <a href="{{ route('index') }}" class="nav-link active">
                @else
                <a href="{{ route('index') }}" class="nav-link ">
                    @endif
                    <i class="nav-icon fa-solid fa-laptop"></i>
                    <p style="font: 12pt 'Tahoma';">
                        Menu
                    </p>
                </a>
            </a>
        </li>
        {{-- <li class="nav-item">
            @if (Route::currentRouteName() == 'index')
            <a href="http://localhost/kewntodz/public/backup" class="nav-link active">
                @else
                <a href="http://localhost/kewntodz/public/backup" class="nav-link ">
                    @endif
                    <i class="nav-icon fa-solid fa-laptop"></i>
                    <p style="font: 12pt 'Tahoma';">
                        Backup
                    </p>
                </a>
            </a>
        </li> --}}
        @can ('document-list')
        <li class="nav-item">
            @if (Route::currentRouteName() == 'dashboard.documents.index')
            <a href="{{ route('index') }}" class="nav-link active">
                @else
                <a href="{{ route('dashboard.documents.index') }}" class="nav-link ">
                    @endif
                    <i class="nav-icon fa-solid fa-file-invoice"></i>
                    <p style="font: 12pt 'Tahoma';">
                        Klasifikasi Surat
                    </p>
                </a>
            </a>
        </li>
        @endcan

        @can ('module-surat')
        @if (Route::currentRouteName() == 'dashboard.ingoing-mails.index' || Route::currentRouteName() == 'dashboard.ingoing-mails.create' || Route::currentRouteName() == 'dashboard.outgoing-mails.index')
        <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
                <i class="nav-icon fa-solid fa-file-zipper"></i>
                <p style="font: 12pt 'Tahoma';">
                    Surat
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            @else
        <li class="nav-item menu">
            <a href="#" class="nav-link">
                <i class="nav-icon fa-solid fa-file-zipper"></i>
                <p style="font: 12pt 'Tahoma';">
                    Surat
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            @endif

            <ul class="nav nav-treeview">
                @can ('ingoing-list')
                <li class="nav-item menu-open">
                    @if (Route::currentRouteName() == 'dashboard.ingoing-mails.index')
                    <a href="{{ route('dashboard.ingoing-mails.index') }}" class="nav-link active">
                        @else
                        <a href="{{ route('dashboard.ingoing-mails.index') }}" class="nav-link">
                            @endif
                            <i class="fas fa-inbox nav-icon"></i>
                            <p style="font: 12pt 'Tahoma';">Surat Masuk</p>
                        </a>
                    </a>
                </li>
                @endcan

                @can ('outgoing-list')
                <li class="nav-item menu-open">
                    @if (Route::currentRouteName() == 'dashboard.outgoing-mails.index')
                    <a href="{{ route('dashboard.outgoing-mails.index') }}" class="nav-link active">
                        @else
                        <a href="{{ route('dashboard.outgoing-mails.index') }}" class="nav-link">
                            @endif
                            <i class="fas fa-inbox nav-icon"></i>
                            <p style="font: 12pt 'Tahoma';">Surat Keluar</p>
                        </a>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan

        @can ('module-pegawai')
        <li class="nav-item menu-open">
            @if (Route::currentRouteName() == 'dashboard.employees.index' || Route::currentRouteName() == 'dashboard.employees.create' || Route::currentRouteName() == 'dashboard.jabatan.index' || Route::currentRouteName() == 'dashboard.jabatan.create' || Route::currentRouteName() == 'dashboard.menjabat.index' || Route::currentRouteName() == 'dashboard.menjabat.create')
            <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-users"></i>
                <p style="font: 12pt 'Tahoma';">
                    Kelola Pegawai
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            @else
        <li class="nav-item menu">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p style="font: 12pt 'Tahoma';">
                    Kelola Pegawai
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            @endif

            <ul class="nav nav-treeview">
                @can ('pegawai-list')
                <li class="nav-item">
                    @if (Route::currentRouteName() == 'dashboard.employees.index')
                    <a href="{{ route('dashboard.employees.index') }}" class="nav-link active">
                        @else
                        <a href="{{ route('dashboard.employees.index') }}" class="nav-link">
                            @endif
                            <i class="fa-solid fa-user nav-icon"></i>
                            <p style="font: 12pt 'Tahoma';">Pegawai</p>
                        </a>
                    </a>
                </li>
                @endcan

            </ul>
        </li>
        @endcan

        @can ('role-list')
        <!-- module roles -->
        @if (Route::currentRouteName() == 'dashboard.roles.index' || Route::currentRouteName() == 'dashboard.roles.create' || Route::currentRouteName() == 'dashboard.roles.edit' || Route::currentRouteName() == 'dashboard.permissions.index' || Route::currentRouteName() == 'dashboard.permissions.create' || Route::currentRouteName() == 'dashboard.permissions.edit')
        <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
                <i class="nav-icon fa-solid fa-users-gear"></i>
                <p style="font: 12pt 'Tahoma';">
                    Fitur Pengguna
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            @else
        <li class="nav-item menu">
            <a href="#" class="nav-link">
                <i class="nav-icon fa-solid fa-users-gear"></i>
                <p style="font: 12pt 'Tahoma';">
                    Fitur Pengguna
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            @endif

            <ul class="nav nav-treeview">
                <li class="nav-item">
                    @if (Route::currentRouteName() == 'dashboard.roles.index')
                    <a href="{{ route('dashboard.roles.index') }}" class="nav-link active">
                        @else
                        <a href="{{ route('dashboard.roles.index') }}" class="nav-link">
                            @endif
                            <i class="fa-solid fa-file-pen nav-icon"></i>
                            <p style="font: 12pt 'Tahoma';">Pengguna</p>
                        </a>
                    </a>
                </li>
            </ul>
        </li>
        @endcan
        <!-- end roles -->

    </ul>
</nav>