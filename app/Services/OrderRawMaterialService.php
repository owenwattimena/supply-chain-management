<?php 
namespace App\Services;

use App\Models\DetailPesanan;
use App\Models\HargaBahanBaku;
use Illuminate\Http\Request;
use App\Models\PemesananBahanBaku;
use Illuminate\Support\Facades\Auth;

class OrderRawMaterialService{
    static function order(Request $request)
    {
        $pesanan    = new PemesananBahanBaku;
        $pesanan->nomor_pesanan = $request->nomor_pesanan;
        $pesanan->id_supplier   = $request->id_supplier;
        $pesanan->dibuat_oleh   = Auth::user()->id;
        if($pesanan->save()) return $pesanan->id;
        return false;
    }
    static function orderMaterial(Request $request, $id)
    {

        $bahanBaku      = DetailPesanan::where('id_pesanan', $id)->where('id_bahan_baku', $request->id_bahan_baku)->get();
        
        if(count($bahanBaku) > 0) return false;

        $hargaBahanBaku = HargaBahanBaku::where('id_bahan_baku', $request->id_bahan_baku)->where('status', true)->first();
        
        $bahanBaku      = new DetailPesanan;
        $bahanBaku->id_pesanan    = $id;
        $bahanBaku->id_bahan_baku = $request->id_bahan_baku;
        $bahanBaku->kuantitas     = $request->kuantitas;
        $bahanBaku->id_harga     = $hargaBahanBaku->id;
        return $bahanBaku->save();
    }

    static function updateOrderMaterial(Request $request, $id, $idDetail)
    {
        $_bahanBaku      = DetailPesanan::where('id_pesanan', $id)->where('id_bahan_baku', $request->id_bahan_baku)->first();

        $bahanBaku      = DetailPesanan::findOrFail($idDetail);

        if($_bahanBaku)
        if($_bahanBaku->id != $idDetail) return false;
        $hargaBahanBaku = HargaBahanBaku::where('id_bahan_baku', $request->id_bahan_baku)->where('status', true)->first();
        

        $bahanBaku->id_pesanan    = $id;
        $bahanBaku->id_bahan_baku = $request->id_bahan_baku;
        $bahanBaku->kuantitas     = $request->kuantitas;
        $bahanBaku->id_harga      = $hargaBahanBaku->id;
        return $bahanBaku->save();
    }

    static function deleteOrderMaterial($idDetail)
    {
        return DetailPesanan::destroy($idDetail);
    }

    static function status(int $id, String $status)
    {
        $pesanan    = PemesananBahanBaku::findOrFail($id);
        $pesanan->status = $status;
        if($status == 'batal'){
            $pesanan->dibatalkan_oleh = auth()->user()->id;
        }
        return $pesanan->save();
    }
}