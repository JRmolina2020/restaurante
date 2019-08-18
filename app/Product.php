<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable=['name','prince','description','image','categorie_id'];
    protected $guarded=['is_active'];

    function categorie(){
    return $this->belongsTo('App\Categorie');
    }
}
