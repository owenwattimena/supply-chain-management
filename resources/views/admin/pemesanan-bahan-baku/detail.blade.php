@extends('admin.templates.template')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">

<style>
    .button {
        border: none;
        color: white;
        padding: 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
    }

    .button5 {
        border-radius: 60%;
    }

</style>
@endsection

@section('body')
<section class="content-header">
    <h1>
        Detail Pemesanan Bahan Baku
        <small>Detail pesanan bahan baku</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-file-text"></i> Detail Pemesanan Bahan Baku</li>
    </ol>
</section>
<section class="content">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Detail Pesanan</h3>
        </div>
        <div class="box-body">
            <div class="pull-right" style="margin-bottom: 15px;">
                <a href="{{ route('order-raw-material.download', $pesanan->id) }}" class="btn btn-social btn-default btn-flat btn-sm"><i class="fa fa-download"></i> UNDUH</a>
                @if (auth()->user()->role == 'supplier' && $pesanan->status == 'pending' && auth()->user()->role == 'supplier')
                <form action="{{ route('order-raw-material.status', ['id' => $pesanan->id , 'status' => 'proses']) }}" method="post" style="display: inline;">
                    @csrf
                    <button type="submit" onclick="return confirm('Yakin ingin memproses pesanan?')" class="btn btn-social btn-flat bg-blue btn-sm"><i class="fa fa-upload"></i> PROSES</button>
                </form>

                @elseif($pesanan->status == 'draft' && ( auth()->user()->role == 'admin' || auth()->user()->role == 'developer'))
                <form action="{{ route('order-raw-material.status', ['id' => $pesanan->id , 'status' => 'menunggu']) }}" method="post" style="display: inline;">
                    @csrf
                    <button type="submit" onclick="return confirm('Yakin ingin membuat pesanan?')" class="btn btn-social btn-flat bg-blue btn-sm"><i class="fa fa-send"></i> Buat Pesanan</button>
                </form>
                @elseif($pesanan->status == 'menunggu' && ( auth()->user()->role == 'manager' || auth()->user()->role == 'developer'))
                <form action="{{ route('order-raw-material.status', ['id' => $pesanan->id , 'status' => 'pending']) }}" method="post" style="display: inline;">
                    @csrf
                    <button type="submit" onclick="return confirm('Yakin ingin memfinalkan pesanan?')" class="btn btn-social btn-flat bg-blue btn-sm"><i class="fa fa-save"></i> FINAL</button>
                </form>
                @endif

                @if ($pesanan->status == 'draft' && auth()->user()->role == 'admin')
                <form action="{{ route('order-raw-material.status', ['id' => $pesanan->id , 'status' => 'batal']) }}" method="post" style="display: inline;">
                    @csrf
                    <button type="submit" onclick="return confirm('Yakin ingin membatalkan pesanan?')" class="btn btn-social btn-flat bg-red btn-sm"><i class="fa fa-ban"></i> BATAL</button>
                </form>
                @elseif($pesanan->status == 'menunggu' && auth()->user()->role == 'manager')
                <form action="{{ route('order-raw-material.status', ['id' => $pesanan->id , 'status' => 'batal']) }}" method="post" style="display: inline;">
                    @csrf
                    <button type="submit" onclick="return confirm('Yakin ingin membatalkan pesanan?')" class="btn btn-social btn-flat bg-red btn-sm"><i class="fa fa-ban"></i> BATAL</button>
                </form>
                @elseif($pesanan->status == 'pending' && auth()->user()->role == 'supplier')
                <form action="{{ route('order-raw-material.status', ['id' => $pesanan->id , 'status' => 'batal']) }}" method="post" style="display: inline;">
                    @csrf
                    <button type="submit" onclick="return confirm('Yakin ingin membatalkan pesanan?')" class="btn btn-social btn-flat bg-red btn-sm"><i class="fa fa-ban"></i> BATAL</button>
                </form>
                @endif
                @if ($pesanan->status == 'proses' && auth()->user()->role == 'stockpile')
                <button id="btn-accept" class="btn btn-social btn-flat bg-green btn-sm" data-toggle="modal" data-target="#modal-final"><i class="fa fa-check"></i> TERIMA</button>
                <div class="modal fade" id="modal-final">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            {{-- <form id="form-order" action="{{ route('order-raw-material.status', ['id' => $pesanan->id , 'status' => 'final']) }}" method="POST" enctype="multipart/form-data"> --}}
                            @csrf
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Terima Pesanan</h4>
                            </div>
                            <div class="modal-body">
                                {{-- <div class="form-group">
                                        <label>Tanggal Penerimaan</label>
                                        <input type="date" class="form-control" id="tanggal-penerimaan" name="tanggal" required value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="form-group">
                                <label>Jam Penerimaan</label>
                                <input type="time" class="form-control" id="jam-penerimaan" name="jam" required value="{{ date('H:i:s') }}">
                            </div> --}}
                            <div class="form-group">
                                <label>Nomor Kendaraan</label>
                                <input type="text" class="form-control" id="nomor-kendaraan" name="nomor_kendaraan" placeholder="Nomor Kendaraan">
                            </div>
                            <div class="form-group">
                                <label>Nama Pengemudi</label>
                                <input type="text" class="form-control" id="nama-pengemudi" name="nama_pengemudi" placeholder="Nama Pengemudi">
                            </div>
                            <div class="forom-group">
                                <video id="video" style="width: 100%" autoplay></video>
                                <canvas id="canvas" style="width: 100%" height="400"></canvas>
                                <div id="btn-action" class="text-center">
                                    <button id="click-photo" class="button button5 bg-olive"> <i class="fa fa-camera"></i> </button>
                                    <button id="click-retake" class="button button5 bg-maroon"> <i class="fa fa-refresh"></i> </button>
                                </div>
                            </div>
                            {{-- <div class="form-group">
                                        <label>Foto</label>
                                        <input type="file" multiple="multiple" class="form-control" id="foto" name="foto[]" accept="image/png, image/jpeg, image/jpg">
                                    </div> --}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Batal</button>
                            <button type="submit" id="btn-submit" data-action="{{ route('order-raw-material.status', ['id' => $pesanan->id , 'status' => 'final']) }}" class="btn btn-primary btn-flat">Simpan</button>
                        </div>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
            {{-- <form action="{{ route('order-raw-material.status', ['id' => $pesanan->id , 'status' => 'final']) }}" method="post" style="display: inline;">
            <button type="submit" onclick="return confirm('Yakin ingin menerima pesanan?')" class="btn btn-social btn-flat bg-green btn-sm"><i class="fa fa-check"></i> TERIMA</button>
            @csrf
            </form> --}}
            @endif
        </div>
        <table class="table">
            <tr>
                <th style="width:50%">Tanggal Pesanan</th>
                <td> : {{ $pesanan->created_at }}</td>
            </tr>
            <tr>
                <th style="width:50%">Nomor Pesanan</th>
                <td> : {{ $pesanan->nomor_pesanan }}</td>
            </tr>
            <tr>
                <th>Nama Supplier</th>
                <td> : {{ $pesanan->supplier->name }}</td>
            </tr>
            @if ($pesanan->status == 'final')

            <tr>
                <th>Nomor Kendaraan</th>
                <td> : {{ $pesanan->penerimaanPesanan->nomor_kendaraan ?? '-' }}</td>
            </tr>
            <tr>
                <th>Nama Pengemudi</th>
                <td> : {{ $pesanan->penerimaanPesanan->nama_pengemudi ?? '-' }}</td>
            </tr>
            <tr>
                <th>Foto</th>
                <td> : <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-foto">Lihat</button> </td>
                <div class="modal fade" id="modal-foto">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Foto</h4>
                            </div>
                            <div class="modal-body">
                                {{-- {{  }} --}}
                                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                    {{-- <ol class="carousel-indicators">
                                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                        <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                                        <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
                                    </ol> --}}
                                    <div class="carousel-inner">
                                        @foreach ($pesanan->penerimaanPesanan->fotoPenerimaan as $key => $item)
                                        <div class="item {{ $key == 0 ? 'active' : '' }} text-center">
                                            <img src="{{ asset('foto-penerimaan-pesanan') . '/'. $item->foto }}">
                                            {{-- <div class="carousel-caption">
                                                First Slide
                                            </div> --}}
                                        </div>
                                        @endforeach
                                    </div>
                                    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                        <span class="fa fa-angle-left"></span>
                                    </a>
                                    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                        <span class="fa fa-angle-right"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </tr>
            @endif

            <tr>
                <th>Status</th>
                <?php $badge = 'bg-default'; ?>
                @switch($pesanan->status)
                @case('pending')
                <?php $badge = 'bg-red'; ?>
                @break
                @case('proses')
                <?php $badge = 'bg-blue'; ?>
                @break
                @case('final')
                <?php $badge = 'bg-green'; ?>
                @break
                @default

                @endswitch
                <td> : <span class="badge {{ $badge }}">{{ $pesanan->status }}</span></td>
            </tr>
            @if ($pesanan->status == 'batal')
            <tr>
                <th>Dibatalkan Oleh</th>
                <td> : {{ $pesanan->cancelBy->name }}</td>
            </tr>
            @endif
        </table>
        <div class="row">
            <div class="col-sm-6">
                @if ($pesanan->status == 'draft' && auth()->user()->role == 'admin')
                <button class="btn btn-flat bg-olive" style="margin-bottom: 15px" data-toggle="modal" data-target="#modal-default">TAMBAH</button>
                @endif
            </div>
            <div class="col-sm-6">
                <p style="text-align: right; font-weight: bold" id="grand_total">Grand Total : 0</p>
            </div>
        </div>
        @if ($pesanan->status == 'draft' && auth()->user()->role == 'admin')
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="form-order" action="{{ route('order-raw-material.order.material', $pesanan->id) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Tambah Bahan Baku</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Bahan Baku</label>
                                <select class="form-control" name="id_bahan_baku" id="select-bahan-baku">
                                    @foreach ($bahanBaku as $item)
                                    <option data-stok="{{ $item->stokSupplier->stok ?? 0 }}" value="{{ $item->id }}">{{ $item->nama_bahan_baku }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Stok Supplier</label>
                                <input type="text" class="form-control" disabled id="stok-supplier">
                            </div>
                            <div class="form-group">
                                <label for="kuantitas">Kuantitas</label>
                                <input type="number" class="form-control" id="kuantitas" name="kuantitas" value="{{ old('kuantitas', '') }}" required placeholder="Masukan kuantitas">
                                @error('kuantitas')
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
        <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nomor Bahan Baku</th>
                        <th>Nama Bahan Baku</th>
                        <th>Spesifikasi</th>
                        <th>Kuantitas</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Total</th>
                        @if ($pesanan->status == 'draft')
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php
                    $no = 0;
                    $g_total = 0;
                    @endphp
                    @foreach ($pesanan->material as $item)
                    <tr>
                        <td>{{ ++$no }}</td>
                        <td>{{ $item->rawMaterial->nomor_bahan_baku }}</td>
                        <td>{{ $item->rawMaterial->nama_bahan_baku }}</td>
                        <td>{{ $item->rawMaterial->spesifikasi }}</td>
                        <td>{{ $item->kuantitas }}</td>
                        <td>{{ $item->rawMaterial->satuan->satuan }}</td>
                        <?php $_harga = $item->harga; ?>
                        <?php # $_harga = $item->rawMaterial->harga->first(); ?>
                        <?php $harga = $_harga ? $_harga->harga_jual : 0; ?>
                        <?php $total = $harga * $item->kuantitas; ?>
                        <td>{{ $_harga ?'Rp. ' . number_format($_harga->harga_jual, 0, ',', '.') : '' }}</td>
                        <td>Rp. {{ number_format($total, 0, ',', '.') }}</td>
                        @if ($pesanan->status == 'draft')
                        <td>
                            <button class="btn btn-xs bg-orange btn-flat" data-toggle="modal" data-target="#modal-{{ $item->id }}">UBAH</button>
                            <form action="{{ route('order-raw-material.order.deleteMaterial', [$pesanan->id, $item->id]) }}" method="post" style="display: inline">
                                @csrf
                                @method('delete')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus bahan baku?')" class="btn btn-xs bg-maroon btn-flat">HAPUS</butt>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @if ($pesanan->status == 'draft')
                    <div class="modal fade" id="modal-{{ $item->id }}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('order-raw-material.order.updateMaterial', [$pesanan->id, $item->id]) }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Ubah Bahan Baku</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Bahan Baku</label>
                                            <select class="form-control" name="id_bahan_baku">
                                                @foreach ($bahanBaku as $val)
                                                <option {{ $val->id == $item->id_bahan_baku ? 'selected' : '' }} value="{{ $val->id }}">{{ $val->nama_bahan_baku }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="kuantitas">Kuantitas</label>
                                            <input type="number" class="form-control" id="kuantitas" name="kuantitas" value="{{ old('kuantitas', $item->kuantitas) }}" required placeholder="Masukan kuantitas">
                                            @error('kuantitas')
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
                    @php
                    $g_total = $g_total + ($total);
                    @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Nomor Bahan Baku</th>
                        <th>Nama Bahan Baku</th>
                        <th>Spesifikasi</th>
                        <th>Kuantitas</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Total</th>
                        @if ($pesanan->status == 'draft')
                        <th></th>
                        @endif
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    </div>
</section>
@endsection


@section('script')
<script src="{{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/js-loading-overlay@1.1.0/dist/js-loading-overlay.min.js"></script>

<script>
    let image_data_url = null;
    let camera_button = document.querySelector("#btn-accept");
    let video = document.querySelector("#video");
    let click_button = document.querySelector("#click-photo");
    let click_retake = document.querySelector("#click-retake");
    let canvas = document.querySelector("#canvas");
    let tracks;
    if(canvas != null)
    {
        canvas.style.display = 'none';
    }
    if(click_retake != null)
    {
        click_retake.style.display = 'none';
    }
    let stok = 0;

    if(camera_button != null)
    {
        camera_button.addEventListener('click', async function() {
            await getMedia()
        });
    }

    function btnCenter() {
        $('#btn-action').addClass('text-center');
    }

    if(click_button != null)
    {
        click_button.addEventListener('click', function() {
            canvas.style.display = 'block'; /* use the stream */
            video.style.display = 'none'; /* use the stream */
            click_retake.style.display = 'inline';
            click_button.style.display = 'none';
    
    
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
            image_data_url = canvas.toDataURL('image/jpeg');
    
            // data url of the image
            console.log(image_data_url);
            btnCenter();
        });

    }
    if(click_retake != null)
    {
        click_retake.addEventListener('click', function() {
            getMedia();
            canvas.style.display = 'none'; /* use the stream */
            video.style.display = 'block'; /* use the stream */
            click_retake.style.display = 'none';
            click_button.style.display = 'inline';
            btnCenter();
        });
    }
    $('#btn-submit').click(function() {
        var kuantitas = $('#kuantitas').val();
        if (kuantitas <= 0) {
            alert('Stok harus lebih dari 0!')
            return false;
        }
        let action = $(this).data('action');
        terimaPengiriman(action)
    });
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
        $('#stok-supplier').val(stok)
    }
    $(document).ready(function() {
        $('#grand_total').text(`Grand Total : Rp. {{ number_format($g_total, 0, ',', '.') }}`);

        selectedStok()

        $('#select-bahan-baku').on('change', function() {
            selectedStok()
        })

        $('#kuantitas').on('input', function() {
            var value = parseInt($(this).val());
            console.log(value)
            if (value > stok) {
                $(this).val(stok);
                return alert('Stok tidak cukup!')
            }
        });

        // HARUS REVISI KARNA AJAX
        // $('#form-order').on('submit', function(e) {
        //     var kuantitas = $('#kuantitas').val();
        //     if (kuantitas <= 0) {
        //         alert('Stok harus lebih dari 0!')
        //         return false;
        //     }
        // })
    })

    async function getMedia() {
        let stream = null;

        try {
            stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: 'environment'
                }
                , audio: false
            });
            video.srcObject = stream;
        } catch (err) {
            console.log(err)
            /* handle the error */
        }
    }

    function stopCamera() {
        const mediaStream = video.srcObject;
        // Through the MediaStream, you can get the MediaStreamTracks with getTracks():
        const tracks = mediaStream.getTracks();
        // Tracks are returned as an array, so if you know you only have one, you can stop it with: 
        tracks.forEach(track => track.stop())
    }

    function terimaPengiriman(action) {
        var image_data;
        if (image_data_url == null) {
            alert('Ambil gambar telebih dahulu!')
            return false
        }
        image_data = image_data_url.replace('data:image/png;base64,', '');

        var nomor_kendaraan = $('#nomor-kendaraan').val();
        if (nomor_kendaraan == null || nomor_kendaraan == '') {
            alert('Nomor Kendaraan waijib diisi!')
            return false
        }

        var nama_pengemudi = $('#nama-pengemudi').val();
        if (nama_pengemudi == null || nama_pengemudi == '') {
            alert('Nama Pengemudi wajib diisi!')
            return false
        }

        if (image_data != null) {
            JsLoadingOverlay.show();
            var data = {
                'image': image_data
                , 'nomor_kendaraan': nomor_kendaraan
                , 'nama_pengemudi': nama_pengemudi
            };
            $.ajax({
                type: 'POST'
                , url: action
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , data: JSON.stringify(data)
                , contentType: 'application/json; charset=utf-8'
                , success: function(msg) {
                    // alert("<img src='" + msg.data + "'>");
                    JsLoadingOverlay.hide();
                    location.reload();
                }
                , error: function(xhr, status, msg) {
                    console.log(xhr)
                    console.log(status)
                    console.log(msg)
                    JsLoadingOverlay.hide();
                }
            });
        }
    }

</script>
@endsection
