<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/utilities.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/autoload.php');
require_once('determineEnvironment.php');

//isUserAuthenticated2page();
//require_once('multiLanguage.php');

$_SESSION['mailErrorTo'] = 'pdejaeger@igepa.be';
//set_error_handler('userErrorHandler');

//error_log('OK',1,'pdejaeger@igepa.be');

$contactPersonId = getVariable('contactPersonId', '$_POST');
$custAccount     = getVariable('custAccount'    , '$_POST');
$action          = getVariable('action'         , '$_POST');

$firstName       = getVariable('firstName'      , '$_POST');
$lastName        = getVariable('lastName'       , '$_POST');
$initials        = getVariable('initials'       , '$_POST');
$function        = getVariable('functionSelect' , '$_POST');
$nativeLanguage  = getVariable('nativeLanguage' , '$_POST');
$phone           = getVariable('phone'          , '$_POST');
$cellularPhone   = getVariable('cellularPhone'  , '$_POST');
$email           = getVariable('email'          , '$_POST');
$gender          = getVariable('gender'         , '$_POST');
$leaf            = getVariable('leafSelect'     , '$_POST');

//echo 'custAccount=' . $custAccount;
//echo 'email=' . $email;
//echo 'leaf = '. $leaf;
//exit;

$contactPersonWebservice = new contactPersonWebservice($environment);

$txt = $contactPersonId . ', ' .
       $firstName . ', ' .
       $initials . ', ' .
       $lastName . ', ' .
       $function . ', ' .
       $phone . ', ' .
       $cellularPhone . ', ' .
       $email . ', ' .
       $gender . ', ' .
       $nativeLanguage . ', ' .
       $leaf;
$efficyUser = trim(getVariable('efficyUser', '$_COOKIE'));
if (strlen($efficyUser) > 0){
  $txt .= ' by ' . $efficyUser;
}

if ($action == 'edit'){
  $contactPersonWebservice->update($contactPersonId,
                                   $firstName,
                                   $lastName,
                                   $initials,
                                   $function,
                                   $phone,
                                   $cellularPhone,
                                   $email,
                                   $gender,
                                   $nativeLanguage,
                                   $leaf);
  $txt = 'ContactAFTER ' . $txt;
  writeToLogfile($txt, 'contactPerson');                                   
}  
if ($action == 'new'){
  $contactPersonWebservice->create($custAccount,
                                   $firstName,
                                   $lastName,
                                   $initials,
                                   $function,
                                   $phone,
                                   $cellularPhone,
                                   $email,
                                   $gender,
                                   $nativeLanguage,
                                   $leaf);
  $txt = 'ContactNEW ' . $txt;  
  writeToLogfile($txt, 'contactPerson');  
}  

$addToDay = 'Y';

$hash = hashEncrypt($custAccount, $addToDay);

echo "<script>window.location = 'index.php?custAccount=" . $custAccount . '&hash=' . $hash . "';</script>";

?>