<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Origin;

class OriginController extends Controller
{
    public function index() {
        $origins = Origin::orderBy('name')->paginate(10);
        return view('main.origin', compact('origins'));
    }

    public function store(Request $request) {
        $dataOrigin = [
            'name' => $request->name,
        ];
    
        $existingOrigin = Origin::where('name', $request->name)->first();

        if ($existingOrigin) {
            $logErrors = 
            'Origin: ' . $request->name . ', already in the system.';

            return redirect('origins')->with('logErrors', $logErrors);

        } else {
            Origin::create($dataOrigin);
            return redirect('origins');
        }
    }

    public function update(Request $request) {
        $dataOrigin = Origin::find($request->id);

        if ($dataOrigin) {
            $dataOrigin->name = $request->name;
            $dataOrigin->save();
        }

        return redirect('origins');
    }
}
