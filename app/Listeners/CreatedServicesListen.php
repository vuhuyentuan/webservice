<?php
namespace App\Listeners;
use App\Notifications\AdminChannelServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Events\CreatedServicesEvent;
use App\Models\Service;

    class CreatedServicesListen
    {
        public function handle(CreatedServicesEvent $event)
        {
            $services = $event->services;
            $service_name = Service::find($services->service_id);
            $service_pack_name = Service::find($services->service_pack_id);
            $data = [
                'id' =>  $services->id,
                'event'=>'CreatedServicesEvent',
                'to'=>'admin',
                'name' =>  Auth::user()->name,
                'avatar' =>  Auth::user()->avatar,
                'link' => route('order.history'),
                'message' => Auth::user()->name.' đã tạo đơn hàng '.$service_name->name.' - '.$service_pack_name->name
            ];
            // notify admin
            Notification::send(Auth::user(), new AdminChannelServices($data));
        }
    }
