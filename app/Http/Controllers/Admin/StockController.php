<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\DetailPesanan;
use App\Http\Controllers\Controller;
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
        $data['stock'] = DetailPesanan::with(['rawMaterial','order' => function($query){
            return $query->where('status', 'final');
        }])->get()->where('order', '!=', null)->groupBy('rawMaterial.id');
        // dd($data);
        return view('admin.persediaan.index', $data);
    }
}
