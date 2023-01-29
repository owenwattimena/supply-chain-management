<?php

namespace App\Http\Controllers\Admin;

use App\Models\Produk;
use App\Models\Pekerja;
use App\Models\Produksi;
use App\Models\BahanBaku;
use Illuminate\Http\Request;
use App\Models\DetailProduksi;
use App\Models\StokPersediaan;
use App\Helpers\AlertFormatter;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Kehadiran;
use Illuminate\Support\Facades\Auth;

class ProductionController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!in_array(Auth::user()->role, config('constants.access.menu.produksi'))) {
                return abort(404);
            }
            return $next($request);
        });
    }

    public function index()
    {
        $data['produksi'] = Produksi::all();
        return view('admin.produksi.produksi.index', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required',
            'jam_mulai' => 'required',
            // 'tanggal_selesai' => 'required',
            'jam_selesai' => 'required',
            // 'id_produk' => 'required',
            // 'jumlah' => 'required',
        ]);

        $produksi = new Produksi;
        $produksi->tanggal_mulai = $request->tanggal_mulai;
        $produksi->jam_mulai = $request->jam_mulai;
        $produksi->tanggal_selesai = $request->tanggal_mulai;
        $produksi->jam_selesai = $request->jam_selesai;
        // $produksi->id_produk = $request->id_produk;
        // $produksi->jumlah = $request->jumlah;
        $produksi->dibuat_oleh = Auth::user()->id;
        $produksi->status = 'pending';

        if ($produksi->save()) {
            return redirect()->route('production.detail', $produksi->id);
        }
        return redirect()->back()->with(AlertFormatter::danger('Gagal menambahkan produksi!'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_mulai' => 'required',
            'jam_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'jam_selesai' => 'required',
            'id_produk' => 'required',
            'jumlah' => 'required',
        ]);

        $produksi = Produksi::findOrFail($id);
        if ($produksi->status == 'final') {
            return redirect()->back()->with(AlertFormatter::danger('Produksi final tidak dapat diubah!'));
        }
        $produksi->tanggal_mulai = $request->tanggal_mulai;
        $produksi->jam_mulai = $request->jam_mulai;
        $produksi->tanggal_selesai = $request->tanggal_selesai;
        $produksi->jam_selesai = $request->jam_selesai;
        $produksi->id_produk = $request->id_produk;
        $produksi->jumlah = $request->jumlah;
        $produksi->dibuat_oleh = Auth::user()->id;

        if ($produksi->save()) {
            return redirect()->back()->with(AlertFormatter::success('Berhasil mengubah produksi!'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Gagal mengubah produksi!'));
    }

    public function delete(Request $request, $id)
    {
        try {
            if (Produksi::destroy($id)) {
                return redirect()->back()->with(AlertFormatter::success('Berhasil menghapus produksi!'));
            }
            return redirect()->back()->with(AlertFormatter::danger('Gagal menghapus produksi!'));
        } catch (\Exception $e) {
            return redirect()->back()->with(AlertFormatter::danger('Produksi tidak dapat di hapus!'));
        }
    }

    public function show($id)
    {
        $data['bahanBaku'] = BahanBaku::all();
        $data['produk'] = Produk::all();
        $data['produksi'] = Produksi::with(['detail', 'kehadiran' => function ($query) {
            return $query->with('pekerja');
        }])->findOrFail($id);
        $data['pekerja'] = Pekerja::with(['kehadiran' => function ($query) use ($id) {
            return $query->where('id_produksi', $id);
        }])->get();
        // dd($data);
        return view('admin.produksi.produksi.detail', $data);
    }

    public function createDetail(Request $request, $id)
    {
        $request->validate([
            'id_bahan_baku' => 'required|numeric',
            'jumlah'    => 'required|numeric'
        ]);

        $detail = DetailProduksi::where('id_produksi', $id)->where('id_bahan_baku', $request->id_bahan_baku)->get();
        if (count($detail) > 0) {
            return redirect()->back()->with(AlertFormatter::warning('Bahan baku telah ditambahkan!'));
        }

        $detail = new DetailProduksi;
        $detail->id_produksi = $id;
        $detail->id_bahan_baku = $request->id_bahan_baku;
        $detail->jumlah = $request->jumlah;
        if ($detail->save()) {
            return redirect()->back()->with(AlertFormatter::success('Berhasil menambahkan bahan baku!'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Gagal menambahkan bahan baku!'));
    }

    public function updateDetail(Request $request, $id, $idDetail)
    {
        $request->validate([
            'id_bahan_baku' => 'required|numeric',
            'jumlah'    => 'required|numeric'
        ]);

        $detail = DetailProduksi::findOrFail($idDetail);
        $detail->id_produksi = $id;
        $detail->id_bahan_baku = $request->id_bahan_baku;
        $detail->jumlah = $request->jumlah;
        if ($detail->save()) {
            return redirect()->back()->with(AlertFormatter::success('Berhasil mengubah bahan baku!'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Gagal mengubah bahan baku!'));
    }

    public function deleteDetail(Request $request, $id, $idDetail)
    {
        if (DetailProduksi::destroy($idDetail)) {
            return redirect()->back()->with(AlertFormatter::success('Berhasil menghapus bahan baku!'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Gagal menghapus bahan baku!'));
    }

    public function final(Request $request, $id)
    {
        $request->validate([
            "id_produk" => 'required',
            "jumlah" => 'required',
        ]);

        
        DB::beginTransaction();
        try {

            $produksi = Produksi::with('detail')->findOrFail($id);
            if (count($produksi->detail) <= 0) {
                throw new \Exception('Belum ada bahan baku yaang di tambahkan!');
            }

            foreach ($produksi->detail as $key => $value) {
                $stok = StokPersediaan::where('id_bahan_baku', $value->id_bahan_baku)->first();
                if ($stok) {
                    $stok->stok -= $value->jumlah;
                } else {
                    $stok = new StokPersediaan;
                    $stok->id_bahan_baku = $value->id_bahan_baku;
                    $stok->stok = 0 - $value->jumlah;
                }
                if (!$stok->save()) {
                    throw new \Exception("Kesalahan saat memperbarui stok persediaan", 1);
                }
            }
            $produksi->status = 'final';
            if (!$produksi->save()) {
                throw new \Exception("Kesalahan saat memperbarui status produksi", 1);
            }

            $kehadiran = Kehadiran::where('id_produksi', $id)->get();
            if (count($kehadiran) <= 0) {
                throw new \Exception("Harap tambahkan data kehadiran", 1);
            }

            $produksi->id_produk = $request->id_produk;
            $produksi->jumlah   = $request->jumlah;
            
            if(!$produksi->save()){
                throw new \Exception("Gagal menyimpan data produksi", 1);
            }

            DB::commit();
            return redirect()->route('production')->with(AlertFormatter::success('Berhasil memfinalkan produksi.'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(AlertFormatter::danger('Gagal memfinalkan produksi. ' . $e->getMessage()));
        }
    }

    public function kehadiran(Request $request, $id)
    {
        if (!$request->input('kehadiran')) {
            return redirect()->back()->with(AlertFormatter::danger('Tidak dapat menyimpan data kehadiran. Harap pilih pekerja'));
        }

        Kehadiran::where('id_produksi', $id)->delete();
        foreach ($request->input('kehadiran') as $key => $value) {
            $kehadiran = new Kehadiran;
            $kehadiran->id_produksi = $id;
            $kehadiran->id_pekerja = $value;
            $kehadiran->status_kehadiran = true;
            $kehadiran->save();
        }
        return redirect()->back()->with(AlertFormatter::success('Kehadiran berhasil di simpan!'));
    }
}
