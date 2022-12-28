@extends('admin.templates.template')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('body')
<section class="content-header">
    <h1>
        Produk
        <small>Daftar Produk</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-users"></i> Produk</li>
    </ol>
</section>
<section class="content">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Produk</h3>
        </div>
        <div class="box-body">
            <button class="btn btn-flat bg-olive" style="margin-bottom: 15px" data-toggle="modal" data-target="#modal-default">TAMBAH</button>
            <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('production.product.create') }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Tambah Produk</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="produk">Produk</label>
                                    <input type="text" class="form-control" id="produk" name="produk" value="{{ old('produk', '') }}" required placeholder="Masukan Nama">
                                    @error('produk')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Masukan Nama"></textarea>
                                    @error('keterangan')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="satuan">Satuan</label>
                                    <select class="form-control" id="satuan" name="id_satuan" required>
                                        @foreach ($satuan as $item)
                                        <option value="{{ $item->id }}">{{ $item->satuan }}</option>
                                        @endforeach
                                    </select>
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
                        <th>Produk</th>
                        <th>Keterangan</th>
                        <th>Satuan</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $no = 0;
                    @endphp
                    @foreach ($produk as $item)
                    <tr>
                        <td>{{ ++$no }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->keterangan }}</td>
                        <td>{{ $item->satuan->satuan }}</td>
                        <td>
                            <button class="btn btn-xs bg-orange btn-flat" data-toggle="modal" data-target="#modal-{{ $item->id }}">UBAH</button>
                            <form action="{{ route('production.product.delete', $item->id) }}" method="post" style="display: inline">
                                @csrf
                                @method('delete')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus produk?')" class="btn btn-xs bg-maroon btn-flat">HAPUS</butt>
                            </form>
                        </td>
                    </tr>
                    <div class="modal fade" id="modal-{{ $item->id }}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('production.product.udpate', $item->id) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Ubah Produk</h4>
                                    </div>
                                    <div class="modal-body">
                                        {{-- <div class="form-group">
                                            <label for="satuan">Satuan</label>
                                            <input type="text" class="form-control" id="satuan" name="satuan" value="{{ old('satuan', $item->satuan) }}" required placeholder="Masukan Nama">
                                        @error('satuan')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div> --}}
                                    <div class="form-group">
                                        <label for="produk">Produk</label>
                                        <input type="text" class="form-control" id="produk" name="produk" value="{{ old('produk', $item->nama) }}" required placeholder="Masukan Nama">
                                        @error('produk')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan</label>
                                        <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Masukan Nama">{{ old('keterangan', $item->keterangan) }}</textarea>
                                        @error('keterangan')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="satuan">Satuan</label>
                                        <select class="form-control" id="satuan" name="id_satuan" required>
                                            @foreach ($satuan as $val)
                                            <option {{ $val->id == $item->id_satuan ? 'selected' : '' }} value="{{ $val->id }}">{{ $val->satuan }}</option>
                                            @endforeach
                                        </select>
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
        <tfoot>
            <tr>
                <th>#</th>
                <th>Produk</th>
                <th>Keterangan</th>
                <th>Satuan</th>
                <th></th>
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
