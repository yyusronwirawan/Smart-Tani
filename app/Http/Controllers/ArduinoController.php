<?php

namespace App\Http\Controllers;

use Google\Cloud\Datastore\V1\Key;
use Google\Cloud\Firestore\FieldValue;
use Illuminate\Http\Request;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ArduinoController extends Controller
{
    public function ajax(Request $request)
    {
        $device = $request['collection'];
        $deviceId = $request['device_id'];

        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();

        $user = $request->session()->get('uid', 'default');
        $document = $firestore->collection('users')->document($user);
        $collection = $document->collection($device);
        return response()->json();
    }
    public function index(Request $request)
    {
        if (empty($request['sortBy'])) {
            $request->request->add(['sortBy' => 'type']);
        }

        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();

        $user = $request->session()->get('uid', 'default');
        $sortBy = $request['sortBy'];
        $document = $firestore->collection('users')->document($user);
        $collection = $document->collection('device');
        $view = view('arduino.list');
        $houseCollection = $document->collection('house');

        switch ($sortBy) {
            case 'room':
                $snapshot = $collection->orderBy('room', 'ASC')->documents();
                $titles = 'room';
            break;
            case 'type':
                $snapshot = $collection->orderBy('device_type', 'ASC')->documents();
                $titles = 'device_type';
            break;
            default:
                $snapshot = $collection->orderBy('device_type', 'ASC')->documents();
                $titles = 'device_type';
            break;
        }

        $houseSnapshot = $houseCollection->documents();

        //Title
        $titleArray = [];
        foreach ($snapshot as $title) {
            $titleArray[] = $title[$titles];
        }

        return $view->with(['houseSnapshot' => $houseSnapshot, 'snapshot' => $snapshot, 'userId' => $user, 'titles' => array_unique($titleArray)]);
    }

    public function lamp($userId)
    {
        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();

        $user = $userId;

        $document = $firestore->collection('users')->document($user);
        $collection = $document->collection('device');
        $documents = $collection->where('device_type', '=', 'lamp')->documents();

        foreach($documents as $document)
        {
            $data = $document->data();
        }
        return response()->json($data);
    }

    public function create(Request $request)
    {
        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();

        $user = $request->session()->get('uid', 'default');

        $document = $firestore->collection('users')->document($user);

        $dataProperties = [
            'device_name' => $request['device_name'],
            'device_type' => $request['device_type'],
            'ip_address' => $request['ip_address'],
            'wifi_ssid' => $request['wifi_ssid'],
            'wifi_password' => $request['wifi_password'],
            'date_created' => date('Y-m-d'),
            'location' => ['lng' => (float)$request['long'], 'lat' => (float)$request['lat']]
        ];

        $validator = Validator::make($request->all(), [
            'ip_address' => 'required|ip',
            'device_name' => 'required|regex:/^[a-zA-Z0-9\s]+$/|min:5|max:15',
            'wifi_ssid' => 'required',
            'room' => Rule::requiredIf($request['device_type'] != 'house'),
            'wifi_password' => 'required|min:8|alpha_num',
            'long' => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'lat' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/']
        ]);

        if($validator->fails())
        {
            return redirect()->route('arduino', ['addDevice' => 'true'])->withErrors($validator)->withInput();
        }

        $deviceType = $request['device_type'];

        switch ($deviceType) {
            case 'house':
                $collection = $document->collection('house');
                break;
            default:
                $dataProperties['room'] = strtolower($request['room']);
                $collection = $document->collection('device');
                break;
        }

        //Garden and Door
        $documents = $collection->where("device_name", "=", $request["device_name"])->documents();
        foreach($documents as $document) {
            if($document->exists())
            {
                return back()->withInput()->withErrors(['device_name' => 'Nama perangkat sudah ada']);
            }
        }
        switch ($deviceType) {
            case 'house':
                $dataProperties['control'] = [
                    'nilai' => '0',
                    'sensor' => '0',
                    'waktu' => '0',
                    'timestamp' => FieldValue::serverTimestamp()
                ];
                $dataProperties['last_sensor'] = [
                    'temp' => '0',
                    'humid' => '0',
                    'cahaya' => '0',
                    'gerak' => '0'
                ];
                $dataProperties['chart'] = ['temp', 'humid', 'cahaya'];
                $dataProperties['sensor'] = ['tanggal', 'jam', 'temp', 'humid', 'cahaya', 'gerak'];
            break;
            case 'door':
                $dataProperties['control'] = [
                    'nilai' => '0',
                    'security' => '0',
                    'timestamp' => FieldValue::serverTimestamp()
                ];
            break;
            case 'garden':
                $dataProperties['last_sensor'] = [
                    'lembap' => '0',
                    'sm' => '0',
                    'suhu' => '0',
                    'relay' => '0'
                ];
                $dataProperties['sensor'] = ['tanggal', 'jam', 'lembap', 'sm', 'suhu', 'relay'];
                $dataProperties['chart'] = ['lembap', 'sm', 'suhu'];
                $dataProperties['control'] = [
                    'nilai' => '0',
                    'timestamp' => FieldValue::serverTimestamp()
                ];
            break;
            default:
                return back()->withErrors($deviceType, 'Tipe data tidak valid')->withInput();
            break;
        }
        $addDevice = $collection->add($dataProperties);

        // return response()->route('sensor.add', ['deviceType' => $request['device_type'], 'deviceId' => $addDevice->id(), 'id' => session('uid')]);

        switch ($deviceType) {
            case 'house':
                return redirect()->route('house.read', ['id' => $addDevice->id()])->with(['message' => 'Anda berhasil menambahkan perangkat rumah. Selanjutnya lakukan instalasi pada perangkat anda agar terhubung dan tambahkan lampu pertama anda. <a href="#setup" id="setupLink">Lanjut ke instalasi</a>']);
                break;
            default:
                return redirect()->route('arduino.read', ['id' => $addDevice->id()])->with(['message' => 'Anda berhasil menambahkan perangkat arduino. Selanjutnya lakukan instalasi pada perangkat anda agar terhubung. <a href="#setup" id="setupLink">Lanjut ke instalasi</a>']);
                break;
        }
    }

    public function read(Request $request, $deviceId)
    {
        $user = $request->session()->get('uid', 'default');

        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();
        $document = $firestore->collection('users')->document($user)->collection('device')->document($deviceId);
        $snapshot = $document->snapshot();


        if ($snapshot->exists()) {

            $collection = $document->collection('sensor')->orderBy('tanggal');
            $documents = $collection->documents();
            $documentArray = [];
            foreach($documents as $document)
            {
                $documentArray[] = $document->data();
            }

            return view('arduino.device')->with(['id' => $deviceId, 'data' => $snapshot]);
        }
        else {
            return redirect()->route('arduino');
        }
    }

    public function update(Request $data, $deviceId)
    {
        $user = $data->session()->get('uid', 'default');

        $array = [
            'room' => $data['room'],
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
            return redirect()->route('arduino.read', ['id' => $deviceId, 'errorPane' => 'true'])->withErrors($validator)->withInput();
        }

        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();
        $collection = $firestore->collection('users')->document($user)->collection('device');
        $documents = $collection->where("device_name", "=", $data["device_name"])->documents();
        foreach($documents as $document)
        {
            if($document->exists())
            {
                if($document->id() != $deviceId)
                {
                    return redirect()->route('arduino.read', ['id' => $deviceId, 'errorPane' => 'true'])->withErrors(['device_name' => $document["device_name"].' sudah terdaftar']);
                }
            }
        }
        $collection->document($deviceId)->set($array, ['merge' => true]);
        $data->session()->flash('success', 'Data telah diperbarui');
        return back();
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
            $firestore->collection('users')->document($user)->collection('device')->document($deviceId)->delete();
            return redirect()->route('arduino')->with(['message' => 'Perangkat berhasil dihapus']);
        }
        catch (\Kreait\Firebase\Auth\SignIn\FailedToSignIn $e)
        {
            $message = $e->getMessage();
            if($message == 'INVALID_PASSWORD')
            {
                $message = 'Password salah';
            }
            return redirect()->route('arduino.read', ['id' => $deviceId, 'errorPane' => 'true'])->withInput()
            ->withErrors(['password' => $message]);
        }

    }
}
