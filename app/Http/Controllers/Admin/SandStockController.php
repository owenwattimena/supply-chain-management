<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\StokPersediaan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SandStockController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!in_array(Auth::user()->role, config('constants.access.menu.persediaan_pasir'))) {
                return abort(404);
            }
            return $next($request);
        });
    }

    public function index()
    {

        $data['stock'] = StokPersediaan::with(['rawMaterial' => function($query){
            return $query->with('supplier');
        }])->get()->where('rawMaterial.supplier.role', 'supplier_pasir');
        // $data['stock'] = DetailPesanan::with(['rawMaterial','order' => function($query){
        //     return $query->where('status', 'final');
        // }])->get()->where('order', '!=', null)->groupBy('rawMaterial.id');

        // dd($data);
        return view('admin.persediaan.index', $data);
    }
}