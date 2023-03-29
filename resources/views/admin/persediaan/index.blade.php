@extends('admin.templates.template')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('body')
<section class="content-header">
    <h1>
        Persediaan
        <small>Persediaan</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-bars"></i> Persediaan</li>
    </ol>
</section>
<section class="content">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Persediaan</h3>
        </div>
        <div class="box-body">
            @if (auth()->user()->role == 'supplier')
            {{-- <a href="{{ route('stock.create') }}" class="btn btn-flat bg-olive" style="margin-bottom: 15px">TAMBAH</a> --}}
            {{-- <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('master.user.post') }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Tambah Persediaan</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="name">ID TRANSAKSI</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', '') }}" required placeholder="Masukan Nama">
                                    @error('name')
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
            </div> --}}
            @endif
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nomor</th>
                        <th>Bahan Baku</th>
                        <th>Spesifikasi</th>
                        <th>Stok</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 0; ?>
                    @if (auth()->user()->role != 'supplier' && auth()->user()->role != 'supplier_pasir')

                    @foreach ($stock as $key => $item)
                    {{-- <tr>
                        <td>{{ ++$no }}</td>
                        <td>{{ $item->first()->rawMaterial->nomor_bahan_baku }}</td>
                        <td>{{ $item->first()->rawMaterial->nama_bahan_baku }}</td>
                        <td>{{ $item->first()->rawMaterial->spesifikasi }}</td>
                        <td>{{ $item->first()->rawMaterial->stokPersediaan->stok ?? 0 }}</td>
                        {{-- <td>{{ $item->sum('kuantitas') }}</td> --}}
                        {{-- <td>{{ $item->first()->rawMaterial->satuan->satuan }}</td> --}}
                    {{-- </tr>  --}}
                    <tr>
                        <td>{{ ++$no }}</td>
                    <td>{{ $item->rawMaterial->nomor_bahan_baku }}</td>
                    <td>{{ $item->rawMaterial->nama_bahan_baku }}</td>
                    <td>{{ $item->rawMaterial->spesifikasi }}</td>
                    <td>{{ $item->stok }}</td>
                    <td>{{ $item->rawMaterial->satuan->satuan }}</td>
                    </tr>
                    @endforeach
                    @else
                    @foreach ($stock as $key => $item)
                    <tr>
                        <td>{{ ++$no }}</td>
                        <td>{{ $item->nomor_bahan_baku }}</td>
                        <td>{{ $item->nama_bahan_baku }}</td>
                        <td>{{ $item->spesifikasi }}</td>
                        <td>{{ $item->stokSupplier == null ? 0 :  $item->stokSupplier->stok}}</td>
                        <td>{{ $item->satuan->satuan }}</td>
                    </tr>
                    @endforeach
                    @endif

                </tbody>
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
