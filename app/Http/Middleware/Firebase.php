<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\Auth\Token\Exception\InvalidToken;
use Illuminate\Support\Facades\Session;
// use Kreait\Firebase\Exception\Auth\RevokedIdToken;
use Illuminate\Http\Request;

class Firebase
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $auth = app('firebase.auth');
        $redirect = redirect()->route('login', ['redirect' => url()->full()]);

        if(Session::has('asTokenResponse'))
        {
            $tokenResponse = Session::get('asTokenResponse');

            try
            {
                $signInResult = $auth->signInWithRefreshToken($tokenResponse['refresh_token']);
                $idToken = $signInResult->idToken();
                // $idToken = $tokenResponse['id_token'];
                $verifiedIdToken = $auth->verifyIdToken($idToken, $checkIfRevoked = true);

                $uid = $verifiedIdToken->getClaim('sub');
                $request->session()->flash('uid', $uid);

                $user = $auth->getUser($uid);
                $request->session()->flash('user', $user);
                // die(print_r($verifiedIdToken));
                return $next($request);
            }
            catch (\Kreait\Firebase\Auth\SignIn\FailedToSignIn $e)
            {
                $request->session()->flush();
                $message = "Sistem gagal melakukan login";
                if($e->getMessage() == 'TOKEN_EXPIRED')
                {
                    $message = 'Mohon lakukan login kembali sebelum melanjutkan';
                }
                return $redirect->with('message', $message);
            }
            catch (\InvalidArgumentException $e)
            {
                $request->session()->flush();
                $message = "Sepertinya ada error pada sistem, mohon lakukan login ulang. Error: ".$e;
                return $redirect->with('message', $message);
            }
            catch (InvalidToken $e)
            {
                $request->session()->flush();
                $message = "Sepertinya ada error pada sistem, mohon lakukan login ulang. Error: ".$e;
                return $redirect->with('message', $message);
            }
            catch (RevokedIdToken $e)
            {
                $request->session()->flush();
                $message = "Mohon lakukan login kembali. Error: ".$e;
                return $redirect->with('message', $message);
            }
        }
        else
        {
            return $redirect;
        }

    }
}
