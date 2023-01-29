<?php

namespace App\Http\Controllers\Admin;

use App\Models\Satuan;
use Illuminate\Http\Request;
use App\Helpers\AlertFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!in_array(Auth::user()->role, config('constants.access.menu.master_satuan'))) {
                return abort(404);
            }
            return $next($request);
        });
    }

    public function index()
    {
        $data['satuan'] = Satuan::orderBy('satuan')->get();
        return view('admin.satuan.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            "satuan" => "required"
        ]);

        try{
            $satuan = new Satuan;
            $satuan->satuan = $request->satuan;
    
            if($satuan->save())
            {
                return redirect()->back()->with(AlertFormatter::success('Satuan gagal di tambahkan!'));
            }
            return redirect()->back()->with(AlertFormatter::danger('Satuan berhasil di tambahkan!'));
        }catch(\Exception $e)
        {
            return redirect()->back()->with(AlertFormatter::danger($e->getMessage()));
        }

    }
    public function update(Request $request, $id)
    {
        $request->validate([
            "satuan" => "required"
        ]);

        try{
            $satuan = Satuan::findOrFail($id);
            $satuan->satuan = $request->satuan;
    
            if(!$satuan->save())
            {
                return redirect()->back()->with(AlertFormatter::danger('Satuan gagal di ubah!'));
            }
            return redirect()->back()->with(AlertFormatter::success('Satuan berhasil di ubah!'));
        }catch(\Exception $e)
        {
            return redirect()->back()->with(AlertFormatter::danger($e->getMessage()));
        }
    }
    
    public function delete($id)
    {
        try {
            if(Satuan::destroy($id)){
                return redirect()->back()->with(AlertFormatter::success('Satuan berhasil di hapus!'));
            }
            return redirect()->back()->with(AlertFormatter::danger('Satuan gagal di hapus!'));
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with(AlertFormatter::danger( 'Tidak dapat menghapus data berelasi.' ));
        }
    }
}
