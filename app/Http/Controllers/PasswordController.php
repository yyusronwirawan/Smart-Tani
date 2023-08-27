<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function update(Request $request)
    {
        $oldPass = $request->current_password;
        $newPass = $request->password_new;
        $confirmPass = $request->password_confirmation;

        $array = [
            'password' => $newPass
        ];

        if($newPass != $confirmPass)
        {
            $message = "Password salah";
            return redirect()
            ->route('profile')
            ->withInput()
            ->withErrors(['password_confirmation' => $message]);
        }
            $auth = app('firebase.auth');
            $user = $request->session()->get('user');
            $user = $user->uid;
            $uid = $auth->getUser($user);
            $email = $uid->email;
            $uid = $uid->uid;
            try
            {
                $auth->signInWithEmailAndPassword($email, $oldPass);
                $auth->changeUserPassword($uid, $newPass);
                $firestore = app('firebase.firestore');
                $firestore = $firestore->database();
                $firestore->collection('users')->document($uid)
                ->set($array, ['merge' => true]);

                $message = 'Password diperbarui';
                $request->session()->flash('success', $message);

                return redirect()->back();
                // $auth->signInWithEmailAndPassword($email, $newPass);
                // return redirect()->route('user.login')->with(['email' => $email, 'password' => $newPass]);
            }
            catch (\Kreait\Firebase\Exception\Auth\WeakPassword $e)
            {
                $message = $e->getMessage();
                return redirect()->back()
                ->withInput()
                ->withErrors(['password_new' => $message]);
            }
            catch (\Kreait\Firebase\Exception\InvalidArgumentException $e)
            {
                $message = $e->getMessage();
                return redirect()->back()
                ->withInput()
                ->withErrors(['password_new' => $message]);
            }
            catch (\Kreait\Firebase\Auth\SignIn\FailedToSignIn $e)
            {
                $message = $e->getMessage();
                if($message == 'INVALID_PASSWORD')
                {
                    $message = 'Password salah';
                }
                return redirect()->route('profile')
                ->withInput()
                ->withErrors(['current_password' => $message]);
            }
            return redirect()->route('profile');
    }
}
