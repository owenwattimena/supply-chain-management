@extends('admin.templates.template')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('body')
<section class="content-header">
    <h1>
        Produksi
        <small>Daftar Produksi</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-users"></i> Produksi</li>
    </ol>
</section>
<section class="content">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Produksi</h3>
        </div>
        <div class="box-body">
            <button class="btn btn-flat bg-olive" style="margin-bottom: 15px" data-toggle="modal" data-target="#modal-default">TAMBAH</button>
            <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('production.create') }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Tambah Produksi</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="tanggal_mulai">Tanggal</label>
                                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', '') }}" required placeholder="Tanggal">
                                    @error('tanggal_mulai')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="jam_mulai">Jam Mulai</label>
                                    <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai', '') }}" required placeholder="Jam Mulai">
                                    @error('jam_mulai')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- <div class="form-group">
                                    <label for="tanggal_selesai">Tanggal Selesai</label>
                                    <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', '') }}" required placeholder="Tanggal Mulai">
                                    @error('tanggal_selesai')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div> --}}
                                <div class="form-group">
                                    <label for="jam_selesai">Jam Selesai</label>
                                    <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai', '') }}" required placeholder="Jam Mulai">
                                    @error('jam_selesai')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- <div class="form-group">
                                    <label for="produk">Produk</label>
                                    <select class="form-control" id="produk" name="id_produk" required>
                                        @foreach ($produk as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_produk')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="jumlah">Jumlah</label>
                                    <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ old('jumlah', '') }}" required placeholder="Jumlah">
                                    @error('jumlah')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div> --}}
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
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Jam Mulai</th>
                        {{-- <th>Tanggal Selesai</th> --}}
                        <th>Jam Selesai</th>
                        {{-- <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Satuan</th> --}}
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $no = 0;
                    @endphp
                    @foreach ($produksi as $item)
                    <tr>
                        <td>{{ ++$no }}</td>
                        <td> <span class="badge {{ $item->status == 'pending' ? 'bg-red' : 'bg-green' }}">{{ $item->status }}</span> </td>
                        <td>{{ $item->tanggal_mulai }}</td>
                        <td>{{ $item->jam_mulai }}</td>
                        {{-- <td>{{ $item->tanggal_selesai }}</td> --}}
                        <td>{{ $item->jam_selesai }}</td>
                        {{-- <td>{{ $item->produk->nama }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>{{ $item->produk->satuan->satuan }}</td> --}}
                        <td>
                            <a href="{{ route('production.detail', $item->id) }}" class="btn btn-xs bg-green btn-flat">Lihat</a>
                            <button class="btn btn-xs bg-orange btn-flat" data-toggle="modal" data-target="#modal-{{ $item->id }}">UBAH</button>
                            <form action="{{ route('production.delete', $item->id) }}" method="post" style="display: inline">
                                @csrf
                                @method('delete')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus produksi?')" class="btn btn-xs bg-maroon btn-flat">HAPUS</butt>
                            </form>
                        </td>
                    </tr>
                    <div class="modal fade" id="modal-{{ $item->id }}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('production.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Ubah Produksi</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="tanggal_mulai">Tanggal Mulai</label>
                                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $item->tanggal_mulai) }}" required placeholder="Tanggal Mulai">
                                            @error('tanggal_mulai')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="jam_mulai">Jam Mulai</label>
                                            <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai', $item->jam_mulai) }}" required placeholder="Jam Mulai">
                                            @error('jam_mulai')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        {{-- <div class="form-group">
                                            <label for="tanggal_selesai">Tanggal Selesai</label>
                                            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', $item->tanggal_selesai) }}" required placeholder="Tanggal Mulai">
                                            @error('tanggal_selesai')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div> --}}
                                        <div class="form-group">
                                            <label for="jam_selesai">Jam Selesai</label>
                                            <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai', $item->jam_selesai) }}" required placeholder="Jam Mulai">
                                            @error('jam_selesai')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        {{-- <div class="form-group">
                                            <label for="produk">Produk</label>
                                            <select class="form-control" id="produk" name="id_produk" required>
                                                @foreach ($produk as $val)
                                                <option {{ $val->id == $item->id_produk }} value="{{ $val->id }}">{{ $val->nama }}</option>
                                                @endforeach
                                            </select>
                                            @error('id_produk')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="jumlah">Jumlah</label>
                                            <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ old('jumlah', $item->jumlah) }}" required placeholder="Jumlah">
                                            @error('jumlah')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div> --}}
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
