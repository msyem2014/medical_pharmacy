<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Special extends Model
{
    protected $table= 'specials';

    protected $fillable = [
        'name'
    ];

    public function posts(){
        return $this->hasMany('\App\Post','special_id','id');
    }

    public  function users(){
        return $this->hasMany('\App\User','special_id','id');
    }
}
