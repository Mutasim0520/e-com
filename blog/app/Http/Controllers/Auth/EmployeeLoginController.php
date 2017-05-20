<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class EmployeeLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:employee');
    }

    public function showLoginForm()
    {
        return view('auth.employee-login');
    }

    public function login(Request $request)
    {
        // Validate the form data
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        // Attempt to log the user in
        if (Auth::guard('employee')->attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'employee'], $request->remember)) {
            // if successful, then redirect to their intended location
            return redirect()->intended(route('employee.Product.list'));
        }

        // if unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('email'));
    }
}