<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTransaction extends Model
{
    use HasFactory;
    protected $table = 'user_transactions';

    public function user_transaction()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }
}
