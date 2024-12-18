<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomersController extends Controller
{
    public function index() {
        $customers = Customer::orderBy('name')->paginate(10);
        return view('main.customer', compact('customers'));
    }

    public function store(Request $request) {
        $dataCustomer = [
            'name' => $request->name,
            'code_mark' => $request->code_mark,
        ];
    
        $existingCustomer = Customer::where('name', $request->name)
        ->where('code_mark', $request->code_mark)
        ->first();

        if ($existingCustomer) {
            $logErrors = 
            'Customer: ' . $request->name . 
            ' - Code Mark: ' . $request->code_mark . ', already in the system.';

            return redirect('customers')->with('logErrors', $logErrors);

        } else {
            Customer::create($dataCustomer);
            return redirect('customers');
        }
    }

    public function update(Request $request) {
        $dataCustomer = Customer::find($request->id);

        if ($dataCustomer) {
            $dataCustomer->name = $request->name;
            $dataCustomer->code_mark = $request->code_mark;
            $dataCustomer->save();
        }

        return redirect('customers');
    }
}
