<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'special_id', 'title', 'content'
    ];

    protected $hidden = [
        'special_id',
    ];

    public static function add($request, $user)
    {
        if ($user->role == 2) {
            $post = new Post;
            $post->user_id = $user->id;
            $post->special_id = $request->special_id;
            $post->title = '';
            $post->body = str_replace('+', ' ', $request->content);
            if (isset($request->image)) {
                $imageName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move('images', $imageName);
                $post->image = $imageName;
            }
            $post->save();
            return $post;
        } else {
            return response("unauthorized", 403);
        }
    }

    public static function edit($request, $id, $user)
    {
        $post = Post::findOrFail($id);
        if ($post->user_id == $user->id) {
            $post->special_id = $request->special_id;
            $post->title = $request->title;
            $post->content = $request->content;
            $post->save();
            return $post;
        } else {
            return response("unauthorized", 403);
        }
    }

    public function owner(){
        return $this->belongsTo('\App\User','user_id','id');
    }

    public function special(){
        return $this->belongsTo('\App\Special','special_id','id');
    }

    public function comments(){
        return $this->hasMany('\App\Comment','post_id','id');
    }

    public function favourites(){
        return $this->hasMany('\App\Favourite','post_id','id');
    }
}
