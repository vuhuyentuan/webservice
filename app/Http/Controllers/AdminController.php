<?php

namespace App\Http\Controllers;

use App\Models\ServiceBill;
use App\Models\User;
use App\Models\UserTransaction;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $date =  date('Y-m-d');
        if($request->dates == null)
        {
            $first_day = date('Y-m-01', strtotime($date));
            $last_day = date('Y-m-t', strtotime($date));
        }
        else
        {
            $first_day = date('Y-m-d', strtotime(str_replace('/', '-', explode(' - ', $request->dates)[0])));
            $last_day = date('Y-m-d', strtotime(str_replace('/', '-', explode(' - ', $request->dates)[1])));
        }
        $period = CarbonPeriod::create($first_day, $last_day);
        foreach($period as $date)
        {
            $dates[] = $date->format('Y-m-d');
        }

        // $service_accounts = ServiceAccounts::count();
        $user = User::where('role',0)->count();
        $service_bills = ServiceBill::where('status','completed')->count();
        $user_bills = UserTransaction::where('status',1)->count();
        $revenueMonthDone = UserTransaction::whereRaw('month(user_transactions.created_at) BETWEEN "'.date('m', strtotime($first_day)).'" AND "'.date('m', strtotime($last_day)).'"')
            ->select(DB::raw('sum(user_transactions.amount) as totalMoney'), DB::raw('DATE(user_transactions.created_at) day'))
            ->where('user_transactions.status', 1)
            ->groupBy('day')
            ->get()
            ->toArray();
        $revenueMonthPending = UserTransaction::whereRaw('month(user_transactions.created_at) BETWEEN "'.date('m', strtotime($first_day)).'" AND "'.date('m', strtotime($last_day)).'"')
            ->select(DB::raw('sum(user_transactions.amount) as totalMoney'), DB::raw('DATE(user_transactions.created_at) day'))
            ->where('user_transactions.status', 1)
            ->groupBy('day')
            ->get()
            ->toArray();

        $arrRevenueMonthDone = [];
        $arrRevenueMonthPending = [];
        foreach ($dates as $day) {
            $total = 0;
            foreach ($revenueMonthDone as $key => $revenue) {

                if ($revenue['day'] == $day) {
                    $total = $revenue['totalMoney'];
                    break;
                }
            }


            $arrRevenueMonthDone[] = (int) $total;
            $total = 0;
            foreach ($revenueMonthPending as $key => $revenue) {
                if ($revenue['day'] == $day) {
                    $total = $revenue['totalMoney'];
                    break;
                }
            }
            $arrRevenueMonthPending[] = (int) $total;
        }

        $totalRevenueFromToDate = array_sum($arrRevenueMonthDone);
        $viewData = [
            // 'service_accounts'          => $service_accounts,
            'service_bills'             => $service_bills,
            'user'                      => $user,
            'user_bills'                => $user_bills,
            'first_day'                 => $first_day,
            'last_day'                  => $last_day,
            'dates'                     => $dates,
            'arrRevenueMonthDone'       => $arrRevenueMonthDone,
            'arrRevenueMonthPending'    => json_encode($arrRevenueMonthPending),
            'totalRevenueFromToDate'    => $totalRevenueFromToDate
        ];
        return view('admin.index', $viewData);
    }
}
