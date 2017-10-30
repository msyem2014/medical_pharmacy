<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table= 'notifications';


    protected $appends = ['created'];

    public function getCreatedAttribute()
    {
        return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']))->diffForHumans();
    }



    public function notifier()
    {
        return $this->belongsTo('\App\User','notifier','id');
    }

    public function event_user(){
        return $this->belongsTo('\App\User','event_user','id');

    }


}
