<?php

namespace App\Http\Controllers\Admin;

use App\Models\Satuan;
use Illuminate\Http\Request;
use App\Helpers\AlertFormatter;
use App\Http\Controllers\Controller;

class UnitController extends Controller
{
    public function index()
    {
        $data['satuan'] = Satuan::all();
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
        if(Satuan::destroy($id)){
            return redirect()->back()->with(AlertFormatter::success('Satuan berhasil di hapus!'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Satuan gagal di hapus!'));
    }
}
