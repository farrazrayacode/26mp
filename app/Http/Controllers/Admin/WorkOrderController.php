<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceRecord;
use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    //menampilkan halaman work order
    public function index(){
        $records = ServiceRecord::with(['customer','vehicle'])
        ->where('status', 'Menunggu WO')
        ->orderBy('created_at', 'desc')
        ->get();

        return view('admin.work-order.index', compact('records'));
    }

    //menyimpan detail WO
    public function update(Request $request, $id){
        $request->validate([
            'km_in' => 'required|integer',
            'complaint' => 'required|string',
            'mechanic' => 'required|string',
        ]);

        $record = ServiceRecord::findOrFail($id);

        //generate nomor WO secara otomatis
        $woNumber = 'WO-'.str_pad($record->id, 5, '0', STR_PAD_LEFT);

        $record->update([
            'km_in' => $request->km_in,
            'complaint' => $request->complaint,
            'mechanic' => $request->mechanic,
            'wo_number' => $woNumber,
            'status' => 'Menunggu Estimasi',
        ]);

        return redirect()->route('admin.work-order.index')
        ->with('success', 'Work Order '.$woNumber.' berhasil dibuat!');
    }
}
