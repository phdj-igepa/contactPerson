<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/utilities.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/autoload.php');

//isUserAuthenticated2page();
//require_once('multiLanguage.php');

$_SESSION['mailErrorTo'] = 'pdejaeger@igepa.be';
//set_error_handler('userErrorHandler');

$action          = getVariable('action',          '$_GET');
$contactPersonId = getVariable('contactPersonId', '$_GET');
$custAccount     = getVariable('custAccount',     '$_GET');

switch ($action) {
  case 'delete':
    delete($contactPersonId,
           $custAccount);
    break;
  default:
    break;
}

function delete($contactPersonId,
                $custAccount){
    
  $environment = 'AX2009_LIVE';
  $contactPersonWebservice = new contactPersonWebservice($environment);
  $contactPersonWebservice->delete($contactPersonId);
  
  $contactPerson = new ContactPerson($contactPersonId);
  $txt = 'Contact ' . $contactPersonId . ' ' . $contactPerson->NAME(). ', customer ' . $custAccount . ' deleted';
  $efficyUser = trim(getVariable('efficyUser', '$_COOKIE'));
  if (strlen($efficyUser) > 0){
    $txt .= ' by ' . $efficyUser;
  }
  writeToLogfile($txt, 'contactPerson');
  
  $addToDay = 'Y';
  $hash = hashEncrypt($custAccount, $addToDay);
  echo "<script>window.location = 'index.php?custAccount=" . $custAccount . '&hash=' . $hash . "';</script>";
}

?>