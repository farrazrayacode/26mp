<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'customer_code',
        'name',
        'phone',
    ];

    //satu pelanggan bisa punya beberapa kendaraan
    public function vehicles(){
        return $this->hasMany(Vehicle::class);
    }

    public function serviceRecords(){
        return $this->hasMany(ServiceRecord::class);
    }
}
