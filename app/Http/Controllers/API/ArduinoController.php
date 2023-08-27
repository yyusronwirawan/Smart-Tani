<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArduinoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $userId)
    {
        if (empty($request['sortBy'])) {
            $request->request->add(['sortBy' => 'type']);
        }

        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();

        $user = $userId;
        $sortBy = $request['sortBy'];
        $document = $firestore->collection('users')->document($user);
        $collection = $document->collection('device');

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

        foreach($snapshot as $document) {
            $json[] = $document->data();
        }

        // die(print_r($snapshot));

        return response()->json($json, 200);
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

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
