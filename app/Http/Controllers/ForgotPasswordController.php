<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('auth.passwords.email');
    }

    public function reset(Request $request)
    {
        $auth = app('firebase.auth');

        $email = $request['email'];

        try
        {
            $auth->sendPasswordResetLink($email);
            Session::flash('message', 'Silahkan cek email anda untuk reset password');
            return redirect()->route('login');
        }
        catch (\Kreait\Firebase\Auth\SendActionLink\FailedToSendActionLink $e)
        {
            $message = $e->getMessage();
            return back()->withInput()->withErrors(['email' => "Kami tidak dapat menemukan email anda"]);
        }

    }
}
