<?php
require_once __DIR__ . '/vendor/autoload.php';
use ZendFirebase\Firebase;
use ZendFirebase\Config\FirebaseAuth;

$auth = new FirebaseAuth();

//$auth->setBaseURI('https://zendfirebase.firebaseio.com/');
//$auth->setServertoken('YdLUSTlxVOAEEuLAMpB49lAm98AMMCMMWm6y82r4');

//$auth->setBaseURI('https://breweriesandroid-557fc.firebaseio.com/');
//$auth->setServertoken('BTYdglBnqZHxPDok65sldGZW67n6RNKV2cJzXnJK');

 $test = array(
     "Name" => "prodotto test",
     "id" => 25,
     "desc" => 'prodotto test 25',
    "price" => '15.25',
    'status' => 'active'
 );
$firebase = new Firebase($auth);


$firebase->setTimeout(10);
 $firebase->delete('test/-KWYARI4DZca5D8tUor7');
//
//  $opt = [];//orderBy="$value"&startAt=50
//  $opt['orderBy'] ="$value";
//  $opt['startAt'] ='"gYylHdiVFBbbR9fKVxENYbsTbmh1"';

// $firebase->get('qrcodesControls', $opt);
// // $firebase->delete('products3');

 print_r($firebase->getFirebaseData());

echo $firebase->getOperation();
echo $firebase->getStatus();
