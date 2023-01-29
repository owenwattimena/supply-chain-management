<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Helpers\AlertFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!in_array(Auth::user()->role, config('constants.access.menu.master_user'))) {
                return abort(404);
            }
            return $next($request);
        });
    }

    public function index()
    {
        $data['users'] = UserService::get()->where('id', '!=', auth()->user()->id)->where('role', '!=', 'developer');
        return view('admin.users.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            "name"  => "required",
            "username"  => "required|unique:users,username",
            "password"  => "required",
            // "email"     => "email",
            "role"      => "required"
        ]);

        try {
            if (UserService::store($request)) {
                return redirect()->back()->with(AlertFormatter::success('Pengguna berhasil di tambahkan!'));
            }
            return redirect()->back()->with(AlertFormatter::danger('Pengguna gagal di tambahkan!'));
        } catch (\Exception $e) {
            return redirect()->back()->with(AlertFormatter::danger('Error! ' . $e->getMessage()));
        }
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            "name"  => "required",
            "username"  => "required|unique:users,username,{$id}",
            // "email"     => "email",
            "role"      => "required"
        ]);

        try {
            if (UserService::update($request, $id)) {
                return redirect()->back()->with(AlertFormatter::success('Pengguna berhasil di ubah!'));
            }
            return redirect()->back()->with(AlertFormatter::danger('Pengguna gagal di ubah!'));
        } catch (\Exception $e) {
            return redirect()->back()->with(AlertFormatter::danger('Error! ' . $e->getMessage()));
        }
    }

    public function delete($id)
    {
        try {
            if (UserService::delete($id) > 0) {
                return redirect()->back()->with(AlertFormatter::success('Pengguna berhasil di hapus!'));
            }
            return redirect()->back()->with(AlertFormatter::danger('Pengguna gagal di hapus!'));
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with(AlertFormatter::danger( 'Tidak dapat menghapus data berelasi.' ));
        }
    }
}
