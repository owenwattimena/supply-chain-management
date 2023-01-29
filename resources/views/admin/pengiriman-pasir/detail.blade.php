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
        Detail Pengiriman Pasir
        <small>Pengiriman Pasir</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-bars"></i> Detail Pengiriman Pasir</li>
    </ol>
</section>
<section class="content">

    <div class="invoice">
        <h2 class="page-header">
            <i class="fa fa-truck"></i> Detail Pengiriman Pasir
        </h2>

        @if ($pengiriman->status == 'pengiriman')
            
        <div class="text-right">
            <button id="btn-accept" class="btn btn-flat btn-sm bg-olive" data-toggle="modal" data-target="#modal-default">TERIMA</button>
            {{-- <button class="btn btn-flat btn-sm bg-maroon">TOLAK</button> --}}
        </div>
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    {{-- <form action="{{ route('master.user.post') }}" method="POST"> --}}
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Foto Penerimaan</h4>
                    </div>
                    <div class="modal-body">
                        <video id="video" style="width: 100%" autoplay></video>
                        <canvas id="canvas" style="width: 100%" height="400"></canvas>
                        <div id="btn-action" class="text-center">
                            <button id="click-photo" class="button button5 bg-olive"> <i class="fa fa-camera"></i> </button>
                            <button id="click-retake" class="button button5 bg-maroon"> <i class="fa fa-refresh"></i> </button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Batal</button>
                        <button type="submit" id="btn-submit" data-action="{{ route('sand-delivery.accept', $pengiriman->id) }}" class="btn btn-primary btn-flat">Simpan</button>
                    </div>
                    {{-- </form> --}}
                </div>
            </div>
        </div>
        @endif

        <div>
            <p style="margin-bottom: 0">Tanggal Pengiriman: {{ $pengiriman->created_at }}</p>
            @if ($pengiriman->tanggal_penerimaan)
            <p>Tanggal Penerimaan: {{ $pengiriman->tanggal_penerimaan ?? '-' }}</p>
            <a href="{{ asset('foto-penerimaan-pasir') }}/{{ $pengiriman->foto_penerimaan }}" target="_blank"> <i class="fa fa-image"></i> Lihat foto</a>
            @endif
        </div>

        <div class="row invoice-info" style="margin-top: 15px">
            <div class="col-sm-4 invoice-col">
                Dikirim Oleh
                <address>
                    <strong>{{ $pengiriman->dibuatOleh->name }}</strong>
                </address>
            </div>
            <div class="col-sm-4 invoice-col">
                NOMOR KENDARAAN
                <address>
                    <strong>{{ $pengiriman->nomor_kendaraan }}</strong>
                </address>
            </div>

            <div class="col-sm-4 invoice-col">
                NAMA PENGEMUDI
                <address>
                    <strong>{{ $pengiriman->nama_pengemudi }}</strong>
                </address>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Bahan Baku</th>
                            <th>Qty</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $pengiriman->bahanBaku->nomor_bahan_baku }}</td>
                            <td>{{ $pengiriman->bahanBaku->nama_bahan_baku }}</td>
                            <td>{{ number_format( $pengiriman->jumlah ) }}</td>
                            <td>{{ $pengiriman->bahanBaku->satuan->satuan }}</td>
                            <td> Rp. {{ number_format( $pengiriman->bahanBaku->harga[0]->harga_jual ) }}</td>
                            <td> Rp. {{ number_format( $pengiriman->jumlah * $pengiriman->bahanBaku->harga[0]->harga_jual ) }}</td>
                        </tr>
                    </tbody>
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
    canvas.style.display = 'none';
    click_retake.style.display = 'none';

    camera_button.addEventListener('click', async function() {
        await getMedia()

        // let stream = await navigator.mediaDevices.getUserMedia({
        //     video: true
        //     , audio: false
        // });
    });

    function btnCenter() {
        $('#btn-action').addClass('text-center');
    }

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

    click_retake.addEventListener('click', function() {
        getMedia();
        canvas.style.display = 'none'; /* use the stream */
        video.style.display = 'block'; /* use the stream */
        click_retake.style.display = 'none';
        click_button.style.display = 'inline';
        btnCenter();
    });

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

    $('#modal-default').modal({
        show: false
        , backdrop: false
    });
    $('#modal-default').on('hide.bs.modal', function(e) {
        stopCamera();
    })

    $('#btn-submit').click(function() {
        JsLoadingOverlay.show();
        let action = $(this).data('action');
        terimaPengiriman(action)
    });

    function terimaPengiriman(action) {
        var image_data;
        if (image_data_url != null) {
            image_data = image_data_url.replace('data:image/png;base64,', '');
        }

        if (image_data != null) {
            $.ajax({
                type: 'POST'
                , url: action
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , data: '{"image":"' + image_data + '"}'
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
