<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
        $users = User::where(function($query) {
            $query->where('about_me', '!=', 'superuser')
                  ->orWhereNull('about_me')
                  ->orWhere('about_me', '');
        })
        ->orderBy('name')
        ->paginate(10);
        return view('main.user', compact('users'));
    }

    public function store(Request $request) {
        $attributes = request()->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:250', Rule::unique('users', 'email')],
            'password' => ['required', 'min:5', 'max:250'],
            'location' => ['required', 'max:250'],
        ]);

        $dataUser = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'location' => $request->location,
        ];

        User::create($dataUser);
        return redirect('users');
    }

    public function update(Request $request) {
        $dataUser = User::find($request->id);

        if ($dataUser->email != $request->email) {
            $attributes = request()->validate([
                'name' => ['required', 'max:50'],
                'email' => ['required', 'email', 'max:250', Rule::unique('users', 'email')],
                'password' => ['nullable', 'min:5', 'max:250'],
                'location' => ['required', 'max:250'],
            ]);
        }

        if ($dataUser) {
            $dataUser->name = $request->name;
            $dataUser->email = $request->email;
            $dataUser->location = $request->location;
            if ($request->password) {
                $dataUser->password = $request->password;
            }
            $dataUser->save();
        }

        return redirect('users');
    }
}
