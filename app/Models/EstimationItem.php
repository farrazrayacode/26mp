<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstimationItem extends Model
{
    protected $fillable = [
        'service_record_id',
        'description',
        'qty',
        'uom',
        'price',
        'discount',
        'amount',
    ];

    //punya satu service record
    public function serviceRecord(){
        return $this->belongsTo(ServiceRecord::class);
    }
}
