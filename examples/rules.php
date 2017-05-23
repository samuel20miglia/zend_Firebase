<?php
require_once __DIR__ . '/vendor/autoload.php';
use Zend\Firebase\Firebase;
use Zend\Firebase\Authentication\FirebaseAuth;

$auth = new FirebaseAuth();

$auth->setBaseURI(/* complete with your firebase url */);
$auth->setServertoken(/* complete with your firebase token */);

$path = '.settings/rules'; // path that you want patch

$firebase = new Firebase($auth);


$opt = [];//

$firebase->getRules($path, $opt);

print_r($firebase->getFirebaseData());