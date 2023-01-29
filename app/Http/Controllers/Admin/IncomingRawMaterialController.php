<?php

namespace App\Http\Controllers\Admin;

use App\Models\BahanBaku;
use Illuminate\Http\Request;
use App\Helpers\AlertFormatter;
use App\Models\TransaksiSupplier;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\DetailTransaksiSupplier;
use App\Models\StokSupplier;

class IncomingRawMaterialController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!in_array(Auth::user()->role, config('constants.access.menu.bahan_baku_masuk'))) {
                return abort(404);
            }
            return $next($request);
        });
    }

    public function index()
    {
        $data['transaksi'] = TransaksiSupplier::with('user')->where('dibuat_oleh', Auth::user()->id)->get();
        return view('admin.bahan-baku-masuk.index', $data);
    }
    public function create()
    {
        $transaksi = new TransaksiSupplier;
        $transaksi->dibuat_oleh = Auth::user()->id;
        $transaksi->tipe = 'masuk';
        $transaksi->status = 'pending';
        if ($transaksi->save()) {
            return redirect()->route('incoming-raw-material.show', $transaksi->id);
        }
        return redirect()->back()->with(AlertFormatter::danger('Gagal membuat transaksi!'));
    }

    public function show($id)
    {
        $data['transaksi'] = TransaksiSupplier::with(['items' => function ($query) {
            $query->with('bahanBaku')->get();
        }])->findOrFail($id);
        $data['bahanBaku'] = BahanBaku::with(['satuan', 'stokSupplier', 'harga' => function ($query) {
            return $query->orderBy('created_at', 'desc');
        }])->where('di_buat_oleh', auth()->user()->id)->get();
        // dd($data);
        return view('admin.bahan-baku-masuk.show', $data);
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'id_bahan_baku' => 'required',
            'jumlah'    => 'required'
        ]);
        $detailTransaksi = DetailTransaksiSupplier::where('id_bahan_baku', $request->id_bahan_baku)->where('id_transaksi_supplier', $id)->first();

        if ($detailTransaksi) {
            if ($detailTransaksi->jumlah == $request->jumlah)
                return redirect()->back()->with(AlertFormatter::warning('Bahan baku sudah di tambahkan'));

            $detailTransaksi->jumlah = $request->jumlah;
            if ($detailTransaksi->save()) {
                return redirect()->back();
            }
        }

        $detailTransaksi = new DetailTransaksiSupplier;
        $detailTransaksi->id_transaksi_supplier = $id;
        $detailTransaksi->id_bahan_baku = $request->id_bahan_baku;
        $detailTransaksi->jumlah = $request->jumlah;

        if ($detailTransaksi->save()) {
            return redirect()->back();
        }
        return redirect()->back()->with(AlertFormatter::danger('Bahan baku gagal di tambahkan'));
    }

    public function final($id)
    {
        DB::transaction(function () use ($id) {

            $detailTransaksi = DetailTransaksiSupplier::where('id_transaksi_supplier', $id)->get();
            if (count($detailTransaksi) <= 0) {
                return redirect()->back()->with(AlertFormatter::danger('Tidak dapat di finalkan. Bahan baku belum ditambahkan'));
            }
            foreach ($detailTransaksi as $key => $value) {
                $stok = StokSupplier::where('id_bahan_baku', $value->id_bahan_baku)->first();
                if ($stok) {
                    $stok->stok += $value->jumlah;
                } else {
                    $stok = new StokSupplier();
                    $stok->id_bahan_baku = $value->id_bahan_baku;
                    $stok->stok = $value->jumlah;
                }
                $stok->save();
            }

            $transaksi = TransaksiSupplier::findOrFail($id);
            $transaksi->status = 'final';
            $transaksi->final_at = date('Y-m-d H:i:s');

            $transaksi->save();
        });

        return redirect()->route('incoming-raw-material');
    }

    public function delete(Request $request, $id)
    {
        try {
            if(TransaksiSupplier::findOrFail($id)->forceDelete()){
                return redirect()->back()->with(AlertFormatter::success('Data berhasil dihapus'));
            }
            return redirect()->back()->with(AlertFormatter::danger('Data gagal dihapus'));
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with(AlertFormatter::danger( 'Tidak dapat menghapus data berelasi.' ));
        }
    }
}
