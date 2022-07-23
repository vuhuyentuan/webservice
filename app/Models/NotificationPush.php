<?php
/**
 * Created by PhpStorm.
 * User: h2 gaming
 * Date: 8/9/2019
 * Time: 11:56 PM
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class NotificationPush extends Model
{
    protected $table  = 'notifications';

    protected $fillable = [
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at'
    ];

}
