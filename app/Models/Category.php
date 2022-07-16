<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';

    public function service()
    {
        return $this->hasMany(Service::class,'category_id', 'id');
    }

    public static function forDropdown() {
        $categories = Category::pluck('name', 'id');
        return $categories;
    }
}
