<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\ServiceRecord;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class GateInController extends Controller
{
    //menampilkan halaman gate in

    public function index(){
        $records = ServiceRecord::with(['customer','vehicle'])
        ->whereIn('status', ['Pengecekan Awal', 'Menunggu WO'])
        ->orderBy('created_at', 'desc')
        ->get();

        // nomor gate pass berikutnya
        $lastRecord = ServiceRecord::latest()->first();
        $nextGatePass = $lastRecord? 'GP-' . str_pad((intval(substr($lastRecord->gate_pass_no, 3)) + 1), 3, '0', STR_PAD_LEFT): 'GP-001';

        return view('admin.gate-in.index', compact('records', 'nextGatePass'));
    }

    //simpan kendaraan masuk baru
    public function store(Request $request){
        $request->validate([
            'plate_number' => 'required|string',
            'customer_name' => 'required|string',
            'gate_pass_no' => 'required|string',
        ]);

        //cari atau buat customer baru
        $customer = Customer::firstOrCreate(
            ['name' => $request->customer_name],
            ['customer_code' => 'CUS-'.str_pad(Customer::count() +1, 4, '0', STR_PAD_LEFT)]
        );

        //cari atau buat kendaraan baru
        $vehicle = Vehicle::firstOrCreate(
            ['plate_number' => strtoupper($request->plate_number)],
            [
                'customer_id' => $customer->id,
                'brand' => $request->vehicle_brand,
                'type' => $request->vehicle_type,
                ]
        );

        //buat service record baru
        ServiceRecord::create([
            'gate_pass_no' => $request->gate_pass_no,
            'vehicle_id' => $vehicle->id,
            'customer_id' => $customer->id,
            'gate_in_at' =>now(),
            'status' => 'Pengecekan Awal',
        ]);

        return redirect()->route('admin.gate-in.index')->with('success', 'Kendaraan berhasil dicatat masuk!');
    }

    // Tidak bisa dikerjakan -> Batal servis
    public function reject($id){
        $record = ServiceRecord::findOrFail($id);
        $record->update(['status'=>'Batal Servis']);
        return redirect()->route('admin.gate-in.index')->with('success', 'Kendaraan dipindahkan ke Gate Out.');
    }

    //Bisa dikerjakan -> Menunggu Work Order
    public function approve($id){
        $record = ServiceRecord::findOrFail($id);
        $record->update(['status' => 'Menunggu WO']);
        return redirect()->route('admin.gate-in.index')->with('success', 'Kendaraan siap dibuatkan Work Order.');
    }

}
