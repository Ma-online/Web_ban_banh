<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = "bills";

    public function bill_detail(){
        return $this->hasMany('App\BillDetail','id_bill','id');
    }

    public function bill(){
        return $this->hasMany('App\Customer','id_customer','id');
    }
    use HasFactory;
}
