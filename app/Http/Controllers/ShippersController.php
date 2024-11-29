<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipper;

class ShippersController extends Controller
{
    public function index() {
        $shippers = Shipper::orderBy('name')->get();
        return view('main.shipper', compact('shippers'));
    }

    public function store(Request $request) {
        $dataShipper = [
            'name' => $request->name,
            'code_mark' => $request->code_mark
        ];
    
        $existingShipper = Shipper::where('name', $request->name)->first();

        if ($existingShipper) {
            $logErrors = 
            'Shipper: ' . $request->name . ', already in the system.';

            return redirect('shippers')->with('logErrors', $logErrors);

        } else {
            Shipper::create($dataShipper);
            return redirect('shippers');
        }
    }

    public function update(Request $request) {
        $dataShipper = Shipper::find($request->id);

        if ($dataShipper) {
            $dataShipper->name = $request->name;
            $dataShipper->code_mark = $request->code_mark;
            $dataShipper->save();
        }

        return redirect('shippers');
    }
}
