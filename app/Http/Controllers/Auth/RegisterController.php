<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function register(Request $request)
{
    try {
        $request->validate([
            'company_name' => 'required|string|max:255|unique:companies,name',
            'name'         => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users,email',
            'password'     => 'required|string|min:6|confirmed',
        ]);

        $company = Company::create([
            'name' => $request->company_name,
            'slug' => Str::slug($request->company_name),
        ]);

        $user = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'company_id' => $company->id,
        ]);

        Auth::login($user);

        return redirect()->to('/' . $company->slug)
            ->with('success', 'Registration successful! Welcome to the dashboard.');

    } catch (\Exception $e) {
        return back()->withErrors(['error' => $e->getMessage()]);
    }
}

}
