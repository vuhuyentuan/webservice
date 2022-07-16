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
        return ServicePack::where('service_id', $request->id)->orderby('id', 'desc');
    }

    public function getServicePackId($id)
    {
        return ServicePack::find($id);
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
        $service_pack = ServicePack::find($request->id);
        $service_pack->name = $request->name;
        $service_pack->price = str_replace(',','',$request->price);
        $service_pack->min = $request->min;
        $service_pack->description = $request->description;
        $service_pack->status = $request->status;
        $service_pack->save();
    }

    public function updateForm($request)
    {
        $service_pack = ServicePack::find($request->id);
        if ($request->name == 'comment') {
            $service_pack->comment = $request->status;
        }elseif($request->name == 'feeling'){
            $service_pack->feeling = $request->status;
        }
        $service_pack->save();
    }

    public function delete($id)
    {
        return ServicePack::find($id)->delete();
    }

}
