<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $fillable=['name'];
    protected $guarded=['is_active'];

    function products(){
     return $this->hasMany('App\Product');
    }

}
