<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    protected $table = 'favourites';

    protected $fillable = [
        'post_id', 'user_id'
    ];


    public static function add($request, $user)
    {
        $favourite = new Favourite;
        $favourite->post_id = $request->post_id;
        $favourite->user_id = $user->id;
        $favourite->save();
        return $favourite;
    }

    public function user()
    {
        return $this->belongsTo('\App\User', 'user_id', 'id');
    }

    public function post()
    {
        return $this->belongsTo('\App\Post', 'post_id', 'id');
    }
}
