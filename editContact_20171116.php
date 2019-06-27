<?php

// http://intralinux:81/contactPerson/editContact.php?contactPersonId=010706_002&action=edit&custAccount=99C04645

require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/utilities.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/autoload.php');
require_once('determineEnvironment.php');

//isUserAuthenticated2page();
require_once('multiLanguage.php');

$language = getLanguage();

//$_SESSION['mailErrorTo'] = 'pdejaeger@igepa.be';
//set_error_handler('userErrorHandler');

$contactPersonId = getVariable('contactPersonId', '$_GET');
$custAccount     = getVariable('custAccount'    , '$_GET');
$action          = getVariable('action'         , '$_GET');

$firstName      = '';
$lastName       = '';
$initials       = '';
$email          = '';
$phone          = '';
$cellularPhone  = '';
$function       = '';
$nativeLanguage = '';
$gender         = 0;
$pager          = 'NOLEAF';

if ($action == 'edit'){
  $whereClause = "contactPersonId = '" . $contactPersonId . "' and dataareaid = '99'";
  $contactPerson = new dbMsSQLAX('R', '*', $environment, 'contactPerson', $whereClause);
  if ($contactPerson->fetchRow()){
    $firstName      = $contactPerson->result('firstName');
    $lastName       = $contactPerson->result('lastName');
    $initials       = $contactPerson->result('initials');
    $phone          = $contactPerson->result('phone');
    $cellularPhone  = $contactPerson->result('cellularPhone');
    $email          = $contactPerson->result('email');
    $function       = $contactPerson->result('function_');
    $nativeLanguage = $contactPerson->result('nativeLanguage');
    $gender         = $contactPerson->result('gender');
    $pager          = trim($contactPerson->result('pager'));
    
    $txt = 'ContactBEFORE ' . 
           $contactPersonId . ', ' .
           $firstName . ', ' .
           $initials . ', ' .
           $lastName . ', ' .
           $function . ', ' .
           $phone . ', ' .
           $cellularPhone . ', ' .
           $email . ', ' .
           $gender . ', ' .
           $nativeLanguage . ', ' .
           $pager;
    
    $efficyUser = trim(getVariable('efficyUser', '$_COOKIE'));
    if (strlen($efficyUser) > 0){
      $txt .= ' by ' . $efficyUser;
    }    
     writeToLogfile($txt, 'contactPerson');    
  }
}  

switch ($gender) {
  case 0:
    $gender = 'Unknown';
    break;
  case 1:
    $gender = 'Male';
    break;
  case 2:
    $gender = 'Female';
    break;
  default:
    break;
}
$tdStyle   = 'style="font-size:16pt"';
$inputSize = 'size="47"';

$title = '';
$includes = array('/includes/jQuery/jquery-1.8.2.min.js',
                  '/includes/utilities.js',
                  'index.js',
                  'multiLanguage.js'
                 );

$onLoadSetFunction = ' onload="onLoadSetValues(' . "'" . $function . "','" . $gender . "','" . $nativeLanguage . "')" . '"';
$html = getHTMLheader($title, $includes, '<link rel="stylesheet" type="text/css" href="/includes/igepa.css" />', $onLoadSetFunction);

$html .= '<div id="mainDiv" name="mainDiv">';
$html .= '<form id="mainForm" name="mainForm" method="post" action="">';
$html .= '<table>';

$html .= '<tr>';
$html .= '<th ' . $tdStyle . '>' . getTxt(1, $language, 'Contactnummer') . '</th>';
$html .= '<td ' . $tdStyle . '>' . $contactPersonId . '</th>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<th ' . $tdStyle . '>' . getTxt(9, $language, 'Voornaam') . '</th>';
$html .= '<td ' . $tdStyle . '><input type="text" ' . $tdStyle . ' id="firstName" name="firstName" value="' . $firstName . '" ' . $inputSize . ' /></th>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<th ' . $tdStyle . '>' . getTxt(10, $language, 'Achternaam') . '</th>';
$html .= '<td ' . $tdStyle . '><input type="text" ' . $tdStyle . ' id="lastName" name="lastName" value="' . $lastName . '" ' . $inputSize . ' /></th>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<th ' . $tdStyle . '>' . getTxt(27, $language, 'Initialen') . '</th>';
$html .= '<td ' . $tdStyle . '><input type="text" ' . $tdStyle . ' id="initials" name="initials" value="' . $initials . '" ' . $inputSize . ' /></th>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<th ' . $tdStyle . '>' . getTxt(13, $language, 'Geslacht') . '</th>';
$html .= '<td>';
$html .= '<select id="gender" name="gender"' . $tdStyle . '>';
$html .= '<option value="Unknown">' . getTxt(14, $language, 'Onbekend') . '</option>';
$html .= '<option value="Male">'    . getTxt(15, $language, 'Mannelijk') . '</option>';
$html .= '<option value="Female">'  . getTxt(16, $language, 'Vrouw') . '</option>';
$html .= '</select>';
$html .= '</td>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<th ' . $tdStyle . '>' . getTxt(17, $language, 'Taal') . '</th>';
$html .= '<td>';
$template = '<option value="%FIELD1%">%FIELD2%</option>';
$sql = 'select languageId, languageId from ax2009_live.dbo.languagetable where labelfile = 1 order by languagetable.languageId';
$html .= '<select id="nativeLanguage" name="nativeLanguage" ' . $tdStyle . '>';
$html .= getDataOnceADAy($sql, '/Data/WebServerIncludeFiles/languageTable', $template, 'AX');
$html .= '</select>';
$html .= '</td>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<th ' . $tdStyle . '>' . getTxt(6, $language, 'Functie') . '</th>';
$html .= '<td>';
$template = '<option value="%FIELD1%">%FIELD2%</option>';
$sql = 'select functionId, description from ax2009_live.dbo.smmFunctionGroup order by functionId';
$html .= '<select id="functionSelect" name="functionSelect" ' . $tdStyle . '>';
$html .= getDataOnceADAy($sql, '/Data/WebServerIncludeFiles/smmFunctionGroup', $template, 'AX');
$html .= '</select>';
$html .= '</td>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<th ' . $tdStyle . '>' . getTxt(21, $language, 'Telefoon') . '</th>';
$html .= '<td ' . $tdStyle . '><input type="text" ' . $tdStyle . 'id="phone" name="phone" value="' . $phone . '" ' . $inputSize . ' /></td>';
$html .= '<td ' . $tdStyle . ' class="normalTd">' . getTxt(22, $language, 'Bijvoorbeeld : +329243535') . '</td>';
$html .= '</tr>';


$html .= '<tr>';
$html .= '<th ' . $tdStyle . '>' . getTxt(7, $language, 'Mobiel') . '</th>';
$html .= '<td ' . $tdStyle . '><input type="text" ' . $tdStyle . ' id="cellularPhone" name="cellularPhone" value="' . $cellularPhone . '" ' . $inputSize . ' /></td>';
$html .= '<td ' . $tdStyle . ' class="normalTd">' . getTxt(23, $language, 'Bijvoorbeeld : +32496123456') . '</td>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<th ' . $tdStyle . '>' . getTxt(8, $language, 'E-mail') . '</th>';
$html .= '<td ' . $tdStyle . '><input type="email" ' . $tdStyle . ' id="email" name="email" value="' . $email . '" ' . $inputSize . ' /></td>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<th ' . $tdStyle . '>' . getTxt(24, $language, 'LEAF ontvangen ?') . '</th>';
$html .= '<td ' . $tdStyle . '>';
$html .= '<select id="leafSelect" name="leafSelect" ' . $tdStyle . '>';

//// LEAF onbeslist
//$selected = '';
//if (strlen(trim($pager)) == 0){
//  $selected = 'selected="selected" ';
//}
//$html .= '<option value="" ' . $selected . '></option>';

// standaard geen LEAF op vraag van STVA
if (strlen(trim($pager)) == 0){
  $pager = 'NOLEAF';
}

// LEAF yes
$selected = '';
if (strtoupper($pager) == 'LEAF'){
  $selected = 'selected="selected" ';
}
$html .= '<option value="yes" ' . $selected . '>' . getTxt(25, $language, 'Ja') . '</option>';

// NOLEAF
$selected = '';
if (strtoupper($pager) == 'NOLEAF'){
  $selected = 'selected="selected" ';
}
$html .= '<option value="no" ' . $selected . '>'  . getTxt(26, $language, 'Nee') . '</option>';
$html .= '</select>';
$html .= '</td>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<td>';
$html .= '<input type="button" style="height:55px;width:200px;font-size:16px;" id="saveButton" name="saveButton" onclick="save();" value="' . getTxt(11, $language, 'Bewaren') . '">';
$html .= '</td>';
$html .= '<td style="text-align:right">';
$html .= '<input type="button" style="height:55px;width:200px;font-size:16px;" id="backButton" name="backButton" onclick="back(' . "'" . $custAccount . "'" . ');" value="' . getTxt(12, $language, 'Annuleren') . '">';
$html .= '</td>';
$html .= '</tr>';

$html .= '</table>';
$html .= '<input type="hidden" id="custAccount" name="custAccount" value="' . $custAccount . '" />';
$html .= '<input type="hidden" id="contactPersonId" name="contactPersonId" value="' . $contactPersonId . '" />';
$html .= '<input type="hidden" id="action" name="action" value="' . $action . '" />';
$html .= '</form>';

$html .= '</body>';
$html .= '</div>';

$html .= '<div style="visibility:hidden;position:absolute" id="pleaseWaitDiv" name="pleaseWaitDiv">' .        
         '<img src="/img/loader2.gif" width="100px" heigth="100px" />&nbsp;' .
         '<span style="color: #008060;font-size:48px">' . getTxt(5, $language, 'Even geduld a.u.b.') . '</span>' .         
         '</div>';

$html .= '<html>';

echo $html;

?>
