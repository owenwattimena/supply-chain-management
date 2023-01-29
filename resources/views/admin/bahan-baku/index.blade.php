@extends('admin.templates.template')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('body')
<section class="content-header">
    <h1>
        Bahan Baku
        <small>Daftar bahan baku</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-users"></i> Bahan Baku</li>
    </ol>
</section>
<section class="content">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Bahan Baku</h3>
        </div>
        <div class="box-body">
            @if (auth()->user()->role == 'supplier' || auth()->user()->role == 'supplier_pasir')
                
            <button class="btn btn-flat bg-olive" style="margin-bottom: 15px" data-toggle="modal" data-target="#modal-default">TAMBAH</button>
            <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('master.raw-material.post') }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Tambah Bahan Baku</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nomor_bahan_baku">Nomor Bahan Baku</label>
                                    <input type="text" class="form-control" id="nomor_bahan_baku" name="nomor_bahan_baku" value="{{ old('nomor_bahan_baku', '') }}" required placeholder="Masukan nomor bahan baku">
                                    @error('nomor_bahan_baku')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nama_bahan_baku">Nama Bahan Baku</label>
                                    <input type="text" class="form-control" id="nama_bahan_baku" name="nama_bahan_baku" value="{{ old('nama_bahan_baku', '') }}" required placeholder="Masukan nama bahan baku">
                                    @error('nama_bahan_baku')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="spesifikasi">Spesifikasi</label>
                                    <textarea class="form-control" id="spesifikasi" name="spesifikasi" required placeholder="Spesifikasi">{{ old('spesifikasi', '') }}</textarea>
                                    @error('spesifikasi')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <select class="form-control" name="id_satuan">
                                        @foreach ($satuan as $item)
                                        <option value="{{ $item->id }}">{{ $item->satuan }}</option>
                                        @endforeach
                                    </select>
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
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nomor</th>
                        <th>Bahan Baku</th>
                        <th>Spesifikasi</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        @if (auth()->user()->role != 'supplier' && auth()->user()->role != 'supplier_pasir')
                        <th>Supplier</th>
                        @endif
                        @if (auth()->user()->role == 'supplier' || auth()->user()->role == 'supplier_pasir')
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php
                    $no = 0;
                    @endphp
                    @foreach ($bahanBaku as $item)
                    <tr>
                        <td>{{ ++$no }}</td>
                        <td>{{ $item->nomor_bahan_baku }}</td>
                        <td>{{ $item->nama_bahan_baku }}</td>
                        <td>{{ $item->spesifikasi }}</td>
                        <td>{{ $item->satuan->satuan }}</td>
                        <?php $_harga = $item->harga->where('status', true)->first(); ?>
                        <td>{{ $_harga ?'Rp. ' . number_format($_harga->harga_jual, 0, ',', '.') : '' }}</td>
                        @if (auth()->user()->role != 'supplier' && auth()->user()->role != 'supplier_pasir')
                        <td>{{ $item->supplier->name }}</td>
                        @endif
                        @if (auth()->user()->role == 'supplier' || auth()->user()->role == 'supplier_pasir')
                        <td>
                            <button class="btn btn-xs bg-green btn-flat" data-toggle="modal" data-target="#modal-harga-{{ $item->id }}">HARGA</button>
                            <button class="btn btn-xs bg-orange btn-flat" data-toggle="modal" data-target="#modal-{{ $item->id }}">UBAH</button>
                            <form action="{{ route('master.raw-material.delete', $item->id) }}" method="post" style="display: inline">
                                @csrf
                                @method('delete')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus bahan baku?')" class="btn btn-xs bg-maroon btn-flat">HAPUS</butt>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @if (auth()->user()->role == 'supplier' || auth()->user()->role == 'supplier_pasir')
                    <div class="modal fade" id="modal-harga-{{ $item->id }}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Harga Bahan Baku</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('master.raw-material.price', $item->id) }}" method="POST">
                                        @csrf
                                        <label for="harga">Harga</label>
                                        <div class="input-group input-group">
                                            <input type="number" class="form-control" name="harga" id="harga" required>
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-info btn-flat">Tambah</button>
                                            </span>
                                        </div>
                                        @error('harga')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror

                                    </form>
                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <b># Harga <span class="pull-right">Tanggal</span></b>
                                        </li>
                                        @php
                                            $_no = 0 ;
                                        @endphp
                                        @forelse ($item->harga as $harga)
                                        <li class="list-group-item">
                                            {{ ++$_no }}.  Rp. {{ number_format( $harga->harga_jual,0,",","." ) }} <span class="pull-right">{{ $harga->created_at }}</span>
                                        </li>
                                        @empty
                                        <li>Tidak ada data.</li>
                                        @endforelse
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modal-{{ $item->id }}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('master.raw-material.put', $item->id) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Ubah Bahan Baku</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="nomor_bahan_baku">Nomor Bahan Baku</label>
                                            <input type="text" class="form-control" id="nomor_bahan_baku" name="nomor_bahan_baku" value="{{ old('nomor_bahan_baku', $item->nomor_bahan_baku) }}" required placeholder="Masukan nomor bahan baku">
                                            @error('nomor_bahan_baku')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_bahan_baku">Nama Bahan Baku</label>
                                            <input type="text" class="form-control" id="nama_bahan_baku" name="nama_bahan_baku" value="{{ old('nama_bahan_baku', $item->nama_bahan_baku) }}" required placeholder="Masukan nama bahan baku">
                                            @error('nama_bahan_baku')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="spesifikasi">Spesifikasi</label>
                                            <textarea class="form-control" id="spesifikasi" name="spesifikasi" required placeholder="Spesifikasi">{{ old('spesifikasi', $item->spesifikasi) }}</textarea>
                                            @error('spesifikasi')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Satuan</label>
                                            <select class="form-control" name="id_satuan">
                                                @foreach ($satuan as $val)
                                                <option {{ $val->id == $item->satuan->id ? 'selected' : '' }} value="{{ $val->id }}">{{ $val->satuan }}</option>
                                                @endforeach
                                            </select>
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
