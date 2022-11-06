<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\AlertFormatter;
use App\Models\PemesananBahanBaku;
use App\Http\Controllers\Controller;
use App\Models\BahanBaku;
use Illuminate\Support\Facades\Auth;
use App\Services\OrderRawMaterialService;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderRawMaterialController extends Controller
{
    public function index()
    {

        $data['supplier'] = User::where('role', 'supplier')->get();
        if (auth()->user()->role == 'supplier') {
            $data['order'] = PemesananBahanBaku::with('cancelBy')->where('id_supplier', auth()->user()->id)->get();
        } else {
            $data['order'] = PemesananBahanBaku::all();
        }

        return view('admin.pemesanan-bahan-baku.index', $data);
    }

    public function order(Request $request)
    {
        $request->validate([
            "nomor_pesanan" => "required",
            "id_supplier"   => "required"
        ]);
        try {
            $result = OrderRawMaterialService::order($request);
            if ($result != false) {
                return redirect()->route("order-raw-material.show", $result)->with(AlertFormatter::success('Pesanan Bahan baku berhasil di buat!'));
            }
            return redirect()->back()->with(AlertFormatter::danger('Pesanan Bahan baku gagal di buat!'));
        } catch (\Exception $e) {
            return redirect()->back()->with(AlertFormatter::danger($e->getMessage()));
        }
    }

    public function show($id)
    {
        $data['pesanan'] = PemesananBahanBaku::with(['cancelBy', 'material' => function ($query) {
            return $query->with([
                'harga',
                'rawMaterial' => function ($query) {
                    return $query->with([
                        'harga' => function ($query) {
                            return $query->where('status', true);
                        }
                    ]);
                }
            ])->get();
        }])->findOrFail($id);
        // dd($data);
        if (auth()->user()->role == 'supplier') {
            if (auth()->user()->id != $data['pesanan']->id_supplier) return abort(404);
        }

        if ($data['pesanan']->status == 'draft') {
            $data['bahanBaku'] = BahanBaku::where('di_buat_oleh', $data['pesanan']->id_supplier)->get();
            if (auth()->user()->role == 'supplier') return redirect()->route('order-raw-material');
        }

        return view('admin.pemesanan-bahan-baku.detail', $data);
    }

    public function orderMaterial(Request $request, $id)
    {
        $request->validate([
            "id_bahan_baku" => "required",
            "kuantitas" => "required"
        ]);
        try {
            $result = OrderRawMaterialService::orderMaterial($request, $id);
            if ($result) {
                return redirect()->back();
            }
            return redirect()->back()->with(AlertFormatter::warning('Bahan baku gagal ditambahkan!'));
        } catch (\Exception $e) {
            return redirect()->back()->with(AlertFormatter::danger($e->getMessage()));
        }
    }
    public function updateOrderMaterial(Request $request, $id, $idDetail)
    {
        $request->validate([
            "id_bahan_baku" => "required",
            "kuantitas" => "required"
        ]);
        try {
            $result = OrderRawMaterialService::updateOrderMaterial($request, $id, $idDetail);
            if ($result) {
                return redirect()->back()->with(AlertFormatter::success('Bahan baku berhasil diubah!'));
            }
            return redirect()->back()->with(AlertFormatter::warning('Bahan baku gagal diubah!'));
        } catch (\Exception $e) {
            return redirect()->back()->with(AlertFormatter::danger($e->getMessage()));
        }
    }

    public function deleteOrderMaterial($id, $idDetail)
    {
        try {
            $result = OrderRawMaterialService::deleteOrderMaterial($idDetail);
            if ($result > 0) {
                return redirect()->back()->with(AlertFormatter::success('Bahan baku berhasil hapus!'));
            }
            return redirect()->back()->with(AlertFormatter::danger('Bahan baku gagal hapus!'));
        } catch (\Exception $e) {
            return redirect()->back()->with(AlertFormatter::danger($e->getMessage()));
        }
    }

    public function status(Request $request, int $id)
    {
        $status = $request->query('status');
        if (!in_array($status, config('constants.order.status')))
            return redirect()->back()->with(AlertFormatter::danger('Coba lagi!'));

        $result = OrderRawMaterialService::status($id, $status);
        if ($result) {
            switch ($status) {
                case 'pending':
                    return redirect()->route('order-raw-material')->with(AlertFormatter::success('Pesanan berhasil di order!'));
                    break;
                case 'proses':
                    return redirect()->route('order-raw-material')->with(AlertFormatter::success('Pesanan berhasil di proses!'));
                    break;
                default:
                    return redirect()->route('order-raw-material')->with(AlertFormatter::success('Pesanan berhasil di order!'));
                    break;
            }
        }
        return redirect()->back()->with(AlertFormatter::danger('Pesanan gagal di order!'));
    }

    public function unduh($id)
    {
        $data['pesanan'] = PemesananBahanBaku::with(['material' => function ($query) {
            return $query->with(['rawMaterial' => function ($query) {
                return $query->with(['harga' => function ($query) {
                    return $query->where('status', true);
                }]);
            }])->get();
        }])->findOrFail($id);
        // return view('admin.pemesanan-bahan-baku.unduh',$data);

        $pdf = Pdf::loadView('admin.pemesanan-bahan-baku.unduh', $data);
        return $pdf->stream();
    }
}
