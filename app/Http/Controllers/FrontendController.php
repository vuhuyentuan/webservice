<?php

namespace App\Http\Controllers;

use App\Models\AutoBank;
use App\Models\ServiceBill;
use App\Repositories\FrontendRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    /**
     * The ProductRepository instance.
     *
     * @var \App\Repositories\front\FrontendRepository
     *
     */
    protected $repository;



    /**
     * Create a new PostController instance.
     *
     * @param  \App\Repositories\FrontendRepository $repository
     *
     */
    public function __construct(FrontendRepository $repository)
    {
        $this->repository = $repository;
    }

    public function transtionInfo(Request $request)
    {
        $res_json = $request->data[0];
        $data = new AutoBank();
        $data->data = json_encode($res_json);
        $data->save();
        $this->repository->autoBank($data->data, $data->id);
    }

    public function deleteTranstion()
    {
        DB::table('auto_banks')
            ->delete();
    }

    public function deleteServiceBills()
    {
        ServiceBill::whereRaw('DATE(created_at) < CURDATE() - INTERVAL 6 month')->delete();
    }
}
