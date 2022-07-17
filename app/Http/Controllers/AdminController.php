<?php

namespace App\Http\Controllers;

use App\Models\ServiceBill;
use App\Models\User;
use App\Models\UserTransaction;
use App\Repositories\AdminRepository;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $repository;

    public function __construct(AdminRepository $repository)
    {
        $this->repository = $repository;
    }
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

    public function getRechargeHistory(Request $request)
    {
        $date =  date('Y-m-d');
        $first_day = date('Y-m-01', strtotime($date));
        $last_day = date('Y-m-t', strtotime($date));
        if (request()->ajax()) {
            $recharge_histories = $this->repository->getRechargeHistory();
            if (!empty($request->start_date) && !empty($request->end_date)) {
                $start = $request->start_date;
                $end =  $request->end_date;
                $recharge_histories->whereDate('user_transactions.created_at', '>=', $start)
                                ->whereDate('user_transactions.created_at', '<=', $end);
            }
            return DataTables::of($recharge_histories)
                ->editColumn('avatar', function($row){
                    $html = '<div class="d-flex px-2 py-1">
                            <div>
                                <img src="'.asset('assets/images/no_img.jpg').'" width="38px" height="38px" class="rounded-circle avatar">
                            </div>&nbsp;&nbsp;
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">'.$row->user_name.'</h6>
                                <p class="text-xs text-secondary mb-0">'.$row->email.'</p>
                            </div>
                        </div>';
                    if($row->avatar){
                        $html = '<div class="d-flex px-2 py-1">
                                <div>
                                    <img src="'.asset($row->avatar).'" width="38px" height="38px" class="rounded-circle avatar">
                                </div>&nbsp;&nbsp;
                                    <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">'.$row->user_name.'</h6>
                                    <p class="text-xs text-secondary mb-0">'.$row->email.'</p>
                                </div>
                            </div>';
                    }

                    return $html;
                })
                ->editColumn('status', function($row){
                    if ($row->status == 1) {
                        $html = '<span class="badge badge-success">'. __("paid") .'</span>';
                    }else{
                        $html = '<span class="badge badge-danger">'. __("unpaid") .'</span>';
                    }

                    return $html;
                })
                ->editColumn('amount', '+ {{@number_format($amount)}} đ')
                ->editColumn('created_at', '{{date("d/m/Y", strtotime($created_at))}}')
                ->rawColumns(['avatar', 'status'])
                ->make(true);;
        }
        return view('admin.recharge_history', compact('first_day', 'last_day'));
    }

    public function history(Request $request)
    {
        $service_bills = $this->repository->serviceBills()->get();
        $date =  date('Y-m-d');
        $first_day = date('Y-m-01', strtotime($date));
        $last_day = date('Y-m-t', strtotime($date));
        if (request()->ajax()) {
            $service_bills = $this->repository->serviceBills();
            if (!empty($request->start_date) && !empty($request->end_date)) {
                $start = $request->start_date;
                $end =  $request->end_date;
                $service_bills->whereDate('service_bills.created_at', '>=', $start)
                            ->whereDate('service_bills.created_at', '<=', $end);
            }
            return DataTables::of($service_bills)
                ->editColumn('image', function($row){
                    if ($row->image) {
                        $html = '<img src="'.$row->image.'" width="38px" height="38px" class="rounded-circle avatar">';
                    }else{
                        $html = '<img src="'.asset('assets/images/no_img.jpg').'" width="38px" height="38px" class="rounded-circle avatar">';
                    }
                    return $html;
                })
                ->editColumn('avatar', function($row){
                    $html = '<div class="d-flex px-2 py-1">
                            <div>
                                <img src="'.asset('assets/images/no_img.jpg').'" width="38px" height="38px" class="rounded-circle avatar">
                            </div>&nbsp;&nbsp;
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">'.$row->user_name.'</h6>
                                <p class="text-xs text-secondary mb-0">'.$row->email.'</p>
                            </div>
                        </div>';
                    if($row->avatar){
                        $html = '<div class="d-flex px-2 py-1">
                                <div>
                                    <img src="'.asset($row->avatar).'" width="38px" height="38px" class="rounded-circle avatar">
                                </div>&nbsp;&nbsp;
                                    <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">'.$row->user_name.'</h6>
                                    <p class="text-xs text-secondary mb-0">'.$row->email.'</p>
                                </div>
                            </div>';
                    }

                    return $html;
                })
                ->editColumn('country', function($row){
                    $html = '';
                    if ($row->country) {
                        $html = '<img src="'.asset('assets/flag/'.$row->country.'.png').'"  width="35px" height="25px"  title="'.$row->country_name.'">';
                    }
                    return $html;
                })
                ->editColumn('account', function($row){
                    $html = '<button type="button" class="btn btn-outline-info btn-not-radius modal-btn btn-hover" data-toggle="modal" data-target="#view'. $row->id.'"><i class="fa fa-eye"></i></button>';
                    return $html;
                })
                ->editColumn('status', function($row){
                    $html = '';
                    if ($row->status == "completed") {
                        $html = '<span class="badge badge-success">'. __("successfully") .'</span>';
                    }

                    return $html;
                })
                ->editColumn('amount', '{{@number_format($amount)}} đ')
                ->rawColumns(['image', 'avatar', 'country', 'status', 'account'])
                ->make(true);;
        }
        return view('admin.purchase_history', compact('service_bills', 'first_day', 'last_day'));
    }
}
