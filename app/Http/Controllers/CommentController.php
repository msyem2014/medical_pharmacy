<?php

namespace App\Http\Controllers;

use App\Events\NotificationCount;
use App\Events\Notifications;
use App\Notification;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Comment;
use JWTAuth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $comment = Comment::add($request,$user);
        $comm = Comment::where('id','=',$comment->id)->with('owner','post.owner')->first();
        $notification = new Notification();
        $notification->notifier = $comm->post->owner->id;
        $notification->event_user = $user->id;
        $notification->content = 'Comment in your post';
        $notification->type  = '';
        $notification->save();
        $notification = Notification::where('id','=',$notification->id)->with(['notifier','event_user'])->first();
        $count = Notification::where([['notifier','=',$user->id],['seen' ,'=', 0]])->count();
        event(new Notifications($notification));
        event(new NotificationCount($count,$user));
        return response($comm, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $comments = Comment::where('post_id', $id)->get();
      return response($comments, 202);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $comment = Comment::findOrFail($id);
      return response($comment, 202);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CommentRequest $request, $id)
    {
      $this->validate($request, [
        'content' => 'required',
        'post_id' => 'required',
      ]);
      $comment = Comment::edit($request, $id);
      return response($comment, 205);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $comment = Comment::findOrFail($id);
      $comment->delete();
      return response($comment, 201);
    }
}
