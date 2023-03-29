<?php 

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserService {

    static function get()
    {
        return User::all();
    }

    static function store(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->password = Hash::make( $request->password );
        $user->role = $request->role;

        if($request->role == 'supplier')
        {
            $user->alamat   = $request->alamat;
            $user->no_hp   = $request->no_hp;
            $user->email   = $request->email;
            $user->web   = $request->web;
        }
        else if($request->role == 'supplier_pasir')
        {
            $user->nik   = $request->nik;
            $user->alamat   = $request->alamat;
            $user->no_hp   = $request->no_hp;
            $user->no_plat   = $request->no_plat;
            // stnk
            $path = $request->file('stnk')->getClientOriginalName();
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename_path = md5(time() . uniqid()) . '.' . $ext;
            file_put_contents(public_path('/stnk') . "/" . $filename_path, file_get_contents($request->stnk));
            $user->stnk = $filename_path;

        }

        return $user->save();
    }
    static function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->username = $request->username;
        if($request->password)
        {
            $user->password = Hash::make( $request->password );
        }
        $user->role = $request->role;

        if($request->role == 'supplier')
        {
            $user->alamat   = $request->alamat;
            $user->no_hp   = $request->no_hp;
            $user->email   = $request->email;
            $user->web   = $request->web;
            // 
            $user->nik   = null;
            $user->no_plat   = null;
            $user->stnk = null;


        }
        else if($request->role == 'supplier_pasir')
        {
            $user->nik   = $request->nik;
            $user->alamat   = $request->alamat;
            $user->no_hp   = $request->no_hp;
            $user->no_plat   = $request->no_plat;
            // stnk
            if($request->file('stnk')){
                if (file_exists( public_path('/stnk') . "/" . $user->stnk )) {
                    unlink( public_path('/stnk') . "/" . $user->stnk );
                } 
                $path = $request->file('stnk')->getClientOriginalName();
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $filename_path = md5(time() . uniqid()) . '.' . $ext;
                file_put_contents(public_path('/stnk') . "/" . $filename_path, file_get_contents($request->stnk));
                $user->stnk = $filename_path;
            }
            // 
            $user->email   = null;
            $user->web   = null;
        }else{
            $user->nik   = null;
            $user->no_plat   = null;
            $user->email   = null;
            $user->web   = null;
            $user->alamat   = null;
            $user->no_hp   = null;
            if($user->stnk){

                if (file_exists( public_path('/stnk') . "/" . $user->stnk ) ) {
                    unlink( public_path('/stnk') . "/" . $user->stnk );
                }
            }
            $user->stnk = null;
        }

        return $user->save();
    }

    static function delete($id)
    {
        return User::destroy($id);
    }
}