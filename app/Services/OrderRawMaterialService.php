<?php

namespace App\Services;

use Exception;
use App\Models\StokSupplier;
use Illuminate\Http\Request;
use App\Models\DetailPesanan;
use App\Models\HargaBahanBaku;
use App\Models\PenerimaanPesanan;
use App\Models\TransaksiSupplier;
use App\Models\PemesananBahanBaku;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\FotoPenerimaanPesanan;
use App\Models\DetailTransaksiSupplier;
use App\Models\StokPersediaan;

class OrderRawMaterialService
{
    static function order(Request $request)
    {
        $pesanan    = new PemesananBahanBaku;
        $pesanan->nomor_pesanan = $request->nomor_pesanan;
        $pesanan->id_supplier   = $request->id_supplier;
        $pesanan->dibuat_oleh   = Auth::user()->id;
        if ($pesanan->save()) return $pesanan->id;
        return false;
    }
    static function orderMaterial(Request $request, $id)
    {

        $bahanBaku      = DetailPesanan::where('id_pesanan', $id)->where('id_bahan_baku', $request->id_bahan_baku)->get();

        if (count($bahanBaku) > 0) return false;

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

        if ($_bahanBaku)
            if ($_bahanBaku->id != $idDetail) return false;
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

    static function status(int $id, String $status, Request $request)
    {
        DB::beginTransaction();

        try {
            $pesanan    = PemesananBahanBaku::with('material')->findOrFail($id);
            $pesanan->status = $status;
            if ($status != 'batal') {
                if (count($pesanan->material) <= 0) {
                    throw new Exception("Belum ada bahan baku yang di tambahkan!");
                }
            }
            if ($status == 'batal') {
                $pesanan->dibatalkan_oleh = auth()->user()->id;
            }

            if ($status == 'proses') {
                $transaksi = new TransaksiSupplier;
                $transaksi->dibuat_oleh = Auth::user()->id;
                $transaksi->tipe = 'keluar';
                $transaksi->status = 'pending';

                if (!$transaksi->save()) {
                    throw new Exception("Error pada saat membuat transaksi keluar!");
                }

                $pesanan->id_transaksi_supplier = $transaksi->id;

                foreach ($pesanan->material as $item) {
                    $detailTransaksi = new DetailTransaksiSupplier();
                    $detailTransaksi->id_transaksi_supplier = $transaksi->id;
                    $detailTransaksi->id_bahan_baku = $item->id_bahan_baku;
                    $detailTransaksi->jumlah = $item->kuantitas * (-1);

                    if (!$detailTransaksi->save()) {
                        throw new Exception("Error pada saat membuat detail transaksi keluar!");
                    }

                    $stok = StokSupplier::where('id_bahan_baku', $item->id_bahan_baku)->first();
                    if ($item->kuantitas > $stok->stok) {
                        throw new Exception("Jumlah pesanan melebihi stok!");
                    }
                    $stok->stok -= $item->kuantitas;

                    if (!$stok->save()) {
                        throw new Exception("Error pada saat memperbarui stok");
                    }
                }
            }

            if ($status == 'final') {

                foreach ($pesanan->material as $item) {
                    $stokPersediaan = StokPersediaan::where('id_bahan_baku', $item->id_bahan_baku)->first();

                    if ($stokPersediaan) {
                        $stokPersediaan->stok += $item->kuantitas;
                    } else {
                        $stokPersediaan = new StokPersediaan;
                        $stokPersediaan->id_bahan_baku = $item->id_bahan_baku;
                        $stokPersediaan->stok = $item->kuantitas;
                    }

                    if (!$stokPersediaan->save()) {
                        throw new Exception("Kesalahan saat memperbarui stok persediaan!");
                    }
                }

                $penerimaan = new PenerimaanPesanan();
                $penerimaan->id_pemesanan_bahan_baku = $id;
                $penerimaan->tanggal = date("Y-m-d H:i:s");
                $penerimaan->jam = date("H:i:s");
                $penerimaan->nomor_kendaraan = $request->nomor_kendaraan;
                $penerimaan->nama_pengemudi = $request->nama_pengemudi;

                if (!$penerimaan->save()) {
                    throw new Exception("Error pada saat memperbarui stok");
                }
                // Skript untuk multi image
                // foreach ($request->file('foto') as $file) {
                //     $path = $file->getClientOriginalName();
                //     $ext = pathinfo($path, PATHINFO_EXTENSION);
                //     $image_name = self::guidv4() . '.' . $ext;
                //     $file->move(public_path('/foto-penerimaan-pesanan'), $image_name);
                //     // $file->move(getcwd() . '/foto-penerimaan-pesanan', $image_name);
                //     $image_path = "/foto-penerimaan-pesanan/" . $image_name;

                //     $buktiFoto = new FotoPenerimaanPesanan;
                //     $buktiFoto->id_penerimaan_pesanan = $penerimaan->id;
                //     $buktiFoto->foto = $image_path;
                //     if (!$buktiFoto->save()) {
                //         throw new Exception("Error pada saat menyimpan gambar");
                //     }
                // }

                // script for url image
                $filename_path = md5(time() . uniqid()) . ".jpg";
                file_put_contents(public_path('/foto-penerimaan-pesanan') . "/" . $filename_path, file_get_contents($request->image));
                $buktiFoto = new FotoPenerimaanPesanan;
                $buktiFoto->id_penerimaan_pesanan = $penerimaan->id;
                $buktiFoto->foto = $filename_path;
                if (!$buktiFoto->save()) {
                    throw new Exception("Error pada saat menyimpan gambar");
                }

                $trans = TransaksiSupplier::findOrFail($pesanan->id_transaksi_supplier);
                $trans->status = 'final';
                $trans->final_at = date('Y-m-d H:i:s');
                if (!$trans->save()) {
                    throw new Exception("Error pada saat menyimpan data!");
                }
            }



            if (!$pesanan->save()) {
                throw new Exception("Error pada saat menyimpan data!");
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            return $e->getMessage();
        }
    }

    public function guidv4($data = null)
    {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
