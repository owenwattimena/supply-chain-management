<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AlertFormatter;
use App\Models\Pekerja;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductionWorkerController extends Controller
{
    public function index()
    {
        $data['pekerja'] = Pekerja::all();
        return view('admin.produksi.pekerja.index', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'nik'   => 'unique:pekerja,nik',
            'nama'  => 'required',
            'tempat_lahir'  => 'required',
            'tanggal_lahir'  => 'required',
            'jenis_kelamin'  => 'required',
            'alamat'  => 'required',
            'agama'  => 'required',
        ]);

        $pekerja = new Pekerja;
        $pekerja->nik = $request->nik;
        $pekerja->nama = $request->nama;
        $pekerja->tempat_lahir = $request->tempat_lahir;
        $pekerja->tanggal_lahir = $request->tanggal_lahir;
        $pekerja->jenis_kelamin = $request->jenis_kelamin;
        $pekerja->alamat = $request->alamat;
        $pekerja->agama = $request->agama;

        if ($pekerja->save()) {
            return redirect()->back()->with(AlertFormatter::success('Pekerja berhasil di tambahkan!'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Pekerja gagal di tambahkan!'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nik'   => 'unique:pekerja,nik,' . $id,
            'nama'  => 'required',
            'tempat_lahir'  => 'required',
            'tanggal_lahir'  => 'required',
            'jenis_kelamin'  => 'required',
            'alamat'  => 'required',
            'agama'  => 'required',
        ]);

        $pekerja = Pekerja::findOrFail($id);
        $pekerja->nik = $request->nik;
        $pekerja->nama = $request->nama;
        $pekerja->tempat_lahir = $request->tempat_lahir;
        $pekerja->tanggal_lahir = $request->tanggal_lahir;
        $pekerja->jenis_kelamin = $request->jenis_kelamin;
        $pekerja->alamat = $request->alamat;
        $pekerja->agama = $request->agama;

        if ($pekerja->save()) {
            return redirect()->back()->with(AlertFormatter::success('Pekerja berhasil di ubah!'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Pekerja gagal di ubah!'));
    }

    public function delete(Request $request, $id)
    {
        if (Pekerja::destroy($id)) {
            return redirect()->back()->with(AlertFormatter::success('Pekerja berhasil di hapus!'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Pekerja gagal di hapus!'));
    }
}
