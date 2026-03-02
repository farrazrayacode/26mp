<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRecord extends Model
{
    protected $fillable = [
        'gate_pass_no',
        'vehicle_id',
        'customer_id',
        'mechanic',
        'complaint',
        'km_in',
        'km_out',
        'gate_in_at',
        'gate_out_at',
        'wo_number',
        'status',
    ];

    protected $casts = [
        'gate_in_at' => 'datetime',
        'gate_out_at' => 'datetime',
    ];

    //riwayat milik satu pelanggan
    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    //riwayat untuk satu kendaraan
    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    //riwayat punya banyak item estimasi
    public function estimationItems(){
        return $this->hasmany(EstimationItem::class);
    }

    //satu riwayat ada satu invoice
    public function invoice(){
        return $this->hasOne(Invoice::class);
    }
}
