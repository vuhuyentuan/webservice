<?php

namespace App\Http\Controllers;

use App\Models\ServiceBill;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

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
