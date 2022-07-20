<?php

namespace App\Http\Controllers;

use App\Repositories\SettingRepository;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $repository;

    public function __construct(SettingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $setting = $this->repository->getSetting();
        return view('admin.setting', compact('setting'));
    }

    public function update(Request $request, $id)
    {
        try {
            $this->repository->update($request, $id);
            return redirect()->back()->with(['flag'=>'success','messege'=>'Cập nhật thành công']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['flag'=>'danger','messege'=>'Đã xảy ra lỗi!']);
        }
    }

    public function updateContact(Request $request, $id)
    {
        try {
            $this->repository->updateContact($request, $id);
            return redirect()->back()->with(['flag'=>'success','messege'=>'Cập nhật thành công']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['flag'=>'danger','messege'=>'Đã xảy ra lỗi!']);
        }
    }
}
