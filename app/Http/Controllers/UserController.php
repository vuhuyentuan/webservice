<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        if (request()->ajax()) {
            $users = $this->repository->getUserAll();
            return DataTables::of($users)
                ->addColumn('action' , function($row){
                    $html = '<button type="button" data-href="'.route('users.edit', $row->id).'" class="btn btn-outline-info btn-not-radius modal-btn edit_user"><i class="fa fa-edit"></i></button>&nbsp;
                                            <button type="button" data-href="'.route('users.destroy', $row->id).'" data-name="'.$row->name.'" class="btn btn-outline-danger btn-not-radius delete-btn delete_user" ><i class="fa fa-trash"></i></button>';
                    return $html;
                })
                ->editColumn('avatar', function($row){
                    $html = '<img src="https://ui-avatars.com/api/?name='.$row->name.'" width="38px" height="38px" class="rounded-circle avatar">';
                    return $html;
                })
                ->editColumn('amount', '{{@number_format($amount)}} đ')
                ->rawColumns(['avatar', 'action'])
                ->make(true);;
        }

        return view('admin.manager_user.index');
    }

    public function create()
    {
        return view('admin.manager_user.create');
    }

    public function store(RegisterRequest $request)
    {
        try {
            $this->repository->create($request);
            return response()->json([
                'success' => true,
                'msg' => 'Thêm thành viên thành công'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Đã xảy ra lỗi!'
            ]);
        }
    }

    public function edit($id)
    {
        $user = $this->repository->getUser($id);
        return view('admin.manager_user.edit', compact('user'));
    }

    public function update(Request $request)
    {
        try {
            $this->repository->update($request);
            return response()->json([
                'success' => true,
                'msg' => 'Cập nhật thành viên thành công'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Đã xảy ra lỗi!'
            ]);
        }
    }

    public function destroy($id)
    {
        $user = $this->repository->delete($id);
        $user->delete();
        return response()->json([
                'success' => true,
                'msg' => 'Xóa thành viên thành công'
        ]);
    }

    public function userDashboard()
    {
        return view('users.index');
    }

    public function recharge()
    {
        $banks = $this->repository->getBanks();
        return view('users.recharge', compact('banks'));
    }

    public function getAmount()
    {
        $user = $this->repository->getAmount();
        return response()->json([
            'success' => true,
            'amount' => $user
        ]);
    }

    public function info()
    {
        return view('users.info');
    }

    public function updateInfo(Request $request, $id)
    {
        try {
            $this->repository->updateInfo($request, $id);
            return redirect()->back()->with(['flag'=>'success','messege'=>'Cập nhật thành công']);
        } catch (Exception $e) {
            return redirect()->back()->with(['flag'=>'danger','messege'=>'Đã xảy ra lỗi!']);
        }
    }

    public static function utf8convert($str) {

        if(!$str) return false;

        $utf8 = array(

            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',

            'd'=>'đ|Đ',

            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',

            'i'=>'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',

            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',

            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',

            'y'=>'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',

        );

        foreach($utf8 as $ascii=>$uni) $str = preg_replace("/($uni)/i",$ascii,$str);

        return $str;

    }
}
