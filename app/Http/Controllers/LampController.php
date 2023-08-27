<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LampController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $houseId, $lampId)
    {
        $user = $request->session()->get('uid', 'default');

        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();
        $document = $firestore->collection('users')->document($user)->collection('house')->document($houseId);
        $snapshot = $document->snapshot();

        if($snapshot->exists()) {

            $collection = $document->collection('lamp');
            $documents = $collection->document($lampId);
            $lampSnapshot = $documents->snapshot();
            // $lampData = $lampSnapshot->data();

            return view('arduino.lamp.device')->with(['houseId' => $houseId, 'lampId' => $lampId, 'houseSnapshot' => $snapshot, 'snapshot' => $lampSnapshot]);
        }

        return response($status = 404);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $deviceId, $lampId)
    {
        $user = $request->session()->get('uid', 'default');

        $array = [
            'room' => $request['room'],
            'device_name' => $request['device_name']
        ];

        $validator = Validator::make($request->all(), [
            'device_name' => 'required|regex:/^[a-zA-Z0-9\s]+$/|min:5'
        ]);

        if($validator->fails())
        {
            return redirect()->route('lamp.read', ['id' => $deviceId, 'lampId' => $lampId, 'errorPane' => 'true'])->withErrors($validator)->withInput();
        }

        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();
        $collection = $firestore->collection('users')->document($user)->collection('house')->document($deviceId)->collection('lamp');
        $documents = $collection->where('device_name', '==', $request['device_name'])->documents();
        foreach($documents as $document)
        {
            if($document->exists())
            {
                if($document->id() != $lampId)
                {
                   return redirect()->route('lamp.read', ['id' => $deviceId, 'lampId' => $lampId, 'errorPane' => 'true'])->withErrors(['device_name' => $document['device_name'].' sudah ada']);
                }
            }
        }
        $collection->document($lampId)->set($array, ['merge' => true]);
        return back()->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $deviceId, $lampId)
    {
        $firestore = app('firebase.firestore');
        $auth = app('firebase.auth');
        $firestore = $firestore->database();
        $user = $request->session()->get('uid', 'default');
        $email = $auth->getUser($user)->email;

        try
        {
            $auth->signInWithEmailAndPassword($email, $request['password']);
            $document = $firestore->document('users/'.$user.'/house/'.$deviceId.'/lamp/'.$lampId);
            $snapshot = $document->snapshot();
            $data = $snapshot->data();

            $document->delete();
            return redirect()->route('house.read', ['id' => $deviceId])->with(['message' => $data['device_name'].'berhasil dihapus']);
        }
        catch (\Kreait\Firebase\Auth\SignIn\FailedToSignIn $e)
        {
            $message = $e->getMessage();
            if($message == 'INVALID_PASSWORD')
            {
                $message = 'The password is incorrect';
            }
            return redirect()->route('lamp.read', ['id' => $deviceId, 'lampId' => $lampId, 'errorPane' => 'true'])
            ->withInput()
            ->withErrors(['password' => $message]);
        }
    }
}
