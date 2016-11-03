# PHP7 Firebase REST and STREAM Client

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Samuel18/zend_Firebase/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Samuel18/zend_Firebase/?branch=master)
[![Travis CI Build Status](https://travis-ci.org/Samuel18/zend_Firebase.svg?branch=master)](https://travis-ci.org/Samuel18/zend_Firebase)

[![PHP 7 ready](http://php7ready.timesplinter.ch/Samuel18/zend_Firebase/badge.svg)](https://travis-ci.org/Samuel18/zend_Firebase)
[![Total Downloads](https://poser.pugx.org/zend_firebase/zend_firebase/downloads)](https://packagist.org/packages/zend_firebase/zend_firebase)
[![Latest Stable Version](https://poser.pugx.org/zend_firebase/zend_firebase/v/stable)](https://packagist.org/packages/zend_firebase/zend_firebase)
[![License](https://poser.pugx.org/zend_firebase/zend_firebase/license)](https://packagist.org/packages/zend_firebase/zend_firebase)

Based on the [Firebase REST API](https://firebase.google.com/docs/reference/rest/database/).

Available on [Packagist](https://packagist.org/packages/zend_firebase/zend_firebase).

### Adding Firebase PHP to your project using Composer

```bash
cd <your_project>

composer require zend_firebase/zend_firebase dev-master
```

More info about Composer at [getcomposer.org](http://getcomposer.org).

### Example of Usage
```php
use ZendFirebase\Firebase, ZendFirebase\Config\FirebaseAuth;

$auth = new FirebaseAuth();

$auth->setBaseURI('https://your_url_from_firebase/');
$auth->setServertoken('your_firebase_token');

/* ---  EXAMPLE OF DATA TO POST REMEMBER ALL DATA MUST BE ARRAY --- */
$test = array(
    "name" => "TEST",
    "id" => 5245,
    "text" => 'ciao TEST 5245',
    'status' => 'sended'
);

/* --- CREATE NEW OBJECT AND PASS CREDENTIAL --- */
$firebase = new Firebase($auth);


/* --- CHOOCE THE OPERATION (SAME NAME OF FIREBASE DOCS)  --- */
$firebase->post('usersMessages', $test);
```
### Response Usage
```php

/* to create a responce */
$firebase->makeResponce();

/* --- FIREBASE DATA FROM REALTIME DB IS AN ARRAY  --- */
$firebase->getFirebaseData(); <- array
echo $firebase->getOperation(); <- type of current operation for example: GET or POST etc...
echo $firebase->getStatus(); <- status of request for example: 200 or 400 or 500
```

### Supported Commands
```php

/* --- storing data --- */
$firebase->post('usersMessages', $test,$options);
/* --- override data --- */
$firebase->put('usersMessages', $test,$options);
/* --- update data --- */
$firebase->patch('usersMessages', $test,$options);
/* --- retrieve data --- */
$firebase->get('usersMessages',$options);
/* --- delete data --- */
$firebase->delete('usersMessages',$options);
```
<hr/>

### Rest Stream API
```php

use ZendFirebase\Firebase, ZendFirebase\Config\FirebaseAuth;

$auth = new FirebaseAuth();

$auth->setBaseURI('https://your_url_from_firebase/');
$auth->setServertoken('your_firebase_token');


/* --- CREATE NEW OBJECT AND PASS CREDENTIAL --- */
$firebase = new Firebase($auth);

/* --- SET PATH, NAME OF FOLDER WHERE STORE LOGS, AND MILLISECONDS OF DELAY BETWEEN NEW REQUEST */
$firebase->startStream('products', 'logs/',5000);
```
this method start listener and write log file of changes

<hr/>
### Unit Tests
All the unit tests are found in the "/tests" directory.
Due to the usage of an interface, the tests must run in isolation.

Project Configuration it's just setted for doing all tests with the simple command

```bash
cd <your_project>

phpunit
```




#### BSD 3-Clause License

[READ BSD LICENSE](LICENSE)
