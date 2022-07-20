<?php
namespace App\Repositories;

use App\Models\Service;
use App\Models\ServicePack;

class OrderRepository
{
    public function getService($slug){
        return Service::where('slug', $slug)->first();
    }

    public function getServicePack($id){
        return ServicePack::find($id);
    }

    public function order(){

    }
}
