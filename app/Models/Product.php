<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";
    public function product_tybe(){
        return $this->belongsTo('App\productTybe','id_tybe','id');
    }

    public function bill_detail(){
        return $this->hasMany('App\BillDetail','id_product','id');
    }
    use HasFactory;
}
