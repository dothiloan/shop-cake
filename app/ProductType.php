<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $table = "type_products";
     protected $fillable = [
        'name', 'description', 'image','create_at','update_at',
    ];
    public function product (){
    	return $this->hasMany('App\Product','id_type','id');
    }

}
