<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function list()
    {
        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();

        //Firestore
        $collectionReference = $firestore->collection('rooms');
        $documents = $collectionReference->orderBy('name')->documents();
        foreach ($documents as $document)
        {
            $roomArray[] = $document['name'];
        }

        return response()->json($roomArray, 200);
    }
}
