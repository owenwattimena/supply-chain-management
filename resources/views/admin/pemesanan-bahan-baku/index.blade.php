@extends('admin.templates.template')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('body')
<section class="content-header">
    <h1>
        Pemesanan Bahan Baku
        <small>Daftar pesanan bahan baku</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-file-text"></i> Pemesanan Bahan Baku</li>
    </ol>
</section>
<section class="content">
    <div class="nav-tabs-custom">
        <?php $menunggu_total = count($order->where('status', 'menunggu')); ?>
        <?php $pending_total = count($order->where('status', 'pending')); ?>
        <?php $proses_total = count($order->where('status', 'proses')); ?>
        <ul class="nav nav-tabs">
            {{-- @if (auth()->user()->role != 'supplier') --}}
            @if (in_array(auth()->user()->role, Config::get('constants.access.menu.pemesanan_bahan_baku.draft.tab', []) ))
            <li class="active"><a href="#tab_1" data-toggle="tab">Draft</a></li>
            @endif

            @if (in_array(auth()->user()->role, Config::get('constants.access.menu.pemesanan_bahan_baku.menunggu.tab', []) ))
            <li>
                <a href="#tab_menunggu" data-toggle="tab">
                    Menunggu Persetujuan
                    @if ($menunggu_total > 0)
                    <span class="badge bg-red" style="border-radius: 50px;">{{ $menunggu_total }}</span>
                    @endif
                </a>
            </li>
            @endif
            @if (in_array(auth()->user()->role, Config::get('constants.access.menu.pemesanan_bahan_baku.pending.tab', []) ))
            <li class="{{ ( auth()->user()->role == 'supplier' || auth()->user()->role == 'stockpile') ? 'active' : '' }}">
                <a href="#tab_2" data-toggle="tab">
                    Pending
                    @if ($pending_total > 0)
                    <span class="badge bg-red" style="border-radius: 50px;">{{ $pending_total }}</span>
                    @endif
                </a>
            </li>
            @endif

            @if (in_array(auth()->user()->role, Config::get('constants.access.menu.pemesanan_bahan_baku.proses.tab', []) ))
            <li>
                <a href="#tab_3" data-toggle="tab">
                    Proses
                    @if ($proses_total > 0)
                    <span class="badge bg-blue" style="border-radius: 50px;">{{ $proses_total }}</span>
                    @endif
                </a>
            </li>
            @endif
            @if (in_array(auth()->user()->role, Config::get('constants.access.menu.pemesanan_bahan_baku.diterima.tab', []) ))
            <li><a href="#tab_4" data-toggle="tab">Diterima</a></li>
            @endif
            @if (in_array(auth()->user()->role, Config::get('constants.access.menu.pemesanan_bahan_baku.dibatalkan.tab', []) ))
            <li><a href="#tab_5" data-toggle="tab">Dibatalkan</a></li>
            @endif
        </ul>
        <div class="tab-content">
            @if (in_array(auth()->user()->role, Config::get('constants.access.menu.pemesanan_bahan_baku.draft.tab', []) ))
            <div class="tab-pane active" id="tab_1">
                @if (in_array(auth()->user()->role, Config::get('constants.access.menu.pemesanan_bahan_baku.draft.tombol_tambah', []) ))
                <button class="btn btn-flat bg-olive" style="margin-bottom: 15px" data-toggle="modal" data-target="#modal-default">TAMBAH</button>
                <div class="modal fade" id="modal-default">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('order-raw-material.order') }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Tambah Pemesanan Bahan Baku</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="nomor_pesanan">Nomor Pesanan</label>
                                        <input type="text" class="form-control" id="nomor_pesanan" name="nomor_pesanan" value="{{ old('nomor_pesanan', '') }}" required placeholder="Masukan nomor bahan baku">
                                        @error('nomor_pesanan')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="id_supplier">Nama Supplier</label>
                                        <select class="form-control" id="id_supplier" name="id_supplier" required placeholder="Masukan nama bahan baku">
                                            @foreach ($supplier as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('id_supplier')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary btn-flat">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nomor Pesanan</th>
                                <th>Nama Supplier</th>
                                <th>Dibuat Pada</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 0;
                            @endphp
                            @foreach ($order->where('status', 'draft') as $item)
                            <tr>
                                <td>{{ ++$no }}</td>
                                <td>{{ $item->nomor_pesanan }}</td>
                                <td>{{ $item->supplier->name }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    <a href="{{ route('order-raw-material.show', $item->id) }}" class="btn btn-xs bg-green btn-flat">DETAIL</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                </div>
            </div>
            @endif

            @if (in_array(auth()->user()->role, Config::get('constants.access.menu.pemesanan_bahan_baku.menunggu.tab', []) ))
            <div class="tab-pane" id="tab_menunggu">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nomor Pesanan</th>
                                <th>Nama Supplier</th>
                                <th>Dibuat Pada</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 0;
                            @endphp
                            @foreach ($order->where('status', 'menunggu') as $item)
                            <tr>
                                <td>{{ ++$no }}</td>
                                <td>{{ $item->nomor_pesanan }}</td>
                                <td>{{ $item->supplier->name }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    <a href="{{ route('order-raw-material.show', $item->id) }}" class="btn btn-xs bg-green btn-flat">DETAIL</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                </div>
            </div>
            @endif
            @if (in_array(auth()->user()->role, Config::get('constants.access.menu.pemesanan_bahan_baku.pending.tab', []) ))
            <div class="tab-pane {{ ( auth()->user()->role == 'supplier' || auth()->user()->role == 'stockpile' ) ? 'active' : '' }}" id="tab_2">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nomor Pesanan</th>
                                <th>Nama Supplier</th>
                                <th>Dibuat Pada</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 0;
                            @endphp
                            @foreach ($order->where('status', 'pending') as $item)
                            <tr>
                                <td>{{ ++$no }}</td>
                                <td>{{ $item->nomor_pesanan }}</td>
                                <td>{{ $item->supplier->name }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    <a href="{{ route('order-raw-material.show', $item->id) }}" class="btn btn-xs bg-green btn-flat">DETAIL</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                </div>
            </div>
            @endif

            @if (in_array(auth()->user()->role, Config::get('constants.access.menu.pemesanan_bahan_baku.proses.tab', []) ))
            <div class="tab-pane" id="tab_3">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nomor Pesanan</th>
                                <th>Nama Supplier</th>
                                <th>Dibuat Pada</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 0;
                            @endphp
                            @foreach ($order->where('status', 'proses') as $item)
                            <tr>
                                <td>{{ ++$no }}</td>
                                <td>{{ $item->nomor_pesanan }}</td>
                                <td>{{ $item->supplier->name }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    <a href="{{ route('order-raw-material.show', $item->id) }}" class="btn btn-xs bg-green btn-flat">DETAIL</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                </div>
            </div>
            @endif

            @if (in_array(auth()->user()->role, Config::get('constants.access.menu.pemesanan_bahan_baku.diterima.tab', []) ))
            <div class="tab-pane" id="tab_4">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nomor Pesanan</th>
                                <th>Nama Supplier</th>
                                <th>Dibuat Pada</th>
                                <th>Diterima Pada</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 0;
                            @endphp
                            @foreach ($order->where('status', 'final') as $item)
                            <tr>
                                <td>{{ ++$no }}</td>
                                <td>{{ $item->nomor_pesanan }}</td>
                                <td>{{ $item->supplier->name }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->updated_at }}</td>
                                <td>
                                    <a href="{{ route('order-raw-material.show', $item->id) }}" class="btn btn-xs bg-green btn-flat">DETAIL</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            @if (in_array(auth()->user()->role, Config::get('constants.access.menu.pemesanan_bahan_baku.dibatalkan.tab', []) ))
            <div class="tab-pane" id="tab_5">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nomor Pesanan</th>
                                <th>Nama Supplier</th>
                                <th>Dibuat Pada</th>
                                <th>Dibatalkan Pada</th>
                                <th>Dibatalkan Oleh</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 0;
                            @endphp
                            @foreach ($order->where('status', 'batal') as $item)
                            <tr>
                                <td>{{ ++$no }}</td>
                                <td>{{ $item->nomor_pesanan }}</td>
                                <td>{{ $item->supplier->name }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->updated_at }}</td>
                                <td>{{ $item->cancelBy->name }}</td>
                                <td>
                                    <a href="{{ route('order-raw-material.show', $item->id) }}" class="btn btn-xs bg-green btn-flat">DETAIL</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

</section>
@endsection


@section('script')
<script src="{{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
    $(function() {
        $('.table').DataTable()
        $('#example2').DataTable({
            'paging': true
            , 'lengthChange': false
            , 'searching': false
            , 'ordering': true
            , 'info': true
            , 'autoWidth': false
        })
    })

</script>
@endsection
