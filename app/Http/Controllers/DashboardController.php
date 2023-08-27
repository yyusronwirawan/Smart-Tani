<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();

        $user = $request->session()->get('uid', 'default');
        $document = $firestore->collection('users')->document($user);
        $collection = $document->collection('device');

        $gardenDocuments = $collection->where('device_type', '==', 'garden')->documents();
        $doorDocuments = $collection->where('device_type', '==' , 'door')->documents();

        $houseCollection = $document->collection('house');
        $houseDocuments = $houseCollection->documents();

        $locationArray = [];
        $deviceArray = [];
        $lampDocuments = array();
        if($houseDocuments->size() > 0) {
            foreach ($houseDocuments as $device) {
                $locationArray[] = $device['location'];
                $deviceArray[] = $device['device_name'];
                $lampDocuments[] = $houseCollection->document($device->id())->collection('lamp')->documents();
            }
        }
        if($gardenDocuments->size() > 0) {
            foreach ($gardenDocuments as $device) {
                $locationArray[] = $device['location'];
                $deviceArray[] = $device['device_name'];
            }
        }

        return view('dashboard')->with(['location' => $locationArray, 'device' => $deviceArray, 'house' => $houseDocuments,'lamp' => $lampDocuments, 'garden' => $gardenDocuments, 'door' => $doorDocuments]);
    }
}
