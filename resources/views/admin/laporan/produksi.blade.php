@extends('admin.templates.template')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">

<link rel="stylesheet" href="{{ asset('assets') }}/bower_components/bootstrap-daterangepicker/daterangepicker.css">

<link rel="stylesheet" href="{{ asset('assets') }}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
@endsection

@section('body')
<section class="content-header">
    <h1>
        Laporan Produksi
        <small>Laporan</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-cube"></i> Laporan Produksi</li>
    </ol>
</section>
<section class="content">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Laporan Produksi</h3>
        </div>
        <div class="box-body">
            <div class="text-right" style="margin-bottom: 10px">
                <div class="input-group" style="display: inline;">
                    <button type="button" class="btn btn-default btn-sm" id="daterange-btn">
                        <span>
                            <i class="fa fa-calendar"></i> Pilih Tanggal
                        </span>
                        <i class="fa fa-caret-down"></i>
                    </button>
                </div>
                <a href="#" class="btn btn-social btn-default btn-flat btn-sm" id="btn-unduh"><i class="fa fa-download"></i> UNDUH</a>
            </div>
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal Produksi</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Produk</th>
                            <th>Spesifikasi</th>
                            <th>Jumlah Produksi</th>
                            <th>Satuan</th>
                            {{-- <th>Total</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 0; ?>
                        @foreach ($produksi as $key => $item)
                        <tr>
                            <td>{{ ++$no }}</td>
                            <td>{{ $item->tanggal_mulai }}</td>
                            <td>{{ $item->jam_mulai }}</td>
                            <td>{{ $item->jam_selesai }}</td>
                            <td>{{ $item->produk->nama }}</td>
                            <td>{{ $item->produk->keterangan ?? '-' }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>{{ $item->produk->satuan->satuan }}</td>
                            {{-- <td>{{ $item->sum('kuantitas') }}</td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Tanggal Produksi</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Produk</th>
                            <th>Spesifikasi</th>
                            <th>Jumlah Produksi</th>
                            <th>Satuan</th>
                            {{-- <th>Total</th> --}}
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>
</section>
@endsection


@section('script')
<script src="{{ asset('assets') }}/bower_components/moment/min/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.38/moment-timezone-with-data.js" integrity="sha512-rF4qOuT9dYshh/J35VCVKAoz6LiTcY+nKalldHSQjE5l3ZzGFUegx5iRdTbJMACGDW8ipvmmCDrosQDYktb8Pw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('assets') }}/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="{{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
    moment().tz("Asia/Jayapura").format();
    let from = moment(`{{ $from }}`);
    let to = moment(`{{ $to }}`);
    let s = from.unix();
    let e = to.unix();
    $(document).ready(function() {
        $('#btn-unduh').attr('href', `{{ url('laporan/produksi/unduh') }}?from=${s}&to=${e}`);
        $('#daterange-btn').daterangepicker({
                ranges: {
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()]
                    , 'This Month': [moment().startOf('month'), moment().endOf('month')]
                    , 'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
                , startDate: from
                , endDate: to
            }
            , function(start, end) {
                from = start;
                to = end;
                s = start.unix();
                e = end.unix();
                // alert("Values are: s = " + s + ", e = " + e);
                window.location = `{{ url('laporan/produksi') }}?from=${s}&to=${e}`;
            }
        )
        $('#example1').DataTable()
        $('#example2').DataTable({
            'paging': true
            , 'lengthChange': false
            , 'searching': false
            , 'ordering': true
            , 'info': true
            , 'autoWidth': false
        })


        $('#daterange-btn span').html(from.format('MMMM D, YYYY') + ' - ' + to.format('MMMM D, YYYY'));

    })

</script>
@endsection
