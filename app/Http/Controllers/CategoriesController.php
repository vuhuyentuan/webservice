<?php

namespace App\Http\Controllers;

use App\Repositories\CategoriesRepository;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $repository;

    public function __construct(CategoriesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        if (request()->ajax()) {
            $categories = $this->repository->getAllCategory();
           return DataTables::of($categories)
                ->addColumn('action' , function($row){
                    $html = '<button type="button" data-href="'.route('categories.edit',$row->id).'" class="btn btn-outline-info btn-not-radius modal-btn edit_category btn-hover"><i class="fa fa-edit"></i></button>&nbsp;
                                            <button type="button" data-href="'.route('categories.destroy',$row->id).'" data-name="'.$row->name.'" class="btn btn-outline-danger btn-not-radius delete-btn delete_category btn-hover" ><i class="fa fa-trash"></i></button>';
                    return $html;
                })
                ->editColumn('image', function($row){
                    if ($row->image) {
                        $html = '<img src="'.$row->image.'" width="38px" height="38px" class="rounded-circle avatar">';
                    }else{
                        $html = '<img src="'.asset('AdminLTE-3.1.0/dist/img/no_img.jpg').'" width="38px" height="38px" class="rounded-circle avatar">';
                    }

                    return $html;
                })
                ->editColumn('status', function($row){
                    if ($row->status == 'show') {
                        $html = '<span class="badge badge-success">Hiển thị</span>';
                    }else{
                        $html = '<span class="badge badge-secondary">Ẩn</span>';
                    }
                    return $html;
                })
                ->rawColumns(['image', 'action', 'status'])
                ->make(true);;
        }
        return view('admin.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->repository->create($request);
            return response()->json([
                'success' => true,
                'msg' => 'Thêm danh mục thành công'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Đã xảy ra lỗi!'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = $this->repository->getCategory($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $this->repository->update($request);
            return response()->json([
                'success' => true,
                'msg' => 'Cập nhật danh mục thành công'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Đã xảy ra lỗi!'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return $this->repository->delete($request);
    }
}
