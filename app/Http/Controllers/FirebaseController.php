<?php
namespace App\Http\Controllers;

use App\Http\Middleware\Firebase;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Firestore;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Kreait\Firebase\Exception\Auth\EmailExists;

class FirebaseController extends Controller
{
    public function index(){
        return view('auth.register');
    }

    public function create(Request $data)
    {
        $auth = app('firebase.auth');
        $firestore = app('firebase.firestore');

        $fullName = $data['first_name'] . ' ' . $data['last_name'];

        $userProperties = [
            'displayName' => $fullName,
            'email' => $data['email'],
            'password' => $data['password'],
            'password_confirmation' => $data['password_confirmation']
        ];

        $validator = Validator::make($data->all(), [
            'email' => 'required|email',
            'first_name' => "required|regex:/^([A-Z][a-z]+([ ]?[a-z]?['-]?[A-Z][a-z]+)*)$/",
            'last_name' => "nullable|regex:/^([A-Z][a-z]+([ ]?[a-z]?['-]?[A-Z][a-z]+)*)$/",
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return back()
            ->withErrors($validator)
            ->withInput();
        }

        else
        {
            try
            {
                $createdUser = $auth->createUser($userProperties);

                $userProperties = [
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'email' => $data['email'],
                    'password' => $data['password'],
                ];

                $user = $auth->getUserByEmail($data['email']);
                $uid = $user->uid;

                //Firestore
                $firestore = $firestore->database();

                $firestore->collection('users')->document($uid)->set($userProperties);

                //Send email
                $sendEmail = $auth->sendEmailVerificationLink($data['email']);

                return redirect()->route('login')->with(['message' => 'Anda berhasil daftar. Silahkan verifikasi melalui email sebelum sign in']);
            }
            catch (\Kreait\Firebase\Exception\Auth\EmailExists $e)
            {
                $message = $e->getMessage();
                return redirect()->route('register')
                ->withInput()
                ->withErrors(['email' => $message]);
            }
        }
    }

    public function email(Request $data)
    {
        $auth = app('firebase.auth');
        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();

        $user = Session::get('user');

        $userSession = $user->uid;

        $uid = $auth->getUser($userSession);
        $email = $uid->email;

        $userProperties = [
            'email' => $data['email'],
            'password' => $data['password']
        ];

        $validator = Validator::make($data->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('profile')
            ->withErrors($validator)
            ->withInput();
        }
        else
        {
            try
            {
                $auth->signInWithEmailAndPassword($email, $userProperties['password']);
                $auth->changeUserEmail($userSession, $data['email']);
                $verified = [
                    'emailVerified' => false
                ];
                $auth->updateUser($userSession, $verified);

                //Update Firestore
                $firestore->collection('users')->document($userSession)->set($userProperties, ['merge' => true]);
                $data->session()->flush();
                $sendEmail = $auth->sendEmailVerificationLink($data['email']);
                return redirect()->route('login')->with('message', 'Anda berhasil memperbarui email anda. Silahkan verifikasi melalui email sebelum sign in');
            }
            catch (\Kreait\Firebase\Exception\Auth\EmailExists $e)
            {
                $message = $e->getMessage();
                return back()
                ->withErrors(['email' => $message])
                ->withInput();
            }
            catch (\Kreait\Firebase\Auth\SignIn\FailedToSignIn $e)
            {
                $message = $e->getMessage();
                if($message == 'INVALID_PASSWORD')
                {
                    $message = 'Password salah';
                }
                return back()
                ->withErrors(['password' => $message])
                ->withInput();
            }
        }
    }
    public function update(Request $data)
    {
        $auth = app('firebase.auth');
        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();

        $userProperties = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name']
        ];

        $fullName = $data['first_name'] . ' ' . $data['last_name'];

        $properties = [
            'displayName' => $fullName
        ];

        $user = Session::get('user');

        $userSession = $user->uid;

        $validator = Validator::make($data->all(), [
            'first_name' => "required|regex:/^([A-Z][a-z]+([ ]?[a-z]?['-]?[A-Z][a-z]+)*)$/",
            'last_name' => "nullable|regex:/^([A-Z][a-z]+([ ]?[a-z]?['-]?[A-Z][a-z]+)*)$/",
        ])->validate();

        try
        {
            //Update Firestore
            $firestore->collection('users')->document($userSession)->set($userProperties, ['merge' => true]);
            //Update Auth
            $auth->updateUser($userSession, $properties);

            return redirect()->route('profile')->with('success', 'Data berhasil diperbarui');
        }
        catch (\Kreait\Firebase\Exception\Auth\AuthError | \Kreait\Firebase\Exception\Auth\EmailExists $e)
        {
            $message = $e->getMessage();
            return redirect()->route('login')
            ->withInput()
            ->withErrors(['email' => $message]);
        }
    }

    public function delete(Request $data)
    {

        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();

        try
        {
            //Define variables
            $auth = app('firebase.auth');
            $pass = $data['password_delete'];
            $uid = Session::get('uid');
            $email = $auth->getUser($uid)->email;

            //Check password if correct
            $auth->signInWithEmailAndPassword($email, $pass);

            //Delete user from auth and firestore
            $auth->deleteUser($uid);
            $firestore->collection('users')->document($uid)->delete();

            //Forget session
            $data->session()->forget('user');

            return redirect()->route('login')->with('message', 'Anda berhasil menghapus akun anda');

        }
        catch (\Kreait\Firebase\Auth\SignIn\FailedToSignIn | \Kreait\Firebase\Exception\Auth\AuthError $e)
        {
            $message = $e->getMessage();
            if ($message == "INVALID_PASSWORD") {
                $message = "Password salah";
            }
            return back()
            ->withInput()
            ->withErrors(['password_delete' => $message]);
        }
    }
}
