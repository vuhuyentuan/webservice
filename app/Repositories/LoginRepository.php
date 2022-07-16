<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginRepository
{
    /**
     * Get member collection paginate.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */

    public function createUser($request)
    {
        if($request->all()){
            $user = new User();
            $user->name = $request->name;
            $user->code_name = 'naptien'.rand(100000,999999);
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->recovery_password =$request->password;
            $user->user_token = Str::random(30);
            $user->save();
            return true;
        }else{
            return false;
        }
    }
}
