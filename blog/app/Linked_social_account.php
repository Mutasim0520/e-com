<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Linked_social_account extends Model

{
    protected $fillable = ['provider_name', 'provider_id' ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}