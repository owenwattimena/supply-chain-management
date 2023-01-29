@extends('admin.templates.template')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('body')
<section class="content-header">
    <h1>
        Transaksi Bahan Baku
        <small> Transaksi bahan baku</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-bars"></i> Transaksi bahan baku</li>
    </ol>
</section>
<section class="content">
    <div class="box box-default">
        {{-- <div class="box-header with-border">
            <h3 class="box-title">Bahan Baku Masuk</h3>
        </div> --}}
        <div class="box-body">
            @if (auth()->user()->role == 'supplier')
            @endif
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Pending</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Final</a></li>

                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <form action="{{ route('incoming-raw-material.create') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-flat bg-olive" style="margin-bottom: 15px">TAMBAH</button>
                        </form>
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Dibuat oleh</th>
                                        <th>Tipe</th>
                                        {{-- <th>Status</th> --}}
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 0; ?>
                                    @foreach ($transaksi->where('status', 'pending')->all() as $item)
                                    <tr>
                                        <td>{{ ++$no }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->tipe }}</td>
                                        {{-- <td>{{ $item->status }}</td> --}}
                                        <td>
                                            <a href="{{ route('incoming-raw-material.show', $item->id) }}" class="btn btn-flat bg-green btn-sm"> <i class="fa fa-eye"></i> </a>
                                            <form action="{{ route('incoming-raw-material.delete', $item->id) }}" method="post" style="display: inline">
                                                @csrf
                                                @method('delete')
                                                <button onclick="return confirm('Yakin ingin menghapus data?')" class="btn btn-flat bg-red btn-sm" type="submit"> <i class="fa fa-trash"></i> </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab_2">
                        <div class="table-responsive">
                            <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tipe</th>
                                        <th>Tanggal</th>
                                        <th>Dibuat oleh</th>
                                        {{-- <th>Status</th> --}}
                                        {{-- <th>Final</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 0; ?>
                                    @foreach ($transaksi->where('status', 'final')->all() as $item)
                                    <tr>
                                        <td>{{ ++$no }}</td>
                                        <td> <span class="badge {{ $item->tipe == 'keluar' ? 'bg-red' : 'bg-green' }}">{{ $item->tipe }}</span> </td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        {{-- <td>{{ $item->status }}</td> --}}
                                        <td> <a href="{{ route('incoming-raw-material.show', $item->id) }}" class="btn btn-flat bg-green btn-sm"> <i class="fa fa-eye"></i> </a> </td>
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
</section>
@endsection


@section('script')
<script src="{{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
    $(function() {
        $('#example1').DataTable()
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
