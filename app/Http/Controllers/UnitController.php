<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;

class UnitController extends Controller
{
    public function index() {
        $units = Unit::orderBy('name')->get();
        return view('main.unit', compact('units'));
    }

    public function store(Request $request) {
        $dataUnit = [
            'name' => $request->name,
            'code_mark' => $request->code_mark
        ];
    
        $existingUnit = Unit::where('name', $request->name)->first();

        if ($existingUnit) {
            $logErrors = 
            'Unit: ' . $request->name . ', already in the system.';

            return redirect('units')->with('logErrors', $logErrors);

        } else {
            Unit::create($dataUnit);
            return redirect('units');
        }
    }

    public function update(Request $request) {
        $dataUnit = Unit::find($request->id);

        if ($dataUnit) {
            $dataUnit->name = $request->name;
            $dataUnit->save();
        }

        return redirect('units');
    }
}
