<?php

namespace App\Repositories;

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

        if (Auth::user()->role == 1) {
            $bank_img = $request->bank_image;
            if (isset($bank_img)) {
                if($user->bank_image){
                    unlink(public_path($user->bank_image));
                }
                $bank_img_name = 'upload/bank/img/' . $date . '/' . Str::random(10) . rand() . '.' . $bank_img->getClientOriginalExtension();
                $destinationPath = public_path('upload/bank/img/' . $date);
                $bank_img->move($destinationPath, $bank_img_name);

                $user->bank_image = $bank_img_name;
            }
            $user->bank_name = $request->bank_name;
            $user->bank_number = $request->bank_number;
            $user->bank_branch = $request->bank_branch;
        }
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();
    }

    public function delete($id)
    {
        return User::find($id);
    }

    public function getAdmin()
    {
        return User::find(1);
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

    public static function utf8convert($str) {

        if(!$str) return false;

        $utf8 = array(

            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',

            'd'=>'đ|Đ',

            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',

            'i'=>'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',

            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',

            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',

            'y'=>'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',

        );

        foreach($utf8 as $ascii=>$uni) $str = preg_replace("/($uni)/i",$ascii,$str);

        return $str;

    }
}
