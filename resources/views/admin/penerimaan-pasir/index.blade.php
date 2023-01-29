@extends('admin.templates.template')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('body')
<section class="content-header">
    <h1>
        Penerimaan Pasir
        <small>penerimaan Pasir</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-bars"></i> penerimaan Pasir</li>
    </ol>
</section>
<section class="content">
    <div class="nav-tabs-custom">

        <ul class="nav nav-tabs ">
            <li class="active"><a href="#penerimaan" data-toggle="tab">penerimaan</a></li>
            <li><a href="#diterima" data-toggle="tab">Diterima</a></li>
            <li><a href="#dibatalkan" data-toggle="tab">Dibatalkan</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="penerimaan">
                {{-- <button class="btn bg-olive btn-flat" data-toggle="modal" data-target="#modal-default">Buat</button>

                <div class="modal fade" id="modal-default">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('sand-delivery.create') }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Pengiriman Pasir</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="nomor_kendaraan">Nomor Kendaraan</label>
                                        <input type="text" class="form-control" id="nomor_kendaraan" name="nomor_kendaraan" value="{{ old('nomor_kendaraan', '') }}" required placeholder="Masukan nomor kendaraan">
                                        @error('nomor_kendaraan')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_pengemudi">Nama Pengemudi</label>
                                        <input type="text" class="form-control" id="nama_pengemudi" name="nama_pengemudi" value="{{ old('nama_pengemudi', '') }}" required placeholder="Masukan Nama Pengemudi">
                                        @error('nama_pengemudi')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="stok">Stok</label>
                                        <input disabled type="text" class="form-control" id="stok" name="stok" value="{{ old('stok', '') }}" required placeholder="Stok tersedia">
                                        @error('stok')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="jumlah">Jumlah</label>
                                        <input type="text" class="form-control" id="jumlah" name="jumlah" value="{{ old('jumlah', '') }}" required placeholder="Masukan jumlah">
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

                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Nomor Kendaraan</th>
                                <th>Nama Pengemudi</th>
                                <th>Nomor</th>
                                <th>Bahan Baku</th>
                                {{-- <th>Spesifikasi</th> --}}
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0; ?>
                            
                            @foreach ([] as $key => $item)
                            <tr>
                                <td>{{ ++$no }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->nomor_kendaraan }}</td>
                                <td>{{ $item->nama_pengemudi }}</td>
                                <td>{{ $item->bahanBaku->nomor_bahan_baku }}</td>
                                <td>{{ $item->bahanBaku->nama_bahan_baku }}</td>
                                {{-- <td>{{ $item->bahanBaku->spesifikasi }}</td> --}}
                                <td>{{ $item->jumlah }}</td>
                                <td>{{ $item->bahanBaku->satuan->satuan }}</td>
                                <td> Rp. {{ number_format($item->bahanBaku->harga[0]->harga_jual) }}</td>
                                <td> Rp. {{ number_format($item->jumlah * $item->bahanBaku->harga[0]->harga_jual) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="chart tab-pane" id="diterima" style="position: relative;"></div>
            <div class="chart tab-pane" id="dibatalkan" style="position: relative;"></div>
        </div>
    </div>
</section>
@endsection


@section('script')
<script src="{{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
    let stok = 0;

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
        var select = document.getElementById("id_bahan_baku");
        stok = parseInt(select.options[select.selectedIndex].dataset.stok);
        $('#stok').val(stok)
    }

    $(document).ready(function(){
        selectedStok()

        $('#id_bahan_baku').on('change', function() {
            selectedStok()
        })

        $('#jumlah').on('input', function() {
            var value = parseInt($(this).val());
            console.log(value)
            if (value > stok) {
                $(this).val(stok);
                return alert('Stok tidak cukup!')
            }
        });
    });

</script>
@endsection
