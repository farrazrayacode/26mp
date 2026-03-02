<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'customer_id',
        'plate_number',
        'brand',
        'type',
        'vin',
    ];

    //satu kendaraan punya satu pelanggan
    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    //satu kendaraan bisa punya banyak riwayat
    public function serviceRecords(){
        return $this->hasMany(ServiceRecord::class);
    }

}
