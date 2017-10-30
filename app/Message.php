<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table= 'messages';


    protected $appends = ['created'];

    public function getCreatedAttribute()
    {
        return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']))->diffForHumans();
    }



    public function chat()
    {
        return $this->belongsTo('\App\Chat','chat_id','id');
    }
    
    public function sender()
    {
        return $this->belongsTo('\App\User','sender_id','id');
    }

        public function receiver()
    {
        return $this->belongsTo('\App\User','receiver_id','id');
    }
}
