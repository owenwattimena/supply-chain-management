@extends('admin.templates.template')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('body')
<section class="content-header">
    <h1>
        Pekerja
        <small>Daftar Pekerja</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-users"></i> Pekerja</li>
    </ol>
</section>
<section class="content">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Pekerja</h3>
        </div>
        <div class="box-body">
            <button class="btn btn-flat bg-olive" style="margin-bottom: 15px" data-toggle="modal" data-target="#modal-default">TAMBAH</button>
            <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('production.worker.create') }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Tambah Pekerja</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nik">NIK</label>
                                    <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik', '') }}" placeholder="Masukan NIK">
                                    @error('nik')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required value="{{ old('nama', '') }}" placeholder="Masukan Nama">
                                    @error('nama')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tempat_lahir">Tempat Lahir</label>
                                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required value="{{ old('tempat_lahir', '') }}" placeholder="Masukan tempat lahir">
                                    @error('tempat_lahir')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required value="{{ old('tanggal_lahir', '') }}" placeholder="Masukan tanggal lahir">
                                    @error('tanggal_lahir')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="laki-laki">Laki-laki</option>
                                        <option value="perempuan">Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" placeholder="Masukan alamat"></textarea>
                                    @error('alamat')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="agama">Agama</label>
                                    <select class="form-control" id="agama" name="agama" required>
                                        <option value="islam">Islam</option>
                                        <option value="kristen">Kristen</option>
                                        <option value="katolik">Katolik</option>
                                        <option value="hindu">Hindu</option>
                                        <option value="budah">Budah</option>
                                        <option value="konghucu">Konghucu</option>
                                    </select>
                                    @error('agama')
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
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Tempat/Tgl Lahir</th>
                        <th>Jenis kelamin</th>
                        <th>Alamat</th>
                        <th>Agama</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $no = 0;
                    @endphp
                    @foreach ($pekerja as $item)
                    <tr>
                        <td>{{ ++$no }}</td>
                        <td>{{ $item->nik }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->tempat_lahir }}, {{ $item->tanggal_lahir }}</td>
                        <td>{{ $item->jenis_kelamin }}</td>
                        <td>{{ $item->alamat }}</td>
                        <td>{{ $item->agama }}</td>
                        <td>
                            <button class="btn btn-xs bg-orange btn-flat" data-toggle="modal" data-target="#modal-{{ $item->id }}">UBAH</button>
                            <form action="{{ route('production.worker.delete', $item->id) }}" method="post" style="display: inline">
                                @csrf
                                @method('delete')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus pekerja?')" class="btn btn-xs bg-maroon btn-flat">HAPUS</butt>
                            </form>
                        </td>
                    </tr>
                    <div class="modal fade" id="modal-{{ $item->id }}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('production.worker.update', $item->id) }}" method="POST">
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
                                        <label for="nik">NIK</label>
                                        <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik', $item->nik) }}" placeholder="Masukan NIK">
                                        @error('nik')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type="text" class="form-control" id="nama" name="nama" required value="{{ old('nama', $item->nama) }}" placeholder="Masukan Nama">
                                        @error('nama')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="tempat_lahir">Tempat Lahir</label>
                                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required value="{{ old('tempat_lahir', $item->tempat_lahir) }}" placeholder="Masukan tempat lahir">
                                        @error('tempat_lahir')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal_lahir">Tanggal Lahir</label>
                                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required value="{{ old('tanggal_lahir', $item->tanggal_lahir) }}" placeholder="Masukan tanggal lahir">
                                        @error('tanggal_lahir')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="jenis_kelamin">Jenis Kelamin</label>
                                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                            @foreach (Config::get('constants.jenis_kelamin', []) as $key => $val)
                                            <option {{ $key == $item->jenis_kelamin ? 'selected' : '' }} value="{{ $key }}">{{ $val }}</option>
                                            @endforeach
                                            {{-- <option value="laki-laki">Laki-laki</option>
                                            <option value="perempuan">Perempuan</option> --}}
                                        </select>
                                        @error('jenis_kelamin')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea class="form-control" id="alamat" name="alamat" placeholder="Masukan alamat">{{ old('alamat', $item->alamat) }}</textarea>
                                        @error('alamat')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="agama">Agama</label>
                                        <select class="form-control" id="agama" name="agama" required>
                                            {{-- <option value="islam">Islam</option>
                                            <option value="kristen">Kristen</option>
                                            <option value="katolik">Katolik</option>
                                            <option value="hindu">Hindu</option>
                                            <option value="budah">Budah</option>
                                            <option value="konghucu">Konghucu</option> --}}
                                            @foreach (Config::get('constants.agama', []) as $key => $val)
                                            <option {{ $key == $item->agama ? 'selected' : '' }} value="{{ $key }}">{{ $val }}</option>
                                            @endforeach
                                        </select>
                                        @error('agama')
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
