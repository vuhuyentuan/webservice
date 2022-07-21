<?php

namespace App\Repositories;

use App\Models\HistoryTransaction;
use App\Models\ServiceBill;
use App\Models\User;
use App\Models\UserTransaction;

class AdminRepository
{
    /**
     * Get member collection paginate.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */

    public function getServiceBill($id)
    {
        return ServiceBill::find($id);
    }

    public function updateStatus($request, $id)
    {
        $bill = ServiceBill::find($id);
        $bill->status = $request->status;
        $bill->save();
        //user
        $user = User::find($bill->user_id);
        $amount_old = $user->amount;
        if ($request->status == 'cancel') {
            $user->amount = $user->amount + $bill->amount;
            $user->save();
        }

        //history
        $history = new HistoryTransaction();
        $history->user_id = $bill->user_id;
        $history->price = $bill->amount;
        $history->content = $bill->service->name.' - '.$bill->service_pack->name;
        $history->volatility = number_format($amount_old) . ' -> ' . number_format($user->amount);
        $history->status = 'return';
        $history->save();
    }

    public function getRechargeHistory()
    {
        return UserTransaction::join('users as u', 'user_transactions.user_id', '=', 'u.id')
                        ->select([
                            'user_transactions.*',
                            'u.name as user_name',
                            'u.avatar as avatar',
                            'u.email'
                        ])
                        ->orderBy('id', 'desc');
    }

    public function serviceBills()
    {
        return ServiceBill::join('users', 'service_bills.user_id', '=', 'users.id')
                            ->join('services as sv', 'service_bills.service_id', '=', 'sv.id')
                            ->join('service_packs as svp', 'svp.id', '=', 'service_bills.service_pack_id')
                            ->select([
                                'service_bills.*',
                                'sv.name as service_name',
                                'svp.name as svp_name',
                                'users.email as email',
                                'users.name as user_name',
                                'users.avatar as avatar'
                            ])
                            ->orderBy('id', 'desc');
    }
}
