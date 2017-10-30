<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Events\Chats;
use App\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use JWTAuth;

class ChatsController extends Controller
{
    public function index()
    {
        return response(Chat::all(), 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getChats(Request $request){
        $user = JWTAuth::parseToken()->authenticate();
        $chats =  Chat::where(function ($q) use ($user){
            $q->where('user1','=',$user->id)
                ->orWhere('user2','=',$user->id);
        })->with(['sender' => function($query){
                $query->select(['name','image','id','special_id']);
            },'receiver' => function($query){
                $query->select(['name','image','id','special_id']);
            }])->orderBy('updated_at','desc')->get();
        event(new Chats($chats, $user));
        return response($chats,$status=200);
    }

    public function getMessages(Request $request){

        $messages = Message::where('chat_id','=',$request->chat_id)->where('seen','=',0)->orderBy('created_at','desc')->get();
        foreach ($messages as $message){
            $message->seen = 1;
            $message->save();
        }
        $messages = Message::where('chat_id','=',$request->chat_id)->with(['sender' => function($query){
            $query->select(['name','image','id','special_id']);
        },'receiver' => function($query){
            $query->select(['name','image','id','special_id']);
        }])->get();
        if (empty($messages)){
            return response('empty',200);
        }

        return response($messages,200);

        /// update notification count

        // subscribe messages  chat count of unread message
    }

    public function sendMessage(Request $request){
        $user = JWTAuth::parseToken()->authenticate();
        $chat = Chat::where([
            ['user1', '=', $user->id ],
            ['user2', '=', $request->receiver]
        ])->orWhere([
            ['user1', '=', $request->receiver],
            ['user2','=',$user->id]
            ])->first();
        if (empty($chat)){
            $chat = new Chat();
            $chat->user1 = $user->id;
            $chat->user2 = $request->receiver;
            $chat->save();
            $message = new Message();
            $message->content = $request->msg;
            $message->sender_id = $user->id;
            $message->receiver_id = $request->receiver;
            $message->chat_id = $chat->id;
            $message->save();
            $chat->updated_at = Carbon::now();
            $chat->save();
            $message = Message::where('id','=',$message->id)->with(['sender' => function($query){
                $query->select(['name','image','id','special_id']);
            },'receiver' => function($query){
                $query->select(['name','image','id','special_id']);
            }])->first();
            /// subscribe message and updated chat
        }else{
            $message = new Message();
            $message->content = $request->msg;
            $message->sender_id = $user->id;
            $message->receiver_id = $request->receiver;
            $message->chat_id = $chat->id;
            $message->save();
            $chat->updated_at = Carbon::now();
            $chat->save();
            $message = Message::where('id','=',$message->id)->with(['sender' => function($query){
                $query->select(['name','image','id','special_id']);
            },'receiver' => function($query){
                $query->select(['name','image','id','special_id']);
            }])->first();
            /// subscribe
        }
        return response($message,200);
    }


}
