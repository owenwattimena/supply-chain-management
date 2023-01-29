<?php

namespace App\Http\Controllers\Admin;

use App\Models\BahanBaku;
use Illuminate\Http\Request;
use App\Models\DetailPesanan;
use App\Http\Controllers\Controller;
use App\Models\StokPersediaan;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!in_array(Auth::user()->role, config('constants.access.menu.persediaan'))) {
                return abort(404);
            }
            return $next($request);
        });
    }
    
    public function index()
    {
        if(Auth::user()->role == 'supplier'|| Auth::user()->role == 'supplier_pasir'){
            $data['stock'] = BahanBaku::with(['satuan', 'stokSupplier', 'harga' => function($query){
                return $query->orderBy('created_at', 'desc');
            }])->where('di_buat_oleh', auth()->user()->id)->get();
        }else{
            $data['stock'] = StokPersediaan::with(['rawMaterial'])->get();
            // $data['stock'] = DetailPesanan::with(['rawMaterial','order' => function($query){
            //     return $query->where('status', 'final');
            // }])->get()->where('order', '!=', null)->groupBy('rawMaterial.id');
        }
        // dd($data);
        return view('admin.persediaan.index', $data);
    }
}
