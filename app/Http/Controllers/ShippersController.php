<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipper;

class ShippersController extends Controller
{
    public function index() {
        $shippers = Shipper::orderBy('name')->paginate(10);
        return view('main.shipper', compact('shippers'));
    }

    public function store(Request $request) {
        $dataShipper = [
            'name' => $request->name,
            'code_mark' => $request->code_mark
        ];
    
        $existingShipper = Shipper::where('name', $request->name)
        ->where('code_mark', $request->code_mark)
        ->first();

        if ($existingShipper) {
            $logErrors = 
            'Shipper: ' . $request->name . 
            ' - Code Mark: ' . $request->code_mark . ', already in the system.';

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
