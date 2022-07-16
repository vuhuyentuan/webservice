<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = 'services';

    public function category()
    {
       return $this->belongsTo(Category::class,'category_id', 'id');
    }

    public function service_pack()
    {
        return $this->hasMany(ServicePack::class,'service_id', 'id');
    }

}
