<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceRecord;
use Illuminate\Http\Request;

class GateOutController extends Controller
{
    //menampilkan halaman gate out

    public function index(){
        $records = ServiceRecord::with(['customer', 'vehicle', 'invoice'])
        ->whereIn('status', ['Lunas', 'Batal Servis'])
        ->orderBy('updated_at', 'desc')
        ->get();

        return view('admin.gate-out.index', compact('records'));
    }

    //proses gate out

    public function process($id){
        $record = ServiceRecord::findOrFail($id);

        $record->update([
            'status' => 'Closed',
            'gate_out_at' => now(),
        ]);

        return redirect()->route('admin.gate-out.index')
        ->with('success', 'Kendaraan'.$record->vehicle->plate_number.' berhasil Gate Out!');
    }
}
