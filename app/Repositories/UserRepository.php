<?php

namespace App\Repositories;

use App\Models\Bank;
use App\Models\User;
use App\Models\UserTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRepository
{
    /**
     * Get member collection paginate.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */

    public function getUserAll()
    {
        return User::where('role', '!=', 1)->latest('id');
    }

    public function getUser($id)
    {
        return User::find($id);
    }

    public function getAmount()
    {
        return User::where('id', Auth::user()->id)->select('amount')->get();
    }

    public function create($request)
    {
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'recovery_password' => $request->password,
            'user_token' =>  Str::random(30),
            'code_name' => 'naptien'.rand(100000,999999),
            'amount' => str_replace(',','', $request->amount)
        ]);
    }

    public function update($request)
    {
        $user = User::find($request->id);
        $user_data = $request->only(['name', 'email', 'phone', 'amount']);
        $user_data['amount'] = str_replace(',','', $request->amount);
        $user_data['password'] = $request->password ? $request->password : $user->password;
        $user->update($user_data);
    }

    public function updateInfo($request, $id)
    {
        $user = User::find($id);
        $date = Carbon::now()->format('d-m-Y');
        $img = $request->image;
        if (isset($img)) {
            if (isset($user->avatar)) {
                unlink(public_path($user->avatar));
            }
            $img_name = 'upload/users/img/' . $date . '/' . Str::random(10) . rand() . '.' . $img->getClientOriginalExtension();
            $destinationPath = public_path('upload/users/img/' . $date);
            $img->move($destinationPath, $img_name);

            $user->avatar = $img_name;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = $request->password ? Hash::make($request->password) : $user->password;
        $user->save();
    }

    public function delete($id)
    {
        return User::find($id);
    }

    public function getBanks()
    {
        return Bank::all();
    }

    public function getRechargeHistory()
    {
        $recharge_histories = UserTransaction::where('user_id', Auth::user()->id)
                        ->join('users as u', 'user_transactions.user_id', '=', 'u.id')
                        ->select([
                            'user_transactions.*',
                            'u.name as user_name',
                            'u.avatar as avatar',
                            'u.email'
                        ])
                        ->orderBy('id', 'desc');
        return $recharge_histories;
    }
}
