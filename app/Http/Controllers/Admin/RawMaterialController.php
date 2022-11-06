<?php

namespace App\Http\Controllers\Admin;

use App\Models\Satuan;
use App\Models\BahanBaku;
use Illuminate\Http\Request;
use App\Helpers\AlertFormatter;
use App\Http\Controllers\Controller;
use App\Services\RawMaterialService;
use Illuminate\Support\Facades\Auth;

class RawMaterialController extends Controller
{
    public function index()
    {
        if(auth()->user()->role == 'supplier'){
            $bahanBaku = BahanBaku::with(['satuan', 'harga' => function($query){
                return $query->orderBy('created_at', 'desc');
            }])->where('di_buat_oleh', auth()->user()->id)->get();
        }else{
            $bahanBaku = BahanBaku::with(['satuan', 'supplier', 'harga' => function($query){
                return $query->orderBy('created_at', 'desc');
            }])->get();
        }

        $data['satuan'] = Satuan::all();
        $data['bahanBaku'] = $bahanBaku;
        return view('admin.bahan-baku.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            "nomor_bahan_baku" => "required",
            "nama_bahan_baku"   => "required",
            "spesifikasi"   => "required",
            "id_satuan" => "required"
        ]);

        try {
            if(RawMaterialService::upsert($request))
            {
                return redirect()->back()->with(AlertFormatter::success('Bahan baku berhasil di tambahkan!'));
            }
            return redirect()->back()->with(AlertFormatter::danger('Bahan baku gagal di tambahkan!'));
        } catch (\Exception $e) {
            return redirect()->back()->with(AlertFormatter::danger($e->getMessage()));
        }
    }

    public function price(Request $request, $id)
    {
        $request->validate([
            "harga" => "required"
        ]);

        try {
            if(RawMaterialService::price($request, $id))
            {
                return redirect()->back()->with(AlertFormatter::success('Harga bahan baku berhasil ditambahkan!'));
            }
            return redirect()->back()->with(AlertFormatter::danger('Harga bahan baku gagal ditambahkan!'));
        } catch (\Exception $e) {
            return redirect()->back()->with(AlertFormatter::danger($e->getMessage()));
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "nomor_bahan_baku" => "required",
            "nama_bahan_baku"   => "required",
            "spesifikasi"   => "required",
            "id_satuan" => "required"
        ]);

        try {
            if(RawMaterialService::upsert($request, $id))
            {
                return redirect()->back()->with(AlertFormatter::success('Bahan baku berhasil di ubah!'));
            }
            return redirect()->back()->with(AlertFormatter::danger('Bahan baku gagal di ubah!'));
        } catch (\Exception $e) {
            return redirect()->back()->with(AlertFormatter::danger($e->getMessage()));
        }
    }

    public function delete($id)
    {
        if(BahanBaku::destroy($id) > 0)
        {
            return redirect()->back()->with(AlertFormatter::success('Bahan baku berhasil di hapus!'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Bahan baku gagal di hapus!'));
    }
}
