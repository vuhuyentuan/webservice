<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CategoriesRepository
{
    /**
     * Get member collection paginate.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllCategory()
    {
        return Category::orderBy('id', 'desc');
    }

    public function getCategory($id)
    {
        return Category::find($id);
    }

    public function create($request)
    {
        $category = new Category();
        $date = Carbon::now()->format('d-m-Y');
        $img = $request->image;
        if (isset($img)) {
            $img_name = 'upload/services/img/' . $date . '/' . Str::random(10) . rand() . '.' . $img->getClientOriginalExtension();
            $destinationPath = public_path('upload/services/img/' . $date);
            $img->move($destinationPath, $img_name);

            $category->image = $img_name;
        }
        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();
    }

    public function update($request)
    {
        $category = Category::find($request->id);
        $date = Carbon::now()->format('d-m-Y');
        $img = $request->image;
        if (isset($img)) {
            if (isset($category->image)) {
                unlink(public_path($category->image));
            }
            $img_name = 'upload/services/img/' . $date . '/' . Str::random(10) . rand() . '.' . $img->getClientOriginalExtension();
            $destinationPath = public_path('upload/services/img/' . $date);
            $img->move($destinationPath, $img_name);

            $category->image = $img_name;
        }

        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();
    }

    public function delete($request)
    {
        $category =  Category::find($request->id);
        $services = Service::where('category_id', $request->id)->count();
        if ($services == 0) {
            $category->delete();
            return response()->json([
                'success' => true,
                'msg' => 'Xóa danh mục thành công'
            ]);
        }else{
            return response()->json([
                'success' => false,
                'msg' => 'Tồn tại nhóm dịch vụ không thể xóa!'
            ]);
        }
    }
}
