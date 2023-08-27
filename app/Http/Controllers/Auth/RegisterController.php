<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Firestore;
use Google\Cloud\Firestore\FirestoreClient;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Auth;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if(request()->ajax()){
            $auth = app('firebase.auth');
            $firestore = app('firebase.firestore');
            $firestore = $firestore->database();

            $userProperties = [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => $data['password'],
            ];

            // $signInResult->firebaseUserId();

            $createdUser = $auth->createUser($userProperties);
            $user = $data['userId'];
            $firestore->collection('users')->document($user)->set($userProperties);

        }
        // return User::create([
        //     'name' => $data['name'],
        //     'username' => $data['username'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        // ]);

        //Firebase
        // $factory = (new Factory)->withDatabaseURI('https://smarthomeproject-8a0ad.firebaseio.com/');
    }
}
