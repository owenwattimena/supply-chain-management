<?php

namespace App\Http\Controllers\Admin;

use App\Models\Produk;
use App\Models\Satuan;
use Illuminate\Http\Request;
use App\Helpers\AlertFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductionProductController extends Controller
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
        $data['satuan'] = Satuan::all();
        $data['produk'] = Produk::with('satuan')->get();
        return view('admin.produksi.produk.index', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'produk' => 'required',
            'id_satuan' => 'required'
        ]);

        $produk = new Produk();
        $produk->nama = $request->produk;
        $produk->keterangan = $request->keterangan;
        $produk->id_satuan = $request->id_satuan;
        if($produk->save())
        {
            return redirect()->back()->with(AlertFormatter::success('Berhasil menambahkan produk!'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Gagal menambahkan produk!'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'produk' => 'required',
            'id_satuan' => 'required'
        ]);

        $produk = Produk::findOrFail($id);
        $produk->nama = $request->produk;
        $produk->keterangan = $request->keterangan;
        $produk->id_satuan = $request->id_satuan;
        if($produk->save())
        {
            return redirect()->back()->with(AlertFormatter::success('Berhasil mengubah produk!'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Gagal mengubah produk!'));
    }
    
    public function delete(Request $request, $id)
    {
        
        if(Produk::destroy($id) > 0)
        {
            return redirect()->back()->with(AlertFormatter::success('Berhasil menghapus produk!'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Gagal menghapus produk!'));

    }
}
