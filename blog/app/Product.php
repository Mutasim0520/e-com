<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'product_id';
    public $timestamps = FALSE;

    public function Photo(){
        return $this->hasMany('App\Photo','product_id');
    }
    public function Price(){
        return $this->hasMany('App\Price');
    }
    public function Size(){
        return $this->hasMany('App\Size');
    }
    public function Color(){
        return $this->hasMany('App\Color');
    }
    public function users_wishlst(){
        return $this->belongsTo('App\Users_wishlst');
    }
}
