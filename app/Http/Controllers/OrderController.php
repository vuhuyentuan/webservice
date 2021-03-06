<?php

namespace App\Http\Controllers;

use App\Models\ServiceBill;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    protected $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getService($slug){
        $service = $this->repository->getService($slug);
        return view('users.orders.index', compact('service'));
    }

    public function getServicePack($id){
        $service_pack = $this->repository->getServicePack($id);
        return $this->repository->getServicePackData($service_pack);
    }

    public function order(Request $request, $service_id){
        try {
            if(empty($request->url)){
                return response()->json(['success' => false, 'msg' => 'Vui lòng nhập ID hoặc link!']);
            }
            if(empty($request->service_pack)){
                return response()->json(['success' => false, 'msg' => 'Vui lòng chọn gói dịch vụ!']);
            }
            if($request->type == 'feeling'){
                if(empty($request->feeling)){
                    return response()->json(['success' => false, 'msg' => 'Vui lòng chọn cảm xúc!']);
                }
            }else if($request->type == 'comment'){
                if(empty($request->comment)){
                    return response()->json(['success' => false, 'msg' => 'Vui lòng nhập nội dung bình luận!']);
                }
            }else if ($request->type == 'eyes'){
                if(empty($request->eyes)){
                    return response()->json(['success' => false, 'msg' => 'vui lòng nhập thời gian!']);
                }
            }
            if($request->vip = 'vip'){
                if(empty($request->vip)){
                    return response()->json(['success' => false, 'msg' => 'vui lòng nhập số ngày!']);
                }
            }
            if($request->type != 'comment' && empty($request->quantity)){
                return response()->json(['success' => false, 'msg' => 'Vui lòng nhập số lượng!']);
            }
            if(Auth::user()->amount < $request->amount){
                return response()->json([
                    'success' => false,
                    'msg' => 'Số dư của bạn không đủ để đặt đơn hàng này!'
                ]);
            }
            $service_pack = $this->repository->getServicePack($request->service_pack);
            $quantity = $request->quantity;
            if(!empty($request->comment)){
                $quantity = $request->total_lines;
            }
            if($quantity < $service_pack->min){
                return response()->json([
                    'success' => false,
                    'msg' => 'Số lượng tối thiểu của gói dịch vụ là '. $service_pack->min
                ]);
            }
            $this->repository->store($request, $service_id);
            return response()->json([
                'success' => true,
                'msg' => 'Đặt đơn thành công'
            ]);
        } catch (\Throwable $th) {
            dd($th);
            return response()->json([
                'success' => false,
                'msg' => 'Đã xảy ra lỗi!'
            ]);
        }
    }

    public function historyShow(Request $request)
    {
        $service_bill = $this->repository->getServiceBill($request->id);
        return view('show.show_history', compact('service_bill'))->render();
    }
}
