<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders_discussion extends Model
{

    public function orders(){
        return $this->belongsTo('App\Order');
    }

    public function admin(){
        return $this->belongsTo('App\Admin','id','employee_id');
    }
}
