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
            
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nomor Bahan Baku</th>
                        <th>Nama Bahan Baku</th>
                        <th>Spesefikasi</th>
                        <th>Stok</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 0; ?>
                    @foreach ($stock as $key => $item)
                    <tr>
                        <td>{{ ++$no }}</td>
                        <td>{{ $item->first()->rawMaterial->nomor_bahan_baku }}</td>
                        <td>{{ $item->first()->rawMaterial->nama_bahan_baku }}</td>
                        <td>{{ $item->first()->rawMaterial->spesifikasi }}</td>
                        <td>{{ $item->sum('kuantitas') }}</td>
                        <td>{{ $item->first()->rawMaterial->satuan->satuan }}</td>
                    </tr>
                    {{-- <tr>
                        <td>{{ ++$no }}</td>
                        <td>{{ $item->rawMaterial->nomor_bahan_baku }}</td>
                        <td>{{ $item->rawMaterial->nama_bahan_baku }}</td>
                        <td>{{ $item->rawMaterial->spesifikasi }}</td>
                        <td>{{ $item->kuantitas }}</td>
                        <td>{{ $item->rawMaterial->satuan->satuan }}</td>
                    </tr> --}}
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Nomor Bahan Baku</th>
                        <th>Nama Bahan Baku</th>
                        <th>Spesefikasi</th>
                        <th>Stok</th>
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
