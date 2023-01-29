@extends('admin.templates.template')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('body')
<section class="content-header">
    <h1>
        Transaksi Bahan Baku
        <small>Transaksi bahan baku</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-bars"></i> Transaksi bahan baku</li>
    </ol>
</section>
<section class="content">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"> Transaksi bahan baku</h3>
        </div>
        <div class="box-body">
            @if (auth()->user()->role == 'supplier' || auth()->user()->role == 'supplier_pasir')
            @if ($transaksi->status == 'pending' && $transaksi->tipe == 'masuk')

            <button class="btn btn-flat bg-olive" style="margin-bottom: 15px" data-toggle="modal" data-target="#modal-default">TAMBAH</button>

            <form action="{{ route('incoming-raw-material.final', $transaksi->id) }}" method="post" class="pull-right">
                @csrf
                <button class="btn btn-flat bg-maroon" style="margin-bottom: 15px" onclick="return confirm('Yakin ingin memfinalkan transaksi?')">FINAL</button>
            </form>


            <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('incoming-raw-material.store', $transaksi->id) }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Stok Bahan Baku</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="id_bahan_baku">Bahan Baku</label>
                                    <select class="form-control" id="name" name="id_bahan_baku" required>
                                        @foreach ($bahanBaku as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_bahan_baku }} - {{ $item->stokSupplier == null ? 0 : $item->stokSupplier->stock }} {{ $item->satuan->satuan }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_bahan_baku')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="jumlah">Jumlah</label>
                                    <input type="text" class="form-control" id="jumlah" name="jumlah" required placeholder="Jumlah">
                                    @error('jumlah')
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

            @endif
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nomor Bahan Baku</th>
                        <th>Nama Bahan Baku</th>
                        <th>Spesefikasi</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 0; ?>
                    @if (auth()->user()->role == 'supplier' || auth()->user()->role == 'supplier_pasir')

                    @foreach ($transaksi->items as $key => $item)
                    <tr>
                        <td>{{ ++$no }}</td>
                        <td>{{ $item->bahanBaku->nomor_bahan_baku }}</td>
                        <td>{{ $item->bahanBaku->nama_bahan_baku }}</td>
                        <td>{{ $item->bahanBaku->spesifikasi }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>{{ $item->bahanBaku->satuan->satuan }}</td>
                    </tr>
                    @endforeach
                    @endif

                </tbody>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Nomor Bahan Baku</th>
                        <th>Nama Bahan Baku</th>
                        <th>Spesefikasi</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                    </tr>
                </tfoot>
            </table>
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
