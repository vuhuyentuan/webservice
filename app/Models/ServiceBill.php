<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceBill extends Model
{
    use HasFactory;
    protected $table = 'service_bills';

    public function service_bill()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class,'service_id', 'id');
    }

    public function service_pack()
    {
        return $this->belongsTo(ServicePack::class,'service_pack_id', 'id');
    }
}
