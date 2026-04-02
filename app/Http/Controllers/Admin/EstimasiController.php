<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceRecord;
use App\Models\EstimationItem;
use Illuminate\Http\Request;

class EstimasiController extends Controller
{
    //menampilkan halaman estimasi
    public function index(){
        $records = ServiceRecord::with(['customer', 'vehicle'])
        ->where('status', 'Menunggu Estimasi')
        ->orderBy('created_at', 'desc')
        ->get();

        return view('admin.estimasi.index', compact('records'));
    }

    //menampilkan form buat estimasi
    public function show($id){
        $record = ServiceRecord::with(['customer', 'vehicle', 'estimationItems'])
        ->findOrFail($id);

        return view('admin.estimasi.show', compact('record'));
    }


    //menyimpan estimasi
    public function store(Request $request, $id){
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.qty' => 'required|numeric|min:1',
            'items.*.uom' => 'nullable|string',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
        ]);

        $record = ServiceRecord::findOrFail($id);

        //menghapus item lama kalau ada
        $record->estimationItems()->delete();

        //menyimpan item baru
        foreach($request->items as $item){
            $qty = $item['qty'];
            $price = $item['price'];
            $discount = $item['discount'] ?? 0;
            $amount = ($qty * $price) - $discount;

            EstimationItem::create([
                'service_record_id' => $record->id,
                'description' => $item['description'],
                'qty' => $qty,
                'uom' => $item['uom'] ?? null,
                'price' => $price,
                'discount' => $discount,
                'amount' => $amount,
            ]);
        }

        //hitung total
        $subtotal = $record->estimationItems()->sum('amount');
        $discountGlobal = $request->discount_global ?? 0;
        $downPayment = $request->down_payment ?? 0;
        $total = $subtotal - $discountGlobal - $downPayment;

        //menyimpan ke invoice draft
        $record->invoice()->updateOrCreate(
            ['service_record_id' => $record->id],
            [
                'invoice_no' => 'SVC/'.now()->format('my').'/'.str_pad($record->id, 3, '0', STR_PAD_LEFT),
                'invoice_date' =>now(),
                'subtotal' => $subtotal,
                'discount_global' => $discountGlobal,
                'down_payment' => $downPayment,
                'total' => $total,
                'remark' => $request->remark,
            ]
        );

        //update status
        if($request->action === 'reject'){
            $record->update(['status' => 'Batal Servis']);
            return redirect()->route('admin.estimasi.index')
            ->with('success', 'Estimasi ditolak, Kendaraan dipindahkan ke Gate Out.');
        }

        $record->update(['status' => 'Proses Servis']);
        return redirect()->route('admin.estimasi.index')
        ->with('success', 'Estimasi disetujui! Kendaraan masuk Proses Servis');
    }

    //print
        public function print($id){
            $record = ServiceRecord::with(['customer', 'vehicle', 'estimationItems', 'invoice'])
            ->findOrFail($id);

            return view('admin.estimasi.print', compact('record'));
        }
}
