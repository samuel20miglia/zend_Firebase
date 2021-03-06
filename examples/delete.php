<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Zend\Firebase\Firebase;
use Zend\Firebase\Authentication\FirebaseAuth;

$auth = new FirebaseAuth();

$auth->setBaseURI(/* complete with your firebase url */);
$auth->setServertoken(/* complete with your firebase token */);

$path = ''; // path that you want delete

$firebase = new Firebase($auth);

$firebase->setTimeout(10);
$firebase->delete($path);

print_r($firebase->getFirebaseData());

echo $firebase->getOperation();
echo $firebase->getStatus();
