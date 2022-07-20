<?php

namespace App\Http\Controllers;

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
        return view('users.order', compact('service'));
    }

    public function getServicePack($id){
        return $this->repository->getServicePack($id);
    }
}
