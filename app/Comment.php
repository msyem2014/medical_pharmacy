<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Comment extends Model
{
    protected $table = 'comments';

    protected $appends = ['published'];

    public function getPublishedAttribute()
    {
        return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']))->diffForHumans();
    }


    public static function add($request, $user)
    {
        $comment = new Comment;
        $comment->content = $request->content;
        $comment->post_id = $request->post_id;
        $comment->user_id = $user->id;
        $comment->save();
        return $comment;
       
        
    }

    public static function edit($request, $id)
    {
        $comment = Comment::findOrFail($id);
        if ($comment->user_id == Auth::user()->id) {
            $comment->content = $request->content;
            $comment->save();
            return $comment;
        } else {
            return response("unauthorized", 403);
        }
    }

    public function post()
    {
        return $this->belongsTo('\App\Post', 'post_id', 'id');
    }

    public function owner()
    {
        return $this->belongsTo('\App\User', 'user_id', 'id');
    }
}
