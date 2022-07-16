<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Repositories\ServiceRepository;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $repository;

    public function __construct(ServiceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        if (request()->ajax()) {
            $services = $this->repository->getAllService();
           return DataTables::of($services)
                ->addColumn('action' , function($row){
                    $html = '<button type="button" data-href="'.route('services.edit',$row->id).'" class="btn btn-outline-info btn-not-radius modal-btn edit_service btn-hover"><i class="fa fa-edit"></i></button>&nbsp;
                                            <button type="button" data-href="'.route('services.destroy',$row->id).'" data-name="'.$row->name.'" class="btn btn-outline-danger btn-not-radius delete-btn delete_service btn-hover" ><i class="fa fa-trash"></i></button>';
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
        return view('admin.services.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->repository->getCategory();
        return view('admin.services.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
        try {
            $this->repository->create($request);
            return response()->json([
                'success' => true,
                'msg' => 'Thêm dịch vụ thành công'
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
    public function show(Request $request)
    {
        return view('admin.services.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = $this->repository->getService($id);
        $categories = $this->repository->getCategory();
        return view('admin.services.edit', compact('service', 'categories'));
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
                'msg' => 'Cập nhật dịch vụ thành công'
            ]);
        }  catch (Exception $e) {
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
    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}
