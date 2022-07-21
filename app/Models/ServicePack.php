<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePack extends Model
{
    use HasFactory;
    protected $table = 'service_packs';

    public function service()
    {
        return $this->belongsTo(Service::class,'service_id', 'id');
    }

}
