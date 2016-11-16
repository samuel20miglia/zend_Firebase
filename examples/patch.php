<?php
require_once __DIR__ . '/vendor/autoload.php';
use ZendFirebase\Firebase;
use ZendFirebase\Config\FirebaseAuth;

$auth = new FirebaseAuth();

$auth->setBaseURI(/* complete with your firebase url */);
$auth->setServertoken(/* complete with your firebase token */);

$path = ''; // path that you want patch

$newData = array(
    "Name" => "prodotto test",
    "id" => 25,
    "desc" => 'prodotto test 25',
    "price" => '15.25',
    'status' => 'active'
);
$firebase = new Firebase($auth);

$firebase->setTimeout(10);
$firebase->patch($path, $newData);

print_r($firebase->getFirebaseData());

echo $firebase->getOperation();
echo $firebase->getStatus();
