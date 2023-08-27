<?php

namespace App\Http\Controllers;

use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Exception\Auth\RevokedIdToken;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function index()
    {
        if(Session::has('user'))
        {
            return redirect()->route('dashboard');
        }
        else
        {
            return view('auth.login');
        }
    }

    public function user(Request $request)
    {
        if(session::has('email') && session::has('password'))
        {
            $email = session::get('email');
            $pass = session::get('password');
        }
        else
        {
            $email = $request->email;
            $pass = $request->password;
        }

        $auth = app('firebase.auth');

        try
        {
            $signIn = $auth->signInWithEmailAndPassword($email, $pass);
            $user = $auth->getUserByEmail($email);

            $verified = $user->emailVerified;

            if($verified != true)
            {
                return redirect()->route('login')
                ->with('message', 'Cek email anda terlebih dahulu untuk verifikasi email');
            }
            else
            {
                $request->session()->put('asTokenResponse', $signIn->asTokenResponse());
                if($request->has('redirect')) {
                    return redirect()->away($request['redirect']);
                }
                else {
                    return redirect()->route('dashboard');
                }
            }

        } catch (\Kreait\Firebase\Auth\SignIn\FailedToSignIn | \Kreait\Firebase\Exception\InvalidArgumentException | \Kreait\Firebase\Exception\Auth\InvalidPassword $e)
        {
            $message = $e->getMessage();
            if($message == 'EMAIL_NOT_FOUND' || $message == 'INVALID_PASSWORD')
            {
                $message = 'Email atau password salah';
            }
            return back()
            ->withInput()
            ->withErrors(['email' => $message]);
        }
    }

    public function logout(Request $request)
    {
        $auth = app('firebase.auth');
        $uid = Session::get('uid');
        $auth->revokeRefreshTokens($uid);
        $request->session()->flush();
        return redirect()->route('login')->with(['message' => 'Logout telah berhasil']);
    }
}
