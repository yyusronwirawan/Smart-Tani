<?php

namespace App\Http\Controllers;

// use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Google\Cloud\Firestore\FirestoreClient;
use Kreait\Firebase\Auth;

class ProfileController extends Controller
{

    public function index(Request $request)
    {
        $userSession = $request->session()->get('user');
        $uid = $userSession->uid;

        $auth = app('firebase.auth');
        $user = $auth->getUser($uid);

        //Firestore
        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();

        $collectionReference = $firestore->collection('users');
        $documentReference = $collectionReference->document($userSession->uid);
        $snapshot = $documentReference->snapshot();

        $initial = substr($snapshot['first_name'], 0, 1) . substr($snapshot['last_name'], 0, 1);
        return view('profile.edit')->with(['initial' => $initial, 'user' => $user]);
    }

    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user()
        ]);
    }
}
