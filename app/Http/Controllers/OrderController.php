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
        return $this->repository->getServicePack($id);
    }

    public function order(Request $request, $service_id){
        try {
            if(empty($request->url)){
                return response()->json([
                    'success' => false,
                    'msg' => 'Vui lòng nhập ID hoặc link!'
                ]);
            }
            // if(Auth::user()->amount < $request->amount){
            //     return response()->json([
            //         'success' => false,
            //         'msg' => 'Số dư của bạn không đủ để đặt đơn hàng này!'
            //     ]);
            // }
            $this->repository->store($request, $service_id);
            return response()->json([
                'success' => true,
                'msg' => 'Đặt đơn thành công'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'msg' => 'Đã xảy ra lỗi!'
            ]);
        }
    }
}
