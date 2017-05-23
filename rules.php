<?php
require_once 'vendor/autoload.php';

use Zend\Firebase\Firebase;
use Zend\Firebase\Authentication\FirebaseAuth;

$auth = new FirebaseAuth();

$auth->setBaseURI('https://zendfirebase.firebaseio.com/');
$auth->setServertoken('YdLUSTlxVOAEEuLAMpB49lAm98AMMCMMWm6y82r4');

$path = '.settings/rules'; // path that you want patch

$firebase = new Firebase($auth);


$opt = [];//

$firebase->getRules($path, $opt);

print_r($firebase->getFirebaseData());