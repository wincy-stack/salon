<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Userlogin extends Controller {
    public function showRegister() { return view('login.register'); }

    public function register(Request $request) {
        $incomingfields = $request->validate([
            'username' => ['required', 'min:3', 'unique:users,username'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:7', 'max:27']
        ]);
        $incomingfields['password'] = bcrypt($incomingfields['password']);
        User::create($incomingfields);
        return redirect('/')->with('success', 'Registration successful! Please login.');
    }

    public function login(Request $request) {
        $incomingfields = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:7', 'max:27']
        ]);
        if (Auth::attempt(['email' => $incomingfields['email'], 'password' => $incomingfields['password']])) {
            $request->session()->regenerate();
            return redirect('/dashboard')->with('success', 'Logged in successfully!');
        }
        return redirect('/')->with('error', 'Invalid email or password.');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
