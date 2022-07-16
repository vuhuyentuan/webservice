<?php

namespace App\Repositories;

use App\Models\ServiceAccounts;
use App\Models\ServicePack;

class ServicePackRepository
{
    /**
     * Get member collection paginate.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getServicePack($request)
    {
        return ServicePack::where('service_id', $request->id);
    }

    public function getServicePackId($request)
    {
        return ServicePack::find($request->id);
    }

    public function create($request)
    {
        $service_pack = new ServicePack();
        $service_pack->service_id = $request->id;
        $service_pack->name = $request->name;
        $service_pack->price = str_replace(',','',$request->price);
        $service_pack->min = $request->min;
        $service_pack->description = $request->description;
        $service_pack->status = $request->status;
        $service_pack->save();
    }

    public function update($request)
    {
        $service_account = ServicePack::find($request->id);
        $service_account->account = $request->data_account;
        $service_account->save();
    }

    public function delete($request)
    {
        return ServicePack::find($request->id)->delete();
    }

}
