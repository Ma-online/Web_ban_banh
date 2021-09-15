<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = "Customer";

    public function bill(){
        return $this->hasMany('App\BillDetail','id_customer','id');
    }
    use HasFactory;
}
