<?php
use ZendFirebase\Firebase\FirebaseInit, ZendFirebase\Config\AuthSetup;
require_once __DIR__ . '/vendor/autoload.php';
require 'src/Config/AuthSetup.php';
require 'src/FirebaseInit.php';

$auth = new AuthSetup();

$auth->setBaseUri('https://breweriesandroid-557fc.firebaseio.com/');
$auth->setServerToken('BTYdglBnqZHxPDok65sldGZW67n6RNKV2cJzXnJK');

var_dump($auth);
$firebase = new FirebaseInit($auth);