<?php

namespace App\Http\Controllers\Admin;

use App\Models\BahanBaku;
use Illuminate\Http\Request;
use App\Helpers\AlertFormatter;
use App\Models\PengirimanPasir;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\StokPersediaan;
use App\Models\StokSupplier;
use Illuminate\Support\Facades\Auth;

class SandDeliveryController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!in_array(Auth::user()->role, config('constants.access.menu.pengiriman_pasir'))) {
                return abort(404);
            }
            return $next($request);
        });
    }

    public function index()
    {

        $data['stock'] = BahanBaku::with(['satuan', 'stokSupplier', 'harga' => function ($query) {
            return $query->orderBy('created_at', 'desc');
        }])->where('di_buat_oleh', auth()->user()->id)->get();
        if (Auth::user()->role == 'supplier_pasir') {
            $data['pengiriman'] = PengirimanPasir::where('dibuat_oleh', Auth::user()->id)->get();
        } else {
            $data['pengiriman'] = PengirimanPasir::all();
        }
        return view('admin.pengiriman-pasir.index', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'nomor_kendaraan' => 'required',
            'nama_pengemudi' => 'required',
            'id_bahan_baku' => 'required',
            'jumlah' => 'required',
        ]);

        DB::beginTransaction();

        $pengiriman = new PengirimanPasir;
        $pengiriman->nomor_kendaraan = $request->nomor_kendaraan;
        $pengiriman->nama_pengemudi = $request->nama_pengemudi;
        $pengiriman->id_bahan_baku = $request->id_bahan_baku;
        $pengiriman->jumlah = $request->jumlah;
        $pengiriman->status = 'pengiriman';
        $pengiriman->dibuat_oleh = Auth::user()->id;


        if (!$pengiriman->save()) {
            DB::rollBack();
            return redirect()->back()->with(AlertFormatter::danger('Pengiriman pasir gagal dibuat!'));
        }
        $stok = StokSupplier::where('id_bahan_baku', $request->id_bahan_baku)->first();
        $stok->stok -= $request->jumlah;
        if (!$stok->save()) {
            DB::rollBack();
            return redirect()->back()->with(AlertFormatter::danger('Pengiriman pasir gagal dibuat!'));
        }
        DB::commit();
        return redirect()->back()->with(AlertFormatter::success('Pengiriman pasir berhasil dibuat!'));
    }

    public function show($id)
    {
        $data['pengiriman'] = PengirimanPasir::findOrFail($id);
        return view('admin.pengiriman-pasir.detail', $data);
    }

    public function accept(Request $request, $id)
    {

        DB::beginTransaction();
        try {
            $penerimaan = PengirimanPasir::findOrFail($id);
            $filename_path = md5(time() . uniqid()) . ".jpg";

            file_put_contents(public_path('/foto-penerimaan-pasir') . "/" . $filename_path, file_get_contents($request->image));
            // file_put_contents(getcwd() . '/foto-penerimaan-pasir' . "/" . $filename_path, file_get_contents($request->image));
            $penerimaan->foto_penerimaan = $filename_path;
            $penerimaan->tanggal_penerimaan = date("Y-m-d H:i:s");
            $penerimaan->diterima_oleh = Auth::user()->id;
            $penerimaan->status = 'diterima';
            if (!$penerimaan->save()) {
                DB::rollBack();
                return response()->json(
                    [
                        'message' => 'Data gagal di simpan.',
                    ],
                    400
                );
            }

            $stok = StokPersediaan::where('id_bahan_baku', $penerimaan->id_bahan_baku)->first();
            if ($stok == null) {
                $persediaan = new StokPersediaan;
                $persediaan->id_bahan_baku = $penerimaan->id_bahan_baku;
                $persediaan->stok = $penerimaan->jumlah;
                if (!$persediaan->save()) {
                    DB::rollBack();
                    return response()->json(
                        [
                            'message' => 'Data gagal di simpan.',
                        ],
                        400
                    );
                }
            }else{
                $stok->stok += $penerimaan->jumlah;
                if (!$stok->save()) {
                    DB::rollBack();
                    return response()->json(
                        [
                            'message' => 'Data gagal di simpan.',
                        ],
                        400
                    );
                }
            }
            DB::commit();
            return response()->json(
                [
                    'message' => 'Data berhasil di simpan.',
                ]
            );
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(
                [
                    'message' => 'Data gagal di simpan.' . $e->getMessage()
                ],
                400
            );
        }
    }
}
// "file_put_contents(D:\\laragon\\www\\content-management-system\\public\\/foto-penerimaan-pasir/3b3e5d2b4273200f9fd7d0027e60fa1d.jpg): failed to open stream: No such file or directory"