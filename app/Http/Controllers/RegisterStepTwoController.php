<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class RegisterStepTwoController extends Controller
{
    public function create()
    {
        $cities = City::all();

        return view('auth.register-step2', compact('cities'));
    }

    public function store(Request $request)
    {
        auth()->user()->update([
            'phone' => $request->phone,
            'address' => $request->address,
            'city_id' => $request->city_id,
        ]);

        return redirect()->route('dashboard');
    }
}
