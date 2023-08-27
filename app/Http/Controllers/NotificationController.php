<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function security(Request $request, $userId)
    {
        //Ambil judul dan isi notifikasi
        $title = $request['title'];
        $body = $request['body'];
        $topics = "/topics/".$userId;

        //url untuk firebase cloud messaging
        $url = "https://fcm.googleapis.com/fcm/send";

        //server key
        $serverkey = "AAAA1lYyfYo:APA91bEm6-F_u-iNxphXx5RIzZ5Q7ODvJv46ZpaXLeexLA_YP38mJEXrZUblZsWFv9G-jqqzBcYGILe7-42VEt2DdreFVxmJyX6DAlXRqk4ifFtyH5VAZibqFKhCyZ475k5VMNw7Jnqy";

        //data json notifikasi
        $notification = array('title'=>$title, 'body'=>$body, 'sound'=>'default', 'badge'=>'1');

        //tujuan notifikasi
        $arrayToSend = array('to'=>$topics, 'notification'=>$notification, 'priority'=>'high');

        $json = json_encode($arrayToSend);
        $header = array();
        $header[] = 'Content-Type:application/json';
        $header[] = 'Authorization: key='.$serverkey;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);

        //send request
        $response = curl_exec($curl);

        //close request
        if($response === FALSE){
            return response()->json(['message' => 'FCM Send Error : '.curl_error($curl)], 500);
        }
        curl_close($curl);
        return response()->json(['message' => 'Notifikasi berhasil', 'content' => [$title, $body]]);
    }
}
