<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="info" style="position: static; text-align: center">
                {{-- @auth --}}
                <p class="mb-0"><i class=""></i> {{ auth()->user()->name }}</p>
                {{-- @endauth --}}
                <!-- Status -->
                {{-- <a href="#"><i class="fa fa-circle text-success"></i> {{ \Auth::user()->email }}</a> --}}
            </div>
        </div>

        <!-- search form (Optional) -->
        {{-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i
                            class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form> --}}
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MENU UTAMA</li>
            <li class="{{ (request()->is('dashboard*')) ? 'active' : '' }}"><a href="{{ route('dashboard') }}"><i class="fa fa-tachometer"></i> <span>Dashboard</span></a></li>
            @if (in_array(auth()->user()->role, Config::get('constants.access.menu.master', []) ))
            <li class="{{ (request()->is('master*')) ? 'active' : '' }} treeview menu-open">
                <a href="#">
                    <i class="fa fa-th"></i> <span>Master</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @if (in_array(auth()->user()->role, Config::get('constants.access.menu.master_user', []) ))
                    <li class="{{ (request()->is('master/user*')) ? 'active' : '' }}"><a href="{{ route('master.user') }}"><i class="fa fa-user-secret"></i> Pengguna</a></li>
                    @endif
                    @if (in_array(auth()->user()->role, Config::get('constants.access.menu.master_satuan', []) ))
                    <li class="{{ (request()->is('master/satuan*')) ? 'active' : '' }}"><a href="{{ route('master.unit') }}"><i class="fa fa-circle"></i> Satuan</a></li>
                    @endif
                    @if (in_array(auth()->user()->role, Config::get('constants.access.menu.master_bahan_baku', []) ))
                    <li class="{{ (request()->is('master/bahan-baku*')) ? 'active' : '' }}"><a href="{{ route('master.raw-material') }}"><i class="fa fa-archive"></i> Bahan Baku</a></li>
                    @endif
                </ul>
            </li>
            @endif

            @if (in_array(auth()->user()->role, Config::get('constants.access.menu.persediaan', []) ))
            <li class="{{ (request()->is('persediaan*')) ? 'active' : '' }}"><a href="{{ route('stock') }}"><i class="fa fa-bars"></i> <span>Persediaan</span></a></li>
            @endif
            
            @if (in_array(auth()->user()->role, Config::get('constants.access.menu.pengiriman_pasir', []) ))
            <li class="{{ (request()->is('pengiriman-pasir*')) ? 'active' : '' }}"><a href="{{ route('sand-delivery') }}"><i class="fa fa-truck"></i> <span>Pengiriman Pasir</span></a></li>
            @endif

            @if (in_array(auth()->user()->role, Config::get('constants.access.menu.bahan_baku_masuk', []) ))
            <li class="{{ (request()->is('transaksi-bahan-baku*')) ? 'active' : '' }}"><a href="{{ route('incoming-raw-material') }}"><i class="fa fa-file-text"></i> <span>Transaksi Bahan Baku </span></a></li>
            @endif

            @if (in_array(auth()->user()->role, Config::get('constants.access.menu.pemesanan_bahan_baku.access', []) ))
            <li class="{{ (request()->is('pemesanan-bahan-baku*')) ? 'active' : '' }}"><a href="{{ route('order-raw-material') }}"><i class="fa fa-file-text"></i> <span>Pesanan Bahan Baku</span></a></li>
            @endif
            @if (in_array(auth()->user()->role, Config::get('constants.access.menu.penerimaan_pasir', []) ))
            <li class="{{ (request()->is('penerimaan-pasir*')) ? 'active' : '' }}"><a href="{{ route('sand-reception') }}"><i class="fa fa-truck"></i> <span>Penerimaan Pasir</span></a></li>
            @endif

            @if (in_array(auth()->user()->role, Config::get('constants.access.menu.produksi', []) ))
            <li class="{{ (request()->is('produksi*')) ? 'active' : '' }} treeview menu-open">
                <a href="#">
                    <i class="fa fa-archive"></i> <span>Produksi</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @if (in_array(auth()->user()->role, Config::get('constants.access.menu.produksi', []) ))
                    <li class="{{ (request()->is('produksi/produk')) ? 'active' : '' }}"><a href="{{ route('production.product') }}"><i class="fa fa-cube"></i> Produk</a></li>
                    @endif
                    @if (in_array(auth()->user()->role, Config::get('constants.access.menu.produksi', []) ))
                    <li class="{{ (request()->is('produksi/pekerja*')) ? 'active' : '' }}"><a href="{{ route('production.worker') }}"><i class="fa fa-users"></i> Pekerja</a></li>
                    @endif
                    @if (in_array(auth()->user()->role, Config::get('constants.access.menu.produksi', []) ))
                    <li class="{{ (request()->is('produksi/produksi*')) ? 'active' : '' }}"><a href="{{ route('production') }}"><i class="fa fa-archive"></i> Produksi</a></li>
                    @endif
                </ul>
            </li>
            {{-- <li class="{{ (request()->is('produksi*')) ? 'active' : '' }}"><a href="{{ route('order-raw-material') }}"><i class="fa fa-archive"></i> <span>Produksi</span></a></li> --}}
            @endif

            @if ( in_array(auth()->user()->role, Config::get('constants.access.menu.laporan.produksi', [])) || in_array(auth()->user()->role, Config::get('constants.access.menu.laporan.pengiriman_pasir', [])) )
            <li class="treeview menu-open {{ (request()->is('laporan*')) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-file-excel-o"></i> <span>Laporan</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @if ( in_array(auth()->user()->role, Config::get('constants.access.menu.laporan.produksi', [])) )
                    <li class="{{ (request()->is('laporan/produksi*')) ? 'active' : '' }}"><a href="{{ route('report.production') }}"><i class="fa fa-cube"></i> Produksi</a></li>
                    @endif
                    @if ( in_array(auth()->user()->role, Config::get('constants.access.menu.laporan.penerimaan_pasir', [])) )
                    <li class="{{ (request()->is('laporan/pengiriman-pasir*')) ? 'active' : '' }}"><a href="{{ route('report.sand-delivery') }}"><i class="fa fa-truck"></i> Penerimaan Pasir</a></li>
                    @endif
                </ul>
            </li>
            @endauth
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
