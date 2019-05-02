<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = "customer";

    protected $fillable = [
        'name', 'gender', 'email','address','phone_number','note','create_at','update_at',
    ];

    public function bill (){
    	return $this->hasMany('App\Bill','id_customer','id');
    }

    
}
