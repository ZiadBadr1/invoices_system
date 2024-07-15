<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }
    public function postLogin(LoginRequest $request)
    {

        $attributes = $request->validated();
        if(Auth::attempt($attributes)){
            return redirect()->route('admin.dashboard');
        }
        return redirect()->back()->with('error','كلمه السر غير صحيحة');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
