<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Service;
use App\Models\ServiceAccounts;
use App\Models\ServicePack;
use App\Models\Services;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ServiceRepository
{
    /**
     * Get member collection paginate.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllService()
    {
        return Service::join('categories as cate', 'services.category_id', '=', 'cate.id')
                        ->select([
                            'services.*',
                            'cate.name as name_type',
                            'cate.image as cate_image',
                        ])
                        ->orderBy('id', 'desc');
    }

    public function getService($id)
    {
        return Service::find($id);
    }

    public function getCategory()
    {
        return Category::forDropdown();
    }

    public function create($request)
    {
        $service = new Service();
        $date = Carbon::now()->format('d-m-Y');
        $img = $request->image;
        if (isset($img)) {
            $img_name = 'upload/services/img/' . $date . '/' . Str::random(10) . rand() . '.' . $img->getClientOriginalExtension();
            $destinationPath = public_path('upload/services/img/' . $date);
            $img->move($destinationPath, $img_name);

            $service->image = $img_name;
        }
        $service->name = $request->name;
        $service->slug = Str::slug($request->name);
        $service->category_id = $request->category_id;
        $service->description = $request->description;
        $service->save();
    }

    public function update($request)
    {
        $service = Service::find($request->id);
        $date = Carbon::now()->format('d-m-Y');
        $img = $request->image;
        if (isset($img)) {
            if (isset($service->image)) {
                unlink(public_path($service->image));
            }
            $img_name = 'upload/services/img/' . $date . '/' . Str::random(10) . rand() . '.' . $img->getClientOriginalExtension();
            $destinationPath = public_path('upload/services/img/' . $date);
            $img->move($destinationPath, $img_name);

            $service->image = $img_name;
        }

        $service->name = $request->name;
        $service->slug = Str::slug($request->name);
        if ($request->category_id != '') {
            $service->category_id = $request->category_id;
        }
        $service->description = $request->description;
        $service->save();
    }

    public function destroy($request)
    {
        $service = Service::find($request->id);
        $count = ServicePack::where('service_id', $service->id)->count();

        if ($count == 0) {
            $service->delete();
            return response()->json([
                'success' => true,
                'msg' => 'Xóa thành công'
            ]);
        }else{
            return response()->json([
                'success' => false,
                'msg' => 'Tồn tại gói dịch vụ không thể xóa'
            ]);
        }
    }

}
