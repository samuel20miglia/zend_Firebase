# PHP7 Firebase REST and STREAM Client

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Samuel18/zend_Firebase/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Samuel18/zend_Firebase/?branch=master)
[![Travis CI Build Status](https://travis-ci.org/samuel20miglia/zend_Firebase.svg?branch=master)](https://travis-ci.org/Samuel18/zend_Firebase)
[![codecov](https://codecov.io/gh/samuel20miglia/zend_Firebase/branch/master/graph/badge.svg)](https://codecov.io/gh/samuel20miglia/zend_Firebase)

[![PHP 7 ready](http://php7ready.timesplinter.ch/samuel20miglia/zend_Firebase/badge.svg)](https://travis-ci.org/Samuel18/zend_Firebase)
[![Total Downloads](https://poser.pugx.org/zend_firebase/zend_firebase/downloads)](https://packagist.org/packages/zend_firebase/zend_firebase)
[![Latest Stable Version](https://poser.pugx.org/zend_firebase/zend_firebase/v/stable)](https://packagist.org/packages/zend_firebase/zend_firebase)
[![License](https://poser.pugx.org/zend_firebase/zend_firebase/license)](https://packagist.org/packages/zend_firebase/zend_firebase)

Based on the [Firebase REST API](https://firebase.google.com/docs/reference/rest/database/).

Available on [Packagist](https://packagist.org/packages/zend_firebase/zend_firebase).

###Prerequisites
- PHP >= 7.0
- Firebase Active Account
- Composer (recommended, not required)

### Adding Firebase PHP to your project using Composer

```bash
cd <your_project>

composer require zend_firebase/zend_firebase [![Latest Stable Version](https://poser.pugx.org/zend_firebase/zend_firebase/v/stable)](https://packagist.org/packages/zend_firebase/zend_firebase)
```

More info about Composer at [getcomposer.org](http://getcomposer.org).

### Simple Example of Usage
```php
use Zend\Firebase\Firebase, Zend\Firebase\Authentication\FirebaseAuth;

$auth = new FirebaseAuth();

$auth->setBaseURI('https://your_url_from_firebase/');
$auth->setServertoken('your_firebase_token');

/* ---  EXAMPLE OF DATA TO POST REMEMBER ALL DATA MUST BE ARRAY --- */
$test = array(
    "name" => "TEST",
    "id" => 5245,
    "text" => "hello TEST 5245",
    "status" => "sended"
);

/* --- CREATE NEW OBJECT AND PASS CREDENTIAL --- */
$firebase = new Firebase($auth);


/* --- CHOOCE THE OPERATION (SAME NAME OF FIREBASE DOCS)  --- */
$firebase->post('path', $test);
```
Inside folder "examples" you can find some another simple complete example for library usage. Go to next step!

### Response Usage
```php

/* --- FIREBASE DATA FROM REALTIME DB IS AN ARRAY  --- */
$firebase->getFirebaseData(); 	// <- array, data returning from Firebase
echo $firebase->getOperation(); // <- string, operation just made (for example: GET or POST etc...)
echo $firebase->getStatus(); 	// <- numeric, status of request (for example: 200 or 400 or 500)
```
Go to next step!

### Get Last Auto-Increment Id generate from Firebase after 'post' command
```php

/* --- GET LAST AUTO-INCREMENT ID INSERED AFTER POST COMMAND --- */
$firebase->getLastIdStored();

```
Go to next step!

<hr/>

### Supported Commands
```php

/* --- STORING DATA --- */
$firebase->post('path', $test,$options);
/* --- OVERRIDE DATA --- */
$firebase->put('path', $test,$options);
/* --- UPDATE DATA --- */
$firebase->patch('path', $test,$options);
/* --- RETRIEVE DATA --- */
$firebase->get('path',$options);
/* --- DELETE DATA --- */
$firebase->delete('path',$options);
/* --- RETRIEVE RULES --- */
$firebase->getRules('.settings/rules',$options);
```
Go to next step!

<hr/>

### Manage rules via REST

####Read

```php

require_once __DIR__ . '/vendor/autoload.php';
use Zend\Firebase\Firebase;
use Zend\Firebase\Authentication\FirebaseAuth;

$auth = new FirebaseAuth();

$auth->setBaseURI(/* complete with your firebase url */);
$auth->setServertoken(/* complete with your firebase token */);

$path = '.settings/rules'; // path of rules

$firebase = new Firebase($auth);


/* call function */
$firebase->getRules($path);

/* show rules! */
print_r($firebase->getFirebaseData());
```

####Write

```php

require_once __DIR__ . '/vendor/autoload.php';
use Zend\Firebase\Firebase;
use Zend\Firebase\Authentication\FirebaseAuth;

$auth = new FirebaseAuth();

$auth->setBaseURI(/* complete with your firebase url */);
$auth->setServertoken(/* complete with your firebase token */);

$path = '.settings/rules'; // path of rules

$firebase = new Firebase($auth);

$rules =[
     "rules" => [
         ".read" => true,
         ".write" => "!data.exists() || !newData.exists()"
         ]
 ];

/* call function to write */
$firebase->writeRules($path,$rules);

/* show result! */
print_r($firebase->getFirebaseData());
```
now you are able to manage rules. Go to next step!

<hr/>

### Rest Stream API

Create a new file your_file_name.php .

Inside this new file insert the following code :

```php

use Zend\Firebase\Firebase, Zend\Firebase\Authentication\FirebaseAuth;

$auth = new FirebaseAuth();

$auth->setBaseURI('https://your_url_from_firebase/');
$auth->setServertoken('your_firebase_token');


/* --- CREATE NEW OBJECT AND PASS CREDENTIAL --- */
$firebase = new Firebase($auth);


$options = []; // container options as type array

$callback = 'callbackFunction'; // name of callback function as type string

function callbackFunction(...$params){
    // all code needed
}

$print = true;

/* --- SET PATH,
	   NAME OF FOLDER WHERE STORE LOGS,
	   MILLISECONDS OF DELAY BETWEEN NEW REQUEST (not required, default 5000),
	   CALLBACK FUNCTION,
	   ARRAY OPTIONS (not required, default []),
	   PRINT (not required, default TRUE) --- */
$firebase->startStream('path', 'logs/', 5000, $callback, $options, $print);
```

Now for run listener open terminal and run you file with command :
```bash
php your_file_name.php
```

This method start listener and write log file of changes.

<hr/>

### PHPUnit Tests
All the unit tests are found in the "/tests" directory.
Due to the usage of an interface, the tests must run in isolation.

Project Configuration it's just setted for doing all tests with the simple command :

```bash
cd <your_project>

composer test
```

If you want to run a single test, just run :
```bash
cd <your_project>

phpunit name_and_path_of_the_file_that_you_want_to_test.php
```

#### BSD 3-Clause License

[READ BSD LICENSE](LICENSE)
