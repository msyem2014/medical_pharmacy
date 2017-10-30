<?php

namespace App\Http\Controllers;

use App\Events\NotificationCount;
use App\Events\Notifications;
use App\Notification;
use Illuminate\Http\Request;
use App\Favourite;
use JWTAuth;

class FavouriteController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @internal param int $post_id
     */
    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $like = Favourite::where('post_id', '=', $request->post_id)->where('user_id','=',$user->id)->first();
        if (empty($like)){
            $favourite = Favourite::add($request, $user);
            $fav = Favourite::where('id','=',$favourite->id)->with('user','post.owner')->first();
            $notification = new Notification();
            $notification->notifier = $fav->post->owner->id;
            $notification->event_user = $user->id;
            $notification->content = 'Like your post';
            $notification->type  = '';
            $notification->save();
            $notification = Notification::where('id','=',$notification->id)->with(['notifier','event_user'])->first();
            $count = Notification::where([['notifier','=',$user->id],['seen' ,'=', 0]])->count();
            event(new Notifications($notification));
            event(new NotificationCount($count,$user));
            return response($favourite, 201);
        }else{
            $like->delete();
            $data = ['message' => 'unlike','like' => $like];
            return response($data,201);
        }

    }

    public function checkLike(Request $request){
        $user = JWTAuth::parseToken()->authenticate();
        $like = Favourite::where('post_id', '=', $request->post_id)->where('user_id','=',$user->id)->first();
        if (empty($like)){
            return response('',204);
        }else{
            return response($like,200);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $favourit = Favourit::findOrFail($id);
        $favourit->delete();
        return response($favourit, 204);
    }
}
