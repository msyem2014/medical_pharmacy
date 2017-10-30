<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;
use JWTAuth;

class notificationsController extends Controller
{
    public function getNotifications(Request $request){
        $user = JWTAuth::parseToken()->authenticate();
        $notifications = Notification::where('notifier','=',$user->id)->with('notifier','event_user')->orderBy('created_at','desc')->get();
        $unSeen = Notification::where([['notifier','=',$user->id],['seen','=',0]])->get();
        foreach ($unSeen as $item){
            $item->seen = 1;
            $item->save();
        }
        return response($notifications, 200);
    }

    public function getNotificationsCount(Request $request){
        $user = JWTAuth::parseToken()->authenticate();
        $count = Notification::where([['notifier','=',$user->id],['seen' ,'=', 0]])->count();
        return response($count, 200);
    }
}
