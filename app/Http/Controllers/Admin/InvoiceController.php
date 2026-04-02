<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EstimationItem;
use App\Models\Invoice;
use App\Models\ServiceRecord;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    //menampilkan halaman invoice
    public function index(){
        $records= ServiceRecord::with(['customer', 'vehicle', 'invoice'])
        ->where('status','Proses Servis')
        ->orderBy('created_at', 'desc')
        ->get();

        return view('admin.invoice.index', compact('records'));
    }

    //menampilkan form invoice
    public function show($id){
        $record = ServiceRecord::with([
            'customer',
            'vehicle',
            'estimationItems',
            'invoice'
        ])->findOrFail($id);

        return view('admin.invoice.show', compact('record'));
    }

    //menerima pembayaran
    public function payment(Request $request, $id){
        $request->validate([
            'km_out' => 'required|integer',
            'payment_term' => 'required|string',
            'pic' => 'required|string',
            'due_date' => 'required|date',
            'payment_proof' => 'nullable|image|max:2048',
        ]);

        $record = ServiceRecord::findOrFail($id);
        $invoice = $record->invoice;

        //upload bukti pembayran
        $paymentProof = null;
        if($request->hasFile('payment_proof')){
            $paymentProof = $request->file('payment_proof')
            ->store('payment-proofs', 'public');
        }

        //menghitung ulang total item dengan item yang mungkin diubah
        if($request->has('items')){
            $record->estimationItems()->delete();

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
        }

        $subtotal = $record->estimationItems()->sum('amount');
        $discountGlobal = $request->discount_global ?? $invoice->discount_global ?? 0;
        $downPayment = $invoice->down_payment ?? 0;
        $total = $subtotal - $discountGlobal - $downPayment;

        //update invoice
        $invoice->update([
            'due_date' => $request->due_date,
            'payment_term' => $request->payment_term,
            'pic' => $request->pic,
            'subtotal' => $subtotal,
            'discount_global' => $discountGlobal,
            'total' => $total,
            'payment_proof' => $paymentProof ?? $invoice->payment_proof,
        ]);

        //update km keluar dan status
        $record->update([
            'km_out' => $request->km_out,
            'status' => 'Lunas',
        ]);

        return redirect()->route('admin.invoice.index')
        ->with('success', 'Pembayaran diterima! Kendaraan siap Gate Out.');
    }

    //print
    public function print($id){
        $record = ServiceRecord::with(['customer', 'vehicle', 'estimationItems', 'invoice'])
        ->findOrFail($id);

        return view('admin.invoice.print', compact('record'));
    }
}
