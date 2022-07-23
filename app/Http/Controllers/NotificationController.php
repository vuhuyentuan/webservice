<?php
/**
 * Created by PhpStorm.
 * User: h2 gaming
 * Date: 8/13/2019
 * Time: 10:19 PM
 */
namespace App\Http\Controllers;

use App\Models\NotificationPush;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead(Request $request){
        $id = $request->get('id');
        if(!empty($id))
        {
            NotificationPush::query()->where('id', $id)->update([
                'read_at' => now()
            ]);
        }
        return response()->json([], 200);
    }

    public function markAllAsRead(Request $request){
        $notify = NotificationPush::query();

        $notify->where(function($q){
            $q->where('data', 'LIKE', '%"for_admin":1%');
            $q->orWhere('notifiable_id', Auth::id());
        });

        $notify->where('read_at', null)
            ->update([
                'read_at' => now()
            ]);
        return response()->json([], 200);
    }

    public function loadNotify(Request $request)
    {
        $query  = NotificationPush::query();

        $query->where(function($q){
            $q->where('data', 'LIKE', '%"for_admin":1%');
            $q->orWhere('notifiable_id', Auth::id());
        });
        $notifications = $query->orderBy('created_at', 'desc')->limit(5)->get();
        $count = $query->where('read_at', null)->count();
        $view = view('admin.notification', compact('notifications', 'count'))->render();
        return response()->json([
            'count' => $count,
            'html' => $view
        ]);
    }
}
