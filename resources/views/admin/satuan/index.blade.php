@extends('admin.templates.template')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('body')
<section class="content-header">
    <h1>
        Satuan
        <small>Daftar Satuan</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-users"></i> Satuan</li>
    </ol>
</section>
<section class="content">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Satuan</h3>
        </div>
        <div class="box-body">
            <button class="btn btn-flat bg-olive" style="margin-bottom: 15px" data-toggle="modal" data-target="#modal-default">TAMBAH</button>
            <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('master.unit.post') }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Tambah Satuan</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="satuan">Satuan</label>
                                    <input type="text" class="form-control" id="satuan" name="satuan" value="{{ old('satuan', '') }}" required placeholder="Masukan Nama">
                                    @error('satuan')
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
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Satuan</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 0;
                    @endphp
                    @foreach ($satuan as $item)
                    <tr>
                        <td>{{ ++$no }}</td>
                        <td>{{ $item->satuan }}</td>
                        <td>
                            <button class="btn btn-xs bg-orange btn-flat" data-toggle="modal" data-target="#modal-{{ $item->id }}">UBAH</button>
                            <form action="{{ route('master.unit.delete', $item->id) }}" method="post" style="display: inline">
                                @csrf
                                @method('delete')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus satuan?')" class="btn btn-xs bg-maroon btn-flat">HAPUS</butt>
                            </form>
                        </td>
                    </tr>
                    <div class="modal fade" id="modal-{{ $item->id }}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('master.unit.put', $item->id) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Ubah Satuan</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="satuan">Satuan</label>
                                            <input type="text" class="form-control" id="satuan" name="satuan" value="{{ old('satuan', $item->satuan) }}" required placeholder="Masukan Nama">
                                            @error('satuan')
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
                    @endforeach
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
