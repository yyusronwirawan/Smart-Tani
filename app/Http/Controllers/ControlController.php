<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Firestore\FieldValue;
use Google\Cloud\Firestore\FirestoreClient;
use Kreait\Firebase\Firestore;
use Google\Cloud\Core\Timestamp;
use Illuminate\Pagination\Paginator;

class ControlController extends Controller
{
    public function index(Request $request){

        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();
        $userId = $request->session()->get('uid', 'default');
        $collection = $firestore->collection('users')->document($userId)->collection('history_control')->orderBy('timestamp', 'desc');
        $allDocuments = $collection->documents();
        // $allSize = $allDocuments->size();

        if($request->has('device'))
        {
            $collection = $collection->where('device_type', '=', $request['device']);
            $allDocuments = $collection->documents();
        };
        $limit = 10;
        $query = $collection->limit($limit)->offset($request['page'] * $limit );

        $filteredDocuments = $query->documents();
        $size = $allDocuments->size();
        foreach ($filteredDocuments as $document) {
            $data[] = $document->data();
        }

        $page = $request['page'] ? $request['page'] : 1;
        $first_page = $page > 1 ? $page * $limit : 0;

        $prev = $page - 1;
        $next = $page + 1;


        $pagination = [
            'total' => $size,
            'per_page' => $limit,
            'current_page' => $page,
            'first_page' => 1,
            'last_page' => ceil($size/$limit) - 1,
            'first_page_url' => route('control', ['page' => 1, 'device' => $request['device']]),
            'current_page_url' => route('control', ['page' => $request['page'], 'device' => $request['device']]),
            'last_page_url' => route('control', ['page' => ceil($size/$limit) - 1, 'device' => $request['device']]),
            'next_page_url' => route('control', ['page' => $next, 'device' => $request['device']]),
            'prev_page_url' => route('control', ['page' => $prev, 'device' => $request['device']]),
            'path' => url()->full(),
            // 'from' => $filteredDocuments->size()/$limit,
            // 'to' => ($filteredDocuments->size()/$limit) + $limit,
            'data' => empty($data) ? null : $data
        ];

        // return response()->json($pagination, 200);
        $listDevice = [];

        return view('control')->with(['listDevice' => $listDevice, 'control' => $pagination['data'], 'pagination' => $pagination]);
    }

    public function read(Request $request, $userId)
    {
        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();
        $collection = $firestore->collection('users')->document($userId)->collection('history_control');
        $allDocuments = $collection->documents();
        $allSize = $size;

        if($request->has('filter')){
            $json = json_decode($request->input('filter'));
            $filter = $json->device_name;
            $collection = $collection->where('device_name', '==', $filter);
            $allSize = $collection->documents()->size();
        }

        $query = $collection->orderBy('timestamp', 'desc')->limit(!empty($request['limit']) ? $request['limit'] : $allSize)->offset(!empty($request['offset']) ? $request['offset'] : 0);
        $documents = $query->documents();

        $controlArray = [];

        foreach($documents as $document)
        {
            if($document->exists())
            {
                $data = $document->data();
                $timestamp = $data['timestamp']->formatAsString();
                $timestamp = date("m/d/y H:i:s", strtotime($timestamp.' +7 hours'));
                // die(print($timestamp));
                if($data['device_type'] == 'garden')
                {
                    switch ($data['control']['nilai']) {
                        case '0':
                            $status = 'otomatis';
                            break;
                        case '1':
                            $status = 'terjadwal';
                            break;
                        case '2':
                            $status = 'aktif';
                            break;
                        case '3':
                            $status = 'nonaktif';
                            break;
                        default:
                            return response()->json(['message' => 'Sensor tidak terdaftar'], 500);
                            break;
                    }
                }
                if($data['device_type'] == 'lamp')
                {
                    switch ($data['control']['nilai']) {
                        case '0':
                            $status = 'aktif';
                            break;
                        case '1':
                            $status = 'cahaya';
                            break;
                        case '2':
                            $status = 'gerak';
                            break;
                        default:
                            return response()->json(['message' => 'Sensor tidak terdaftar'], 500);
                            break;
                    }
                }
                if($data['device_type'] == 'door')
                {
                    switch ($data['control']['nilai']) {
                        case 'value':
                            # code...
                            break;

                        default:
                            # code...
                            break;
                    }
                }
                $controlArray[] = [
                    "device_name" => !empty($data['device_name']) ? $data['device_name'] : null,
                    "nilai" => $status,
                    "device_type" => $data['device_type'],
                    "timestamp" => $timestamp
                ];
            }
            else {
                return response()->json(['message' => 'Data tidak ditemukan'], 500);
            }
        }

        return response()->json([
            'total' => $allSize,
            'totalNotFiltered' => $allSize,
            'rows' => $controlArray
        ], 200);
    }
}
