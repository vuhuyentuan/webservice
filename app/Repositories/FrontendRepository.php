<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserTransaction;

class FrontendRepository
{
    /**
     * Get member collection paginate.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */

    public function autoBank($res, $id)
    {
       $res_json = json_decode($res);
       $space_remove = str_replace(' ', '.', $res_json->description);
       $arr_description = explode('.', $space_remove);
       $users = User::all();
       foreach($users as $user){
           $key = array_search($user->code_name, $arr_description);
           if($key != false){
               $code_name = $arr_description[$key];
               $amount = $res_json->amount;
               break;
           }else{
               if(isset($arr_description[3])){
                $momo = explode('-',$arr_description[3]);
                $key_momo = array_search($user->code_name, $momo);
                    if($key_momo != false){
                        $code_name = $momo[$key_momo];
                        $amount = $res_json->amount;
                        break;
                    }else{
                        $code_name = '123';
                        $amount = 0;
                    }
                }else{
                    $code_name = '123';
                    $amount = 0;
                }
           }
       }

       $update = User::where('code_name','=', $code_name)->first();
       if($update){
        $update->amount = $update->amount + $amount;
        $update->save();

        $user_bill = new UserTransaction();
        $user_bill->user_id = $update->id;
        $user_bill->order_id = $res_json->id;
        $user_bill->amount = $amount;
        $user_bill->description = "Nạp qua ngân hàng";
        $user_bill->status = 1;
        $user_bill->save();

        return response()->json([
            'success' => true
        ]);
       }else{
        return response()->json([
            'success' => false
        ]);
       }

    }

}
