<?php

namespace App\Http\Controllers;

use Google\Cloud\Datastore\V1\Key;
use Illuminate\Http\Request;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Google\Cloud\Firestore\FieldValue;

class HouseController extends Controller
{
    public function create(Request $request, $deviceId)
    {
        $user = $request->session()->get('uid', 'default');

        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();
        $collection = $firestore->collection('users')->document($user)->collection('house')->document($deviceId)->collection('lamp');

        $dataProperties = [
            'device_name' => $request['lamp_name'],
            'device_type' => 'lamp',
            'room' => $request['room'],
            'date_created' => date('Y-m-d'),
            'control' => ['nilai' => '0', 'sensor' => '0', 'waktu' => '0', 'timestamp' => FieldValue::serverTimestamp()]
        ];

        $validator = Validator::make($request->all(), [
            'lamp_name' => 'required|regex:/^[a-zA-Z0-9\s]+$/|min:5',
            'room' => 'required'
        ]);

        if($validator->fails())
        {
            return redirect()->route('house.read', ['id' => $deviceId, 'addDevice' => 'true'])->withErrors($validator)->withInput();
        }

        $documents = $collection->where("device_name", "=", $request['lamp_name'])->documents();
        foreach ($documents as $document) {
            if($document->exists())
            {
                return back()->withInput()->withErrors(['lamp_name' => "Nama perangkat sudah ada"]);
            }
        }

        $addLamp = $collection->add($dataProperties);
        return redirect()->back()->with(['message' => 'Anda berhasil menambahkan lampu', 'url' => route('lamp.read', ['id' => $deviceId, 'lampId' => $addLamp->id()])]);
        // return redirect()->route('lamp.device', ['id' => $deviceId, 'lampId' => $addLamp->id()]);
    }

    public function read(Request $request, $deviceId)
    {
        $user = $request->session()->get('uid', 'default');

        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();
        $document = $firestore->collection('users')->document($user)->collection('house')->document($deviceId);
        $snapshot = $document->snapshot();
        $data = $snapshot->data();

        //Lamp
        $lampCollection = $document->collection('lamp');
        $lampSnapshot = $lampCollection->orderBy('room', 'asc')->documents();
        $titles = 'room';

        //Title
        $titleArray = [];
        foreach ($lampSnapshot as $title) {
            $titleArray[] = $title[$titles];
        }

        return view('arduino.lamp.house')->with(['id' => $deviceId, 'snapshot' => $snapshot, 'data' => $data, 'lampDocuments' => $lampSnapshot, 'titles' => array_unique($titleArray)]);
    }

    public function delete(Request $request, $deviceId)
    {
        $firestore = app('firebase.firestore');
        $auth = app('firebase.auth');
        $firestore = $firestore->database();
        $user = $request->session()->get('uid', 'default');
        $email = $auth->getUser($user)->email;

        try
        {
            $auth->signInWithEmailAndPassword($email, $request['password']);
            $firestore->collection('users')->document($user)->collection('house')->document($deviceId)->delete();
            return redirect()->route('arduino')->with(['message' => 'Perangkat berhasil dihapus']);
        }
        catch (\Kreait\Firebase\Auth\SignIn\FailedToSignIn $e)
        {
            $message = $e->getMessage();
            if($message == 'INVALID_PASSWORD')
            {
                $message = 'Password salah';
            }
            return redirect()->route('house.read', ['id' => $deviceId, 'errorPane' => 'true'])
            ->withInput()
            ->withErrors(['password' => $message]);
        }
    }

    public function update(Request $data, $deviceId)
    {
        $user = $data->session()->get('uid', 'default');

        $array = [
            'device_name' => $data['device_name'],
            'ip_address' => $data['ip_address'],
            'wifi_ssid' => $data['wifi_ssid'],
            'wifi_password' => $data ['wifi_password'],
            'location' => ['lng' => floatval($data['long']), 'lat' => floatval($data['lat'])]
        ];

        $validator = Validator::make($data->all(), [
            'ip_address' => 'required|ip',
            'device_name' => 'required|regex:/^[a-zA-Z0-9\s]+$/|min:5|max:15',
            'wifi_ssid' => 'required',
            'wifi_password' => 'required|min:8|alpha_num',
            'long' => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'lat' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/']
        ]);

        if($validator->fails())
        {
            return redirect()->route('house.read', ['id' => $deviceId, 'errorPane' => 'true'])->withErrors($validator)->withInput();
        }

        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();
        $collection = $firestore->collection('users')->document($user)->collection('house');
        $documents = $collection->where("device_name", "=", $data["device_name"])->documents();
        foreach($documents as $document)
        {
            if($document->exists())
            {
                if($document->id() != $deviceId)
                {
                    return redirect()->route('house.read', ['id' => $deviceId, 'errorPane' => 'true'])->withErrors(['device_name' => $document["device_name"].' sudah ada']);
                }
            }
        }
        $collection->document($deviceId)->set($array, ['merge' => true]);
        $data->session()->flash('success', 'Data berhasil diperbarui');
        return back();
    }
}
