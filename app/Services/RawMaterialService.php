<?php

namespace App\Services;

use App\Models\BahanBaku;
use Illuminate\Http\Request;
use App\Models\HargaBahanBaku;
use Illuminate\Support\Facades\Auth;

class RawMaterialService
{
    static function upsert(Request $request, $id = 0)
    {
        if($id <= 0)
        {
            $bahanBaku  = new BahanBaku;
        }else{
            $bahanBaku  = BahanBaku::findOrFail($id);
        }

        $bahanBaku->nomor_bahan_baku = $request->nomor_bahan_baku;
        $bahanBaku->nama_bahan_baku = $request->nama_bahan_baku;
        $bahanBaku->spesifikasi = $request->spesifikasi;
        $bahanBaku->id_satuan = $request->id_satuan;
        $bahanBaku->di_buat_oleh = Auth::user()->id;
        return $bahanBaku->save();
    }

    static function price(Request $request, $id)
    {
        $hargaLama = HargaBahanBaku::where('id_bahan_baku', $id)->get();
        if(count($hargaLama) > 0)
        {
            foreach ($hargaLama as $item) {
                $item->status = false;
                $item->save();
            }
        }
        $harga  = new HargaBahanBaku;
        $harga->id_bahan_baku = $id;
        $harga->harga_jual = $request->harga;
        return $harga->save();
    }
}