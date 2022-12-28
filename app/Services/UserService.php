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

        return $user->save();
    }

    static function delete($id)
    {
        return User::destroy($id);
    }
}