<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'name', 'phone', 'birth_date', 'desc', 'image', 'role'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /*
     *   roles = [
     *     patient => 1 ,
     *     doctor => 2 ,
     *     laboratory => 3
     * ];
    */

    public static function add($request)
    {
        $user = new User();
        $user->email = str_replace('%40','@',$request->email);
        $user->password = bcrypt($request->password);
        $user->name = $request->name;
        $user->birth_date =  Carbon::createFromFormat('Y-m-d', $request->birth_date);
        $user->desc = $request->desc;
        if (!isset($request->image)) {
            $user->image = '/images/default.png';
        } else {
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move('images', $imageName);
            $user->image = $imageName;
        }
        $user->role = $request->role;
        if ($request->role == "2") {
            $user->special_id = (int)$request->special_id;
        }
        $user->save();
        return $user;
    }

    public function posts(){
        return $this->hasMany('\App\User','user_id','id');
    }

    public function sender(){
        return $this->hasMany('\App\Chat','user1','id');
    }

    public function receiver(){
        return $this->hasMany('\App\Chat','user2','id');
    }

    public function special(){
        return $this->belongsTo('\App\Special','special_id','id');
    }

    public function comments(){
        return $this->hasMany('\App\Comment','user_id','id');
    }

    public function favourites(){
        return $this->hasMany('\App\Favourite','user_id','id');
    }
}
