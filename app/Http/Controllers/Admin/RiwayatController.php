<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceRecord;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index(Request $request){
        $query = ServiceRecord::with(['customer', 'vehicle', 'invoice'])
        ->where('status', 'Closed')
        ->orderBy('gate_out_at', 'desc');

        //filter pencarian
        if($request->search){
            $query->where(function($q) use ($request){
                $q->whereHas('vehicle', function($q)use($request){
                    $q->where('plate_number', 'like', '%'.$request->search.'%');
                })->orWhereHas('customer', function($q) use($request){
                    $q->where('name', 'like', '%'.$request->search.'%');
                });
            });
        }

        //filter tanggal
        if($request->date_from){
            $query->whereDate('gate_in_at', '>=', $request->date_from);
        }
        if($request->date_to){
            $query->whereDate('gate_in_at', '<=', $request->date_to);
        }

        $records = $query->paginate(15);
        return view('admin.riwayat.index', compact('records'));
    }
}
