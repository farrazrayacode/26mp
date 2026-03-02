<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'service_record_id',
        'invoice_no',
        'invoice_date',
        'due_date',
        'payment_term',
        'pic',
        'subtotal',
        'discount_global',
        'down_payment',
        'total',
        'payment_proof',
        'remark',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
    ];

    //invoice punya satu service record
    public function serviceRecord(){
        return $this->belongsTo(ServiceRecord::class);
    }
}
