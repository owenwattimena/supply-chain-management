@extends('admin.templates.template')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('body')
<section class="content-header">
    <h1>
        Detail Produksi
        <small>Detail Produksi</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-users"></i> Detail Produksi</li>
    </ol>
</section>
<section class="content">
    @if($produksi->status != 'final')
    <div class="text-right margin">
        <button class="btn btn-primary btn-flat" data-toggle="modal" data-target="#final-modal">FINAL</button>
    </div>
    <div class="modal fade" id="final-modal">
        <div class="modal-dialog">
            <form action="{{ route('production.final', $produksi->id) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Finalkan Produksi</h4>
                    </div>
                    <div class="modal-body">
                        <p class="text-red">Masukan Produk dan Jumlah Produk yang di hasilkan</p>
                        <div class="form-group">
                            <label for="produk">Produk</label>
                            <select class="form-control" id="produk" name="id_produk" required>
                                @foreach ($produk as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }} - {{ $item->satuan->satuan }}</option>
                                @endforeach
                            </select>
                            @error('id_produk')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jumlah_produksi">Jumlah Produksi</label>
                            <input type="number" class="form-control" id="jumlah_produksi" name="jumlah" value="{{ old('jumlah', '') }}" required placeholder="Jumlah">
                            @error('jumlah')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">FINAL</button>
                    </div>
                </div>
            </form>

        </div>

    </div>
    {{-- <form action="{{ route('production.final', $produksi->id) }}" method="post" style="display: inline; margin-bottom: 15px" class="pull-right">
    @csrf
    <button type="submit" class="btn btn-primary btn-flat" onclick="return confirm('Yakin ingin memfinalkan produksi?')">FINAL</button>
    </form> --}}
    @endif
    <div class="row" style="clear: both">
        <div class="col-md-8">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Produksi</h3>
                </div>
                <div class="box-body">

                    <div class="table-responsive" style="clear: both">
                        <table class="table">
                            <tr>
                                <th style="width:50%">Tanggal:</th>
                                <td>{{ $produksi->tanggal_mulai }}</td>
                            </tr>
                            <tr>
                                <th style="width:50%">Jam Mulai:</th>
                                <td>{{ $produksi->jam_mulai }}</td>
                            </tr>
                            {{-- <tr>
                                <th style="width:50%">Tanggal Selesai:</th>
                                <td>{{ $produksi->tanggal_selesai }}</td>
                            </tr> --}}
                            <tr>
                                <th style="width:50%">Jam Selesai:</th>
                                <td>{{ $produksi->jam_selesai }}</td>
                            </tr>
                            @if ($produksi->id_produk != null)
                            <tr>
                                <th style="width:50%">Produk:</th>
                                <td>{{ $produksi->produk->nama }}</td>
                            </tr>
                            <tr>
                                <th style="width:50%">Jumlah:</th>
                                <td>{{ $produksi->jumlah }} {{ $produksi->produk->satuan->satuan }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    <hr>
                    @if($produksi->status != 'final')
                    <button class="btn btn-flat bg-olive" style="margin-bottom: 15px" data-toggle="modal" data-target="#modal-default">TAMBAH</button>
                    <div class="modal fade" id="modal-default">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form id="form-order" action="{{ route('production.detail.create', $produksi->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Tambah Bahan Baku Produksi</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="select-bahan-baku">Bahan Baku</label>
                                            <select class="form-control" id="select-bahan-baku" name="id_bahan_baku" required>
                                                @foreach ($bahanBaku as $item)
                                                <option data-stok="{{ $item->stokPersediaan->stok ?? 0 }}" value="{{ $item->id }}">{{ $item->nama_bahan_baku }}</option>
                                                @endforeach
                                            </select>
                                            @error('bahan_baku')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="stok">Stok Bahan Baku</label>
                                            <input type="number" disabled class="form-control" id="stok" name="stok" required placeholder="stok">
                                            @error('stok')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="jumlah">Jumlah</label>
                                            <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ old('jumlah', '') }}" required placeholder="Jumlah">
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
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nomor Bahan Baku</th>
                                <th>Nama Bahan Baku</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                @if($produksi->status != 'final')
                                <th></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 0;
                            @endphp
                            @foreach ($produksi->detail as $item)
                            <tr>
                                <td>{{ ++$no }}</td>
                                <td>{{ $item->bahanBaku->nomor_bahan_baku }}</td>
                                <td>{{ $item->bahanBaku->nama_bahan_baku }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>{{ $item->bahanBaku->satuan->satuan }}</td>
                                @if($produksi->status != 'final')

                                <td>
                                    {{-- <button class="btn btn-xs bg-orange btn-flat" data-toggle="modal" data-target="#modal-{{ $item->id }}">UBAH</button> --}}
                                    <form action="{{ route('production.detail.delete', [ $produksi->id, $item->id]) }}" method="post" style="display: inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" onclick="return confirm('Yakin ingin menghapus bahan baku?')" class="btn btn-xs bg-maroon btn-flat">HAPUS</butt>
                                    </form>
                                </td>
                                {{-- <div class="modal fade" id="modal-{{ $item->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('production.detail.update', [$produksi->id, $item->id]) }}" method="POST">
                                            @csrf
                                            @method('put')
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Ubah Bahan Baku</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="bahan_baku">Bahan Baku</label>
                                                    <select class="form-control" id="bahan_baku" name="id_bahan_baku" required>
                                                        @foreach ($bahanBaku as $val)
                                                        <option {{ $val->id == $item->id_bahan_baku ? 'selected' : '' }} value="{{ $val->id }}">{{ $val->nama_bahan_baku }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('bahan_baku')
                                                    <span class="help-block">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="jumlah">Jumlah</label>
                                                    <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ old('jumlah', $item->jumlah) }}" required placeholder="Jumlah">
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
                </div> --}}
                @endif
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Nomor Bahan Baku</th>
                        <th>Nama Bahan Baku</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        @if($produksi->status != 'final')
                        <th></th>
                        @endif
                    </tr>
                </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Kehadiran</h3>
            </div>
            <div class="box-body">
                <div class="form-group">
                    @if($produksi->status != 'final')
                    <form action="{{ route('production.kehadiran', $produksi->id) }}" method="post">
                        @csrf
                        @foreach ($pekerja as $item)
                        <label>
                            <input type="checkbox" name="kehadiran[]" value=" {{ $item->id }}" class="flat-red" {{ isset($item->kehadiran[0]) ? ($item->kehadiran[0]->status_kehadiran ? 'checked' : '') : ''}}>
                            {{ $item->nama }}
                        </label>
                        @endforeach
                        <button class="btn btn-sm btn-primary btn-flat btn-block" type="submit" style="margin-top: 15px">SIMPAN</button>
                    </form>
                    @else
                    <ul>

                        @foreach ($produksi->kehadiran as $val)
                        <li>
                            {{ $val->pekerja->nama }}
                        </li>
                        @endforeach
                    </ul>
                    @endif
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

    function selectedStok() {
        var select = document.getElementById("select-bahan-baku");
        stok = parseInt(select.options[select.selectedIndex].dataset.stok);
        $('#stok').val(stok)
    }

    $(document).ready(function() {
        selectedStok();

        $('#select-bahan-baku').on('change', function() {
            selectedStok()
        })

        $('#jumlah').on('input', function() {
            var value = parseInt($(this).val());
            if (value > stok) {
                $(this).val(stok);
                return alert('Stok tidak cukup!')
            }
        });

        $('#form-order').on('submit', function(e) {
            var jumlah = $('#jumlah').val();
            if (jumlah <= 0) {
                alert('Stok harus lebih dari 0!')
                return false;
            }
        })
    })

</script>
@endsection
