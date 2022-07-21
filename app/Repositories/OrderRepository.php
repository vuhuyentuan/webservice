<?php
namespace App\Repositories;

use App\Models\HistoryTransaction;
use App\Models\Service;
use App\Models\ServiceBill;
use App\Models\ServicePack;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderRepository
{
    public function getService($slug){
        return Service::where('slug', $slug)->first();
    }

    public function getServicePack($id){
        return ServicePack::find($id);
    }
    public function getServicePackData($service_pack){
        $type_html = '';
        $quantity_html = '';
        $vip_html = '';
        if($service_pack->feeling == 'show'){
            $type_html = view('users.orders.partials.feeling')->render();
            $quantity_html = view('users.orders.partials.quantity')->render();
        }else if($service_pack->comment == 'show'){
            $type_html = view('users.orders.partials.comment')->render();
        }else if ($service_pack->eyes == 'show'){
            $type_html = view('users.orders.partials.eyes')->render();
            $quantity_html = view('users.orders.partials.quantity')->render();
        }
        if($service_pack->vip == 'show'){
            $vip_html = view('users.orders.partials.vip')->render();
        }
        return ['service_pack' => $service_pack,
                'type_html' => $type_html,
                'quantity_html' => $quantity_html,
                'vip_html' => $vip_html
            ];
    }

    public function store($request, $service_id){
        $bill = new ServiceBill();
        $bill->service_id = $service_id;
        $bill->service_pack_id = $request->service_pack;
        $bill->user_id = Auth::user()->id;
        $bill->order_code = Str::random(10);
        $bill->url = $request->url;
        $bill->feeling = $request->feeling;
        $bill->eyes = $request->eyes;
        $bill->vip_date = $request->vip_date;
        $bill->note = $request->note;
        if(!empty($request->comment)){
            $comments = explode("\r\n", trim($request->comment));
            $comments = array_filter($comments);
            $comment_to_json = json_encode($comments);
            $bill->comment = $comment_to_json;
            $bill->quantity = $request->total_lines;
        }else{
            $bill->quantity = $request->quantity;
        }
        $bill->amount = $request->amount;
        $bill->save();
        // user
        $user = User::find(Auth()->user()->id);
        $amount_old = $user->amount;
        $user->amount = $user->amount - $bill->amount;
        $user->save();
        //history

        $history = new HistoryTransaction();
        $history->user_id = $user->id;
        $history->price = $bill->amount;
        $history->content = $bill->service->name . ' - ' . $request->service_pack_name;
        $history->volatility = number_format($amount_old) . ' -> ' . number_format($user->amount);
        $history->save();
    }
}
