<?php
require_once __DIR__ . '/vendor/autoload.php';
use ZendFirebase\Firebase;
use ZendFirebase\Config\FirebaseAuth;

$auth = new FirebaseAuth();

$auth->setBaseURI(/* complete with your firebase url */);
$auth->setServertoken(/* complete with your firebase token */);


$firebase = new Firebase($auth);

$yesterday = strtotime(date('Y-m-d'));

$now = time();

 $options = [];
 $options['orderBy'] ="timestamp";
 $options['startAt'] = $yesterday;
 $options['endAt'] = $now;
 //$opt['equalTo'] ='string that want to be equals';

function test(...$params){
    // pass event to callback function

    print_r($params[0]);
    print_r("EVENT TYPE: " . $params[1] . PHP_EOL . PHP_EOL);

}

$firebase->startStream("qrcodesActivated", 'logs/', 10000, 'test', $options);