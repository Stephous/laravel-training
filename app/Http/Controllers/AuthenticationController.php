<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthenticationService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function showForm()
    {
        return view('authentication.form');
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user === null) {
            return redirect()->back()->withErrors(['email' => 'Email not found']);
        }
        $user->sendAuthenticationMail(route('search'));
        return redirect()->back()->with('message', 'Un mail vous a été envoyé');
    }
    public function callback(Request $request){
        $user = User::where('email', $request->email)->first();
        if($user === null){
            return redirect()->back()->withErrors(['email' => 'Email not found']);
        }
        $authenticationService = new AuthenticationService($user);
        $validate = $authenticationService->checkToken($request->token);
        if($validate) Auth::login($user);
        return redirect()->to($request->redirect_to);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('login');
    }
}
