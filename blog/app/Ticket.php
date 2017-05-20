<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function Admin(){
        return $this->belongsTo('App\Admin');
    }
    public function User(){
        return $this->belongsTo('App\User');
    }
}
