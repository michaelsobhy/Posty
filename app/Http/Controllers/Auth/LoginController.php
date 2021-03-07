<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest']); //if not guest (if singed in) redirect to home (as he can not register)
    }

    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        //validation
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!auth()->attempt($request->only('email', 'password'), $request->remember)) {
            return back()->with('status', 'Invalid login details');
        } else {
            return redirect()->route('dashboard');
        }
    }
}
