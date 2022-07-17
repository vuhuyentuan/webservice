<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BankRequest;
use App\Repositories\BankRepository;
use Yajra\DataTables\Facades\DataTables;

class BanksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $repository;

    public function __construct(BankRepository $repository)
    {
        $this->repository = $repository;
    }
    public function index()
    {
        if (request()->ajax()) {
            $query = $this->repository->getAll();
           return DataTables::of($query)
                ->addColumn('action' , function($row){
                    $html = '<button type="button" data-href="'.route('banks.edit',$row->id).'" class="btn btn-outline-info btn-not-radius modal-btn edit_bank btn-hover"><i class="fa fa-edit"></i></button>&nbsp;
                            <button type="button" data-href="'.route('banks.destroy',$row->id).'" data-account-number="'.$row->account_number.'" class="btn btn-outline-danger btn-not-radius delete-btn delete_bank btn-hover" ><i class="fa fa-trash"></i></button>';
                    return $html;
                })
                ->editColumn('image', function($row){
                    if ($row->image) {
                        $html = '<img src="'.$row->image.'" width="100px" height="70px" class="img-thumbnail">';
                    }else{
                        $html = '<img src="'.asset('AdminLTE-3.1.0/dist/img/no_img.jpg').'" width="100px" height="100px" class="rounded-circle avatar">';
                    }
                    return $html;
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }
        return view('admin.banks.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BankRequest $request)
    {
        try {
            $this->repository->create($request);
            return response()->json([
                'success' => true,
                'msg' => 'Thêm tài khoản ngân hàng thành công'
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
        $bank = $this->repository->getBank($id);
        return view('admin.banks.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $this->repository->update($request, $id);
            return response()->json([
                'success' => true,
                'msg' => 'Cập nhật thông tin tài khoản thành công'
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
        try {
            $this->repository->destroy($id);
            return response()->json([
                'success' => true,
                'msg' => 'Xoá tài khoản ngân hàng thành công'
            ]);
        }  catch (Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Đã xảy ra lỗi!'
            ]);
        }
    }
}
