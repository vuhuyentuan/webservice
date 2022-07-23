<?php

namespace App\Http\Controllers;

use App\Models\ServiceBill;
use App\Models\User;
use App\Models\UserTransaction;
use App\Repositories\AdminRepository;
use Carbon\CarbonPeriod;
use Exception;
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
        if (request()->ajax()) {
            if(request()->dates)
            {
                $first_day = date('Y-m-d', strtotime(str_replace('/', '-', explode(' - ', request()->dates)[0])));
                $last_day = date('Y-m-d', strtotime(str_replace('/', '-', explode(' - ', request()->dates)[1])));
            }
            $period = CarbonPeriod::create($first_day, $last_day);
            foreach($period as $date)
            {
                $dates[] = $date->format('Y-m-d');
            }

            // $service_accounts = ServiceAccounts::count();
            $user = User::where('role',0)->whereDate('created_at', '>=', $first_day)->whereDate('created_at', '<=', $last_day)->count();
            $service_bill_done = ServiceBill::where('status','completed')->whereDate('created_at', '>=', $first_day)->whereDate('created_at', '<=', $last_day)->count();
            $service_bill_pending = ServiceBill::where('status','pending')->whereDate('created_at', '>=', $first_day)->whereDate('created_at', '<=', $last_day)->count();
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
                'service_bill_pending'             => $service_bill_pending,
                'service_bill_done'             => $service_bill_done,
                'user'                      => $user,
                'user_bills'                => $user_bills,
                'first_day'                 => $first_day,
                'last_day'                  => $last_day,
                'dates'                     => $dates,
                'arrRevenueMonthDone'       => $arrRevenueMonthDone,
                'arrRevenueMonthPending'    => json_encode($arrRevenueMonthPending),
                'totalRevenueFromToDate'    => $totalRevenueFromToDate
            ];

            return response()->json([
                'success' => 200,
                'table' => view('admin.partials.statistical_table', compact('arrRevenueMonthDone', 'dates'))->render(),
                'data' => $viewData
            ]);
        }
        $first_day = date('Y-m-01', strtotime($date));
        $last_day = date('Y-m-t', strtotime($date));
        return view('admin.index', compact('first_day', 'last_day'));
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
                ->editColumn('created_at', '{{date("d/m/Y H:i", strtotime($created_at))}}')
                ->rawColumns(['avatar', 'status'])
                ->make(true);;
        }
        return view('admin.recharge_history', compact('first_day', 'last_day'));
    }

    public function history(Request $request)
    {
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
                ->addColumn('service', '{{$service_name}} - {{$svp_name}}')
                ->editColumn('avatar', function($row){
                    $html = '<div class="d-flex px-2 py-1">
                            <div>
                                <img src="https://ui-avatars.com/api/?name='. $row->user_name .'" width="38px" height="38px" class="rounded-circle avatar">
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
                    $html = '<a href="javascript:void(0)" data-href="'.route('view.status', $row->id).'" class="edit_status"><span class="badge badge-warning">Đang xử lý</span></a>';
                    if ($row->status == 'running') {
                        $html = '<a href="javascript:void(0)" data-href="'.route('view.status', $row->id).'" class="edit_status"><span class="badge badge-info">Đang chạy</span></a>';
                    }elseif($row->status == 'completed'){
                        $html = '<span class="badge badge-success">Hoàn thành</span>';
                    }elseif($row->status == 'cancel'){
                        $html = '<span class="badge badge-danger">Đã hủy</span>';
                    }

                    return $html;
                })
                ->editColumn('quantity', '{{@number_format($quantity)}}')
                ->editColumn('amount', '{{@number_format($amount)}} đ')
                ->editColumn('created_at', '{{date("d/m/Y H:i", strtotime($created_at))}}')
                ->rawColumns(['avatar','status', 'created_at', 'service'])
                ->make(true);;
        }
        return view('admin.purchase_history', compact('first_day', 'last_day'));
    }

    public function viewStatus($id)
    {
        $status = $this->repository->getServiceBill($id);
        return view('admin.orders.edit', compact('status'));
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $this->repository->updateStatus($request, $id);
            return response()->json([
                'success' => true,
                'msg' => 'Cập nhật trạng thái thành công'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Đã xảy ra lỗi!'
            ]);
        }
    }
}
