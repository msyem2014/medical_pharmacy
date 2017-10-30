<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{

    protected $table= 'chats';

    protected $fillable = ['user1','user2','seen','updated_at'];

    protected $appends = ['updated'];

    public function getUpdatedAttribute()
    {
        return Carbon::createFromTimeStamp(strtotime($this->attributes['updated_at']))->diffForHumans();
    }

    public function messages()
    {
        return $this->hasMany('\App\Message','chat_id','id');
    }

    public function sender()
    {
        return $this->belongsTo('\App\User','user1','id');
    }

    public function receiver()
    {
        return $this->belongsTo('\App\User','user2','id');
    }

}
