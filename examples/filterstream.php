<?php
require_once __DIR__ . '/vendor/autoload.php';
use ZendFirebase\Firebase;
use ZendFirebase\Config\FirebaseAuth;

$auth = new FirebaseAuth();

$auth->setBaseURI('https://zendfirebase.firebaseio.com/');
$auth->setServertoken('YdLUSTlxVOAEEuLAMpB49lAm98AMMCMMWm6y82r4');

//$auth->setBaseURI('https://breweriesandroid-557fc.firebaseio.com/');
//$auth->setServertoken('BTYdglBnqZHxPDok65sldGZW67n6RNKV2cJzXnJK');

// $test = array(
//     "Name" => "prodotto test",
//     "id" => 25,
//     "desc" => 'prodotto test 25',
//     "price" => '15.25',
//     'status' => 'active'
// );
$firebase = new Firebase($auth);

$yesterday = strtotime('2016-11-15');

$now = time();

  $opt = [];//orderBy="$value"&startAt=50
 $opt['orderBy'] ="timestamp";
 $opt['startAt'] = $yesterday;
 $opt['endAt'] =$now;
 //$opt['equalTo'] ='2214791644';
 //startAt="b"&endAt="b\uf8ff"


function test(...$params){
    // pass event to callback function
   
    print_r($params[0]);
    print_r("EVENT TYPE: " . $params[1] . PHP_EOL . PHP_EOL);
    
}

$firebase->startStream("qrcodesActivated", 'logs/', 10000, 'test', $opt);