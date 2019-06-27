<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/utilities.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/autoload.php');
require_once('determineEnvironment.php');

// http://intralinux:81/contactPerson/indexTest.php?custAccount=99C08015

//isUserAuthenticated2page();
//require_once('multiLanguage.php');

$_SESSION['mailErrorTo'] = 'pdejaeger@igepa.be';
//set_error_handler('userErrorHandler');

$custAccount = getVariable('custAccount', '$_GET');
$addToDay = 'Y';

$hash = hashEncrypt($custAccount, $addToDay);

$url = 'index.php?custAccount=' . $custAccount . '&hash=' . $hash;

header( "Location: $url" );

?>