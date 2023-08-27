<?php

namespace App\Http\Controllers;

use Google\Cloud\Firestore\FieldValue;
use Google\Cloud\Firestore\FirestoreClient;
use Kreait\Firebase\Firestore;
use Google\Cloud\Core\Timestamp;
use Illuminate\Http\Request;
use DateTime;
use DatePeriod;
use DateInterval;
use Response;
use Illuminate\Support\Facades\Storage;


class SensorController extends Controller
{
    public function download(Request $request, $userId, $deviceId)
    {
        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();

        $documentId = $firestore->collection('users')->document($userId);

        $document = $documentId->collection('device')->document($deviceId);

        $snapshot = $document->snapshot();

        switch ($request['device_type']) {
            case 'house':
                $document = $documentId->collection('house')->document($deviceId);
                $snapshot = $document->snapshot();
                $filename = "lamp-".$userId.".ino";
                $codes[$filename] = '#include <ESP8266WiFi.h>

#define LED1 1
#define LED2 3
#define LED3 5
#define LED4 4
#define LED5 0
#define LED6 2
#define LED7 14
#define LED8 16
#define LED9 13
#define LED10 12

const char* ssid = "'.$snapshot["wifi_ssid"].'";               // Nama WIFI kamu
const char* password = "'.$snapshot["wifi_password"].'";                  // Password Wifi
const char* host = "'.$snapshot["ip_address"].'";                 // Link website / Ip Server

bool Parsing = false;
String dataPHP, data[11];

void setup()
{
Serial.begin(9600);
Serial.println();

Serial.printf("Connecting to %s ", ssid);
WiFi.begin(ssid, password);
while (WiFi.status() != WL_CONNECTED)
{
delay(500);
Serial.print(".");
}
Serial.println(" connected");

pinMode(LED1, OUTPUT);
pinMode(LED2, OUTPUT);
pinMode(LED3, OUTPUT);
pinMode(LED4, OUTPUT);
pinMode(LED5, OUTPUT);
pinMode(LED6, OUTPUT);
pinMode(LED7, OUTPUT);
pinMode(LED8, OUTPUT);
pinMode(LED9, OUTPUT);
pinMode(LED10, OUTPUT);
}

void loop()
{
WiFiClient client;

Serial.printf("\n[Connecting to %s ... ", host);
if (client.connect(host, 80)) {
Serial.println("connected]");
Serial.println("[Sending a request]");

String url = "lcs/wemos/lampu"; // Lokasi File Baca Data
client.print(String("GET /") + url + " HTTP/1.1\r\n" +
        "Host: " + host + "\r\n" +
        "Connection: close\r\n" +
        "\r\n"
    );

Serial.println("[Response:]");
while (client.connected())
{
dataPHP = client.readStringUntil("\n");
int q = 0;
Serial.print("Data Masuk : ");
//Serial.print(dataPHP);
Serial.println();

data[q] = "";
for (int i = 0; i < dataPHP.length(); i++) {
if (dataPHP[i] == "#") {
q++;
data[q] = "";
}
else {
data[q] = data[q] + dataPHP[i];
}
}

if (data[1].toInt() == 1)
{
digitalWrite(LED1, LOW);
}
if (data[1].toInt() == 0)
{
digitalWrite(LED1, HIGH);
}
Serial.println(data[1].toInt());


Serial.println(data[2].toInt());
if (data[2].toInt() == 1)
{
digitalWrite(LED2, LOW);
}
if (data[2].toInt() == 0)
{
digitalWrite(LED2, HIGH);
}

Serial.println(data[3].toInt());
if (data[3].toInt() == 1)
{
digitalWrite(LED3, LOW);
}
if (data[3].toInt() == 0)
{
digitalWrite(LED3, HIGH);
}

Serial.println(data[4].toInt());
if (data[4].toInt() == 1)
{
digitalWrite(LED4, LOW);
}
if (data[4].toInt() == 0)
{
digitalWrite(LED4, HIGH);
}

Serial.println(data[5].toInt());
if (data[5].toInt() == 1)
{
digitalWrite(LED5, LOW);
}
if (data[5].toInt() == 0)
{
digitalWrite(LED5, HIGH);
}

Serial.println(data[6].toInt());
if (data[6].toInt() == 1)
{
digitalWrite(LED6, LOW);
}
if (data[6].toInt() == 0)
{
digitalWrite(LED6, HIGH);
}

Serial.println(data[7].toInt());
if (data[7].toInt() == 1)
{
digitalWrite(LED7, LOW);
}
if (data[7].toInt() == 0)
{
digitalWrite(LED7, HIGH);
}

Serial.println(data[8].toInt());
if (data[8].toInt() == 1)
{
digitalWrite(LED8, LOW);
}
if (data[8].toInt() == 0)
{
digitalWrite(LED8, HIGH);
}

Serial.println(data[9].toInt());
if (data[9].toInt() == 1)
{
digitalWrite(LED9, LOW);
}
if (data[9].toInt() == 0)
{
digitalWrite(LED9, HIGH);
}

Serial.println(data[10].toInt());
if (data[10].toInt() == 1)
{
digitalWrite(LED10, LOW);
}
if (data[10].toInt() == 0)
{
digitalWrite(LED10, HIGH);
}

Parsing = false;
dataPHP = "";

}
client.stop();
Serial.println("\n[Disconnected]");
}
else
{
Serial.println("connection failed!]");
client.stop();
}
delay(1000);
}
                ';
                $filename = "temperature-".$userId.".ino";
                $codes[$filename] = '#include <ESP8266WiFi.h>
#include <DHT.h>
DHT dht(5, DHT11); //Pin, Jenis DHT


const int pinSensor = A0;
int pinPIR = 4;
int statusPIR = 0;

const char* ssid = "'.$snapshot["wifi_ssid"].'";               // Nama WIFI kamu
const char* password = "'.$snapshot["wifi_password"].'";                  // Password Wifi
const char* host = "'.$snapshot["ip_address"].'";                 // Link website / Ip Server

void setup(){
Serial.begin(9600);
Serial.println();

Serial.printf("Connecting to %s ", ssid);
WiFi.begin(ssid, password);
while (WiFi.status() != WL_CONNECTED)
{
delay(500);
Serial.print(".");
}
Serial.println(" connected");

dht.begin();


}

void loop(){
WiFiClient client;

Serial.printf("\n[Connecting to %s ... ", host);
if (client.connect(host, 80)) {
Serial.println("connected]");
Serial.println("[Sending a request]");


//DHT11
int kelembaban = dht.readHumidity();
int suhu = dht.readTemperature();
Serial.print("kelembaban: ");
Serial.print(kelembaban);
Serial.print(" ");
Serial.print("suhu: ");
Serial.println(suhu);

//Cahaya
int cahaya;
cahaya = analogRead(pinSensor);
Serial.print("kecerahan : ");
Serial.println(cahaya);

//gerak
int gerak;
statusPIR = digitalRead(pinPIR);
if (statusPIR ==HIGH) {            //jika sensor membaca gerakan maka relay akan aktif

Serial.println("ADA GERAKAN");
gerak = 1;
delay(100); //Diberikan waktu tunda 10 detik
}
else {
gerak = 0;
Serial.println("TIDAK ADA GERAKAN");
}
Serial.println(gerak);

Serial.print("GET lcs/wemos/sensor?temp=");
Serial.print(suhu);
Serial.print("&humid=");
Serial.print(kelembaban);
Serial.print("&cahaya=");
Serial.print(cahaya);
Serial.print("&gerak=");
Serial.print(gerak);
client.print(String("GET /") + "lcs/wemos/sensor?temp=" + suhu + "&humid=" + kelembaban + "&cahaya=" + cahaya + "&gerak=" + gerak + " HTTP/1.1\r\n" +
            "Host: " + host + "\r\n" +
            "Connection: close\r\n" +
            "\r\n"
        );
}


else
{
Serial.println("connection failed!]");
client.stop();
}


delay(60000);
}
';
                $filename = "lamp-".$userId.".ino";
                break;
            case 'garden':
                $filename = "garden-".$deviceId.".ino";
                $codes[$filename] = '#include <ESP8266WiFi.h>
#include <WiFiClientSecure.h>
#include <DHT.h>
#define DHTPIN 4
#define DHTTYPE DHT11
DHT dht(DHTPIN, DHTTYPE);
#include <ESP8266WebServer.h>
#include <ESP8266HTTPClient.h>

//CONNECT WIFI, ganti wifi anda di sini
char ssid[] = "'.$snapshot['wifi_ssid'].'";     // your network SSID (name)
char password[] = "'.$snapshot['wifi_password'].'"; // your network key
char raspi_input[] = "http://'.$snapshot['ip_address'].':5000/input";
const char* control_page="control/2";
char id_arduino[]="'.$document->id().'";
char nama[]="'.$snapshot['device_name'].'";

WiFiClientSecure client;
String control;
int led1=14;
int stat = 0;
int led2=13;
int relay=5;
int buzzer=12;
float h=0;
float t=0;
int sm=0;
int Relay = 0;
int limit=0;

int smval=0;
int val=0;
bool Start = false;

int readSuhu(){
    smval = analogRead(sm);
    Serial.println(smval);
    return smval;
}

//Relay control for timing
void relay1(int Relay){
    if(Relay==1){
    digitalWrite(relay,HIGH);
    delay(1000);
    digitalWrite(relay,LOW);
    }
    else if(Relay==0)
    digitalWrite(relay,LOW);
}


//upload data to raspberry server local
void post(){
    HTTPClient http;    //Declare object of class HTTPClient
    //Sensor
    smval = readSuhu();
    val= map(smval,1023,465,0,100);
    if(val<0)val=0;
    else if (val>100)val=100;
    h = dht.readHumidity();
    t = dht.readTemperature();
    //Post Data
    String postData;
    postData = "suhu=" + String(t) + "&lembap=" + String(h) + "&sm=" + String(val) + "&relay=" + String(Relay)+ "&id_arduino="+String(id_arduino)+ "&nama="+String(nama);
    //NGROK SERVER LOCAL HARAP DIGANTI SETIAP BOOT UP SERVER
    http.begin(raspi_input);              //Specify request destination
    http.addHeader("Content-Type", "application/x-www-form-urlencoded"); //Specify content-type header
    int httpCode = http.POST(postData);   //Send the request
    String payload = http.getString();    //Get the response payload
    Serial.println(httpCode);   //Print HTTP return code
    Serial.println(payload);    //Print request response payload
    http.end();  //Close connection
    Serial.println("Post berhasil");
    Serial.println("Suhu: " + String(t) +", Kelembapan: " + String(h) +", SM: "+ String(val) + ", relay: "+ String(Relay)+ ", id: "+ String(id_arduino));
}

//-------------------SETUP MULAI------------------
void setup() {
    Serial.begin(9600);
    dht.begin();
    // Set WiFi to station mode and disconnect from an AP if it was Previously
    // connected
    WiFi.mode(WIFI_STA);
    WiFi.disconnect();
    delay(10);
    pinMode(buzzer,OUTPUT);
    pinMode(relay,OUTPUT);
    pinMode(led1,OUTPUT);
    pinMode(led2,OUTPUT);
    Serial.print("Connecting Wifi: ");
    Serial.println(ssid);
    WiFi.begin(ssid, password);
    while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");//if not connected printing .........
    digitalWrite(led1,HIGH);
    delay(50);
    }
    Serial.println("");
    Serial.println("WiFi connected");
    Serial.print("IP address: ");
    Serial.println(WiFi.localIP());
    digitalWrite(led1,LOW);
    client.setInsecure();
}

//----------------LOOP MULAI-----------------

void loop(){
    if (WiFi.status() != WL_CONNECTED) {
        delay(1);
        digitalWrite(led1,HIGH);
        WiFi.begin(ssid, password);
        return;
    }

    smval = readSuhu();
    val= map(smval,1023,465,0,100);
    if(val<0)val=0;
    else if (val>100)val=100;
    Serial.println("Notif mositure bot");
    if (val < 40.00 && limit==3) {
    String welcome = "Perhatian, tanah kering! \U0001F525";
    welcome += "\n\nSoil Moisture : ";
    welcome += val;
    welcome += "%\nRelay dinyalakan ";
        digitalWrite(buzzer,HIGH);
        delay(500);
        digitalWrite(buzzer,LOW);
        delay(500);
        digitalWrite(buzzer,HIGH);
        delay(500);
        digitalWrite(buzzer,LOW);
        relay1(1);
        Relay = 1;
        Serial.println("Mengirim pesan bot");
        if (stat == 1){
        stat = 0;
        }
    }else if(val >= 40.00 && stat == 0 && limit==3) {
    String welcome = "Kondisi tanah sudah kembali normal \U00002705";
    welcome += "\n\nSoil Moisture : ";
    welcome += val;
    welcome += "%\nRelay dimatikan ";
        digitalWrite(buzzer,HIGH);
        delay(50);
        digitalWrite(buzzer,LOW);
        delay(50);
        digitalWrite(buzzer,HIGH);
        delay(50);
        digitalWrite(buzzer,LOW);
        relay1(0);
        Relay = 0;
        Serial.println("Mengirim pesan bot");
        stat = 1;
    }
    Serial.println("Notif selesai");
//    delay(100);
    limit++;
    Serial.println(limit);
    if(limit==100){
    post();//upload data to raspberry only happen once in 4 loop
    limit=0;
    }
}';
           default:
                response()->json(['message' => 'Tipe perangkat tidak valid'], 500);
        }

        $zip = new \ZipArchive();
        $zipFile = substr($filename, 0, strrpos($filename, '.')).'.zip';
        // Initializing PHP class
        $zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach($codes as $key => $code)
        {
            $filepath = "arduino/".$key;

            $file = fopen($filepath, "w+");

            fwrite($file, $code);

            fclose($file);
            // Adding file: second parameter is what will the path inside of the archive
            // So it will create another folder called "storage/" inside ZIP, and put the file there.
            $zip->addFile($filepath);
        }

        $zip->close();
        return response()->download($zipFile)->deleteFileAfterSend();
        // return Response::download($filepath, $filename);

    }

    public function read(Request $request, $userId, $deviceType, $deviceId)
    {
        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();

        switch ($deviceType) {
            case 'lamp':
                $houseDocument = $firestore->collection('users')->document($userId)->collection('house')->document($request['house_id']);
                $collection = $houseDocument->collection('lamp');
                break;
            case 'house':
                $collection = $firestore->collection('users')->document($userId)->collection('house');
                break;
            default:
                $collection = $firestore->collection('users')->document($userId)->collection('device');
                break;
        }

        $document = $collection->document($deviceId);
        $snapshot = $document->snapshot();

        $endDate = strtotime($request['endDate']."23:59");
        $startDate = strtotime($request['startDate']);

        if ($snapshot->exists()) {
            $data = $snapshot->data();

            $collection = $document->collection('sensor');
            $allSize = $collection->documents()->size();

            $filter = $collection->where('unix_time', '>=', $startDate)->orderBy('unix_time', 'desc')->where('unix_time', '<=', $endDate);
            $size = $filter->documents()->size();
            $query = $filter->limit(!empty($request['limit']) ? $request['limit'] : $allSize)->offset(!empty($request['offset']) ? $request['offset'] : 0);
            $documents = $query->documents();

            //Count and Array Data
            $documentArray = [];

            foreach($documents as $document)
            {
                if($document->exists()){
                    $documentArray[] = $document->data();
                }
                else {
                    return response()->json(['message' => 'Tidak ditemukan!'], 200);
                }
            }
            $data['sensor'] = $documentArray;

            foreach($documentArray as $sensor) {
                if(!empty($sensor) && !empty($sensor['tanggal']))
                {
                    $sensor['tanggal'] = date('m/d/Y', strtotime($sensor['tanggal']));
                    if(!empty($sensor['timestamp']))
                    {
                        $sensor['timestamp'] = $sensor['timestamp']->formatAsString();
                    }
                    // $sensor['timestamp'] = $snapshot->createTime()->fom;
                    ksort($sensor);
                    $dataArray[] = $sensor;
                }
            }
            if(!empty($dataArray))
            {
                $data['sensor'] = $dataArray;
                $tableArray = [
                    "total" => $size,
                    "totalNotFiltered" => $size,
                    "rows" => $dataArray
                ];
                header('Content-type: text/javascript');
                return response()->json($tableArray);
            }
            return response('Data empty', 404);
            // return response()->json(['message' => 'Not Found!'], 500);
        }
    }

    public function add(Request $request, $userId, $deviceType, $deviceId)
    {
        date_default_timezone_set("Asia/Bangkok");

        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();

        if(empty($request)){
            return response()->json(['message' => 'Tidak ditemukan!'], 500);
        }
        $documentId = $firestore->collection('users')->document($userId);
        switch ($deviceType) {
            case 'house':
                $collection = $documentId->collection('house');
                break;
            default:
                $collection = $documentId->collection('device');
                break;
        }
        $document = $collection->document($deviceId);

        $snapshot = $document->snapshot();

        switch ($deviceType) {
            case 'house':
                $arrayCheck = ["temp", "humid", "cahaya", "gerak"];
                break;
            case 'garden':
                $arrayCheck = ["lembap", "relay", "sm", "suhu"];
                break;
            default:
                break;
        }

        $data = $request->only($arrayCheck);
        $dataKeys = array_keys($data);

        $time = time();
        $tanggal = date('m/d/Y', $time);
        $jam = date('H:i:s', $time);

        sort($dataKeys);
        sort($arrayCheck);
        if($request->missing($arrayCheck))
        {
            return response()->json(['message' => 'Parameter tidak sesuai', 'params' => $arrayCheck], 500);
        }
        elseif($snapshot->exists())
        {
            $sensorCollection = $document->collection('sensor');
            $addData = $sensorCollection->add($data);
            $sensorId = $addData->id();
            $sensorDocument = $sensorCollection->document($sensorId);
            $sensorDocument->update([
                ['path' => 'tanggal', 'value' => $tanggal],
                ['path' => 'jam', 'value' => $jam],
                ['path' => 'timestamp', 'value' => FieldValue::serverTimestamp()],
                ['path' => 'unix_time', 'value' => time()]
            ]);

            $document->update([
                ['path' => 'last_sensor', 'value' => $data],
            ]);
            return response()->json(['message' => "Data berhasil ditambahkan, ID: ".$sensorId."."], 200);
        }
        else {
            return response()->json(['ID perangkat tidak ada'], 500);
        }
    }

    public function update(Request $request, $userId, $deviceType)
    {
        date_default_timezone_set("Asia/Bangkok");
        $deviceId = $request['deviceId'];
        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();

        $parentArray = array();
        $documentId = $firestore->collection('users')->document($userId);
        switch ($deviceType) {
            case 'lamp':
                if($request->has('houseId'))
                {
                    $houseId = $request['houseId'];
                }
                else
                {
                    return response()->json(['message' => 'ID rumah tidak ada'], 500);
                    break;
                }
                $collection = $documentId->collection('house')->document($houseId)->collection('lamp');
                $document = $collection->document($deviceId);
                break;
            case 'house':
                // return response()->json(['message' => 'House is not supposed to have control'], 500);
                $collection = $documentId->collection('house');
                $document = $collection->document($deviceId);
                $documents = $document->collection('lamp')->documents();
                foreach ($documents as $key => $lamp) {
                    if($lamp->exists()) {
                        $lampData[] = $lamp->data()['control'];
                        $lampData[$key]['timestamp'] = strtotime($lampData[$key]['timestamp']->formatAsString());
                        $lampData[$key]['id'] = $lamp->id();
                    }
                }
                return response()->json($lampData, 200);
                break;
            default:
                $collection = $documentId->collection('device');
                $document = $collection->document($deviceId);
                break;
        }
        $snapshot = $document->snapshot();
        $documentArray = $snapshot['control'];
        $documentArray['timestamp'] = date("d-m-y H:i:s", strtotime($documentArray['timestamp']->formatAsString()));
        $documentArray['id'] = $userId;
        if($snapshot['device_type'] == 'garden')
        {
            switch ($documentArray['nilai']) {
                case '0':
                    $documentArray['message'] = 'otomatis';
                    break;
                case '1':
                    $documentArray['message'] = 'terjadwal';
                    break;
                case '2':
                    $documentArray['message'] = 'aktif';
                    break;
                case '3':
                    $documentArray['message'] = 'nonaktif';
                    break;
                default:
                    return response()->json(['message' => 'Sensor tidak terdaftar'], 500);
                    break;
            }
        }
        if($deviceType == 'lamp')
        {
            switch ($documentArray['sensor']) {
                case '0':
                    $documentArray['message'] = 'aktif';
                    break;
                case '1':
                    $documentArray['message'] = 'cahaya';
                    break;
                case '2':
                    $documentArray['message'] = 'gerak';
                    break;
                default:
                    return response()->json(['message' => 'Sensor tidak terdaftar'], 500);
                    break;
            }
        }
        $documentArray['device_type'] = $deviceType;
        return response()->json($documentArray, 200);
    }

    public function control(Request $request, $userId, $deviceType, $deviceId)
    {
        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();

        switch ($deviceType) {
            case 'lamp':
                $collection = $firestore->collection('users')->document($userId)->collection('house');
                if($request->missing('houseId'))
                {
                    return response()->json(['message' => 'ID rumah tidak ada'], 500);
                }
                $document = $collection->document($request['houseId'])->collection($deviceType)->document($deviceId);
                break;
            default:
                $collection = $firestore->collection('users')->document($userId)->collection('device');
                $document = $collection->document($deviceId);
                break;
        }
        $controlData = $document->snapshot()->data()['control'];

        foreach ($controlData as $key => $value)
        {
            if($key != 'timestamp')
            {
                $controlKey[] = $key;
            }
        }

        // die(print_r($request->only($controlKey)));

        if($request->missing($controlKey))
        {
            return response()->json(['message' => 'Parameter tidak ada', 'required' => $controlKey], 500);
        }

        $timestamp = FieldValue::serverTimestamp();

        $historyProperties = [
            'control' => $request->only($controlKey),
            'timestamp' => $timestamp,
            'device_name' => $document->snapshot()['device_name'],
            'device_type' => $deviceType,
            'id' => $deviceId
        ];

        // foreach ($controlKey as $key) {
        //     $controlProperties[$key] = $request[$key];
        // }

        $controlProperties = $request->only($controlKey);
        $controlProperties['timestamp'] = $timestamp;

        $historyControl = $firestore->collection('users')->document($userId)->collection('history_control');
        $historyControl->add($historyProperties);

        $document->set(['control' => $controlProperties], ['merge' => true]);

        return response()->json(['message' => 'Kendali berhasil diperbarui', 'control' => $controlProperties, 'history' => $historyProperties], 200);

    }

    public function chart(Request $request, $userId)
    {
        date_default_timezone_set("Asia/Bangkok");

        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();

        if($request->has('deviceType'))
        {
            $deviceType = $request['deviceType'];

            switch ($deviceType) {
                case 'lamp':
                    $houseDocument = $firestore->collection('users')->document($userId)->collection('house')->document($request['house_id']);
                    $collection = $houseDocument->collection('lamp');
                    break;
                case 'house':
                    $collection = $firestore->collection('users')->document($userId)->collection('house');
                    break;
                default:
                    $collection = $firestore->collection('users')->document($userId)->collection('device');
                    $query = $collection->where('device_type', '=', $deviceType);
                    break;
            }
        }

        $documents = $collection->documents();

        if($request->has('deviceId'))
        {
            $deviceId = $request['deviceId'];
            $document = $collection->document($deviceId);
            $documents = $collection->where('device_name', '==', $document->snapshot()['device_name'])->documents();
            // die(print_r([$deviceId, $documents]));
        }
        else {
            if(!empty($query))
            {
                $documents = $query->documents();
            }
        }

        foreach($documents as $document)
        {
            // die(print_r($snapshot->data()));
            if($document->exists()) {
                $array = array();
                $sumArray = array();
                $newSumArray = array();
                $dataArray = array();
                $zeroArray = array();
                $data = $document->data();
                $dateArray = array();

                // $sensorCollection = $collection->document($document->id())->collection('sensor');
                $sensorCollection = $document->reference()->collection('sensor');
                $sensorDocuments = $sensorCollection->documents();
                foreach($sensorDocuments as $sensorDocument)
                {
                    foreach($sensorDocument->data() as $key => $value)
                    {
                        foreach($sensorDocument->data() as $key=>$data)
                        {
                            if($key == is_numeric($data))
                            {
                                $zeroArray[$key] = 0;
                            }
                        }
                    }
                    break;
                }

                switch ($request['range']) {
                    case 'day':
                        $start = strtotime('-24 hours');
                        $interval = '1 hour';
                        break;
                    case 'week':
                        $start = strtotime('-7 days');
                        $interval = '1 day';
                        break;
                    case 'month':
                        $start = strtotime('-30 days');
                        $interval = '1 day';
                        break;
                    default:
                        return response()->json(['message' => "Interval tidak ada"], 500);
                        break;
                }

                $dateInterval = DateInterval::createFromDateString($interval);
                $period = new DatePeriod(new DateTime(date("Y-m-d H:00:00", $start)), $dateInterval, now());

                foreach($period as $dt)
                {
                    $array = array();
                    // die(print_r($dt->format("m/d/Y")));
                    switch ($request['range']) {
                        case 'day':
                            $dateFormat = $dt->format('h A');
                            $filter = $sensorCollection->where('jam', '>=', $dt->format("H:i:s"))->where('jam', '<', date("H:i:s", strtotime($dt->format("H:i:s")." +1 hour")))->where('tanggal', '==', $dt->format("m/d/Y"));
                            break;
                        default:
                            $dateFormat = $dt->format('m/d');
                            $filter = $sensorCollection->where('tanggal', '==', $dt->format("m/d/Y"));
                            break;
                    }
                    $sensorDocuments = $filter->documents();
                    $size = $sensorDocuments->size();

                    foreach($sensorDocuments as $sensor)
                    {
                        if($sensor->exists()){
                            foreach($sensor->data() as $key=>$data)
                            {
                                if($key == is_numeric($data))
                                {
                                    $dataArray[$key] = $data;
                                }
                            }
                            // echo($dataArray);
                            $array[] = $dataArray;
                        }
                    }

                    foreach ($array as $key=>$subArray) {
                        foreach ($subArray as $id=>$value) {
                            array_key_exists($id, $sumArray) ? $sumArray[$id] += round($value/$size) : $sumArray[$id] = round($value/$size);
                        }
                    }

                    $sensorData = $size > 0 ? $sumArray : $zeroArray;
                    // $sensorData['date'] = $dateFormat;

                    $newSumArray['data'][] = $sensorData;
                    $newSumArray['label'] = $document['device_name'];
                    $newSumArray['borderColor'] = '#'.dechex(rand(0x000000, 0xFFFFFF));

                    $dateArray[] = $dateFormat;

                    // if(empty($zeroArray) && empty($sumArray))
                    // {
                    //     return response()->json(['message' => 'Sensor data not found'], 500);
                    // }
                }
                $allArray[] = $newSumArray;
            }

            // return response()->json(['message' => 'Device not found', 'array' => $documents], 500);
        }
        return response()->json(['labels' => $dateArray, 'datasets' => $allArray], 200);

        // return response()->json(['message' => 'System not found', 'array' => $documents], 500);
    }
}
