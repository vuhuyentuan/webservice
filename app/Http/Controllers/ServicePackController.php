<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServicePackRequest;
use App\Repositories\ServicePackRepository;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ServicePackController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $repository;

    public function __construct(ServicePackRepository $repository)
    {
        $this->repository = $repository;
    }
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $service_accounts = $this->repository->getServicePack($request);
           return DataTables::of($service_accounts)
                ->addColumn('action' , function($row){
                    $html = '<button type="button" data-href="'.route('service_pack.edit', $row->id).'" class="btn btn-outline-info btn-not-radius modal-btn edit_service_pack"><i class="fa fa-edit"></i></button>&nbsp;
                                            <button type="button" data-href="'.route('service_pack.destroy', $row->id).'" data-name="'.$row->name.'" class="btn btn-outline-danger btn-not-radius delete-btn delete_service_pack btn-hover" ><i class="fa fa-trash"></i></button>';
                    return $html;
                })
                ->addColumn('addon' , function($row){
                    $comment = '';
                    $feeling = '';
                    $eyes = '';
                    $vip = '';
                    if ($row->comment == 'show') {
                        $comment = 'checked';
                    }
                    if ($row->feeling == 'show') {
                        $feeling = 'checked';
                    }
                    if ($row->eyes == 'show') {
                        $eyes = 'checked';
                    }
                    if ($row->vip == 'show') {
                        $vip = 'checked';
                    }
                    $html = '<div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"'.$feeling.' onchange="updateForm(this, '.$row->id.')" value="feeling">
                                            <label class="form-check-label"><b>Hiển thị ô chọn cảm xúc</b></label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"'.$comment.' onchange="updateForm(this, '.$row->id.')" value="comment">
                                            <label class="form-check-label"><b>Hiển thị ô nhập comment</b></label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"'.$eyes.' onchange="updateForm(this, '.$row->id.')" value="eyes">
                                            <label class="form-check-label"><b>Hiển thị ô chọn mắt</b></label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"'.$vip.' onchange="updateForm(this, '.$row->id.')" value="vip">
                                            <label class="form-check-label"><b>Hiển thị ô chọn viplike</b></label>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    return $html;
                })
                ->editColumn('price', '{{number_format($price)}} đ')
                ->editColumn('status', function($row){
                    if ($row->status == 'show') {
                        $html = '<span class="badge badge-success">Hiển thị</span>';
                    }else{
                        $html = '<span class="badge badge-secondary">Ẩn</span>';
                    }
                    return $html;
                })
                ->rawColumns(['action', 'status', 'addon'])
                ->make(true);
        }
        return view('admin.service_pack.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.service_pack.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServicePackRequest $request)
    {
        try {
            $this->repository->create($request);
            return response()->json([
                'success' => true,
                'msg' => 'Thêm gói dịch vụ thành công'
            ],200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Đã xảy ra lỗi'
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
        $service_pack = $this->repository->getServicePackId($id);
        return view('admin.service_pack.edit', compact('service_pack'));
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
                'msg' => 'Cập nhật gói dịch vụ thành công'
            ],200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Đã xảy ra lỗi'
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
        try {
            $this->repository->delete($id);
            return response()->json([
                'success' => true,
                'msg' => 'Xóa gói dịch vụ thành công'
            ],200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Đã xảy ra lỗi'
            ]);
        }
    }

    public function updateForm(Request $request)
    {
        try {
            $this->repository->updateForm($request);
            return response()->json([
                'success' => true,
                'msg' => 'Cập nhật thành công'
            ],200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Đã xảy ra lỗi'
            ]);
        }
    }
}
