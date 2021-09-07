<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $table = "tipe_product";

    public function product(){
        return $this->hasMany('App\Product','id_tybe','id');
    }
    use HasFactory;
}