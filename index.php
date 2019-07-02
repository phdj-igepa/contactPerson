<?php


// Author : PhDJ

// http://intralinux:81/contactPerson/index.php?custAccount=99C08015

require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/utilities.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/autoload.php');
require_once('determineEnvironment.php');

require_once('multiLanguage.php');

//isUserAuthenticated2page();

$_SESSION['mailErrorTo'] = 'pdejaeger@igepa.be';
//set_error_handler('userErrorHandler');

$language = getLanguage();

$custAccount = getVariable('custAccount', '$_GET');
$hash        = getVariable('hash'       , '$_GET');

$addToDay = 'Y';
if (! hashDecryptOK($custAccount, $hash, $addToDay)) {
   die('Error hash');
}

$tdStyle = 'style="font-size:16pt"';

$title = '';
$includes = array('/includes/utilities.js',
                  'index.js',
                  'multiLanguage.js'
                 );
$html = getHTMLheader($title, $includes, '<link rel="stylesheet" type="text/css" href="/includes/igepa_20171001.css?V=1" />');

$html .= '<body>';
$html .= '<div id="mainDiv" name="mainDiv">';

$html .= '<table>';
$html .= '<tr>';
$html .= '<td class="normalTd" ' . $tdStyle . '>' . getTxt(20, $language, 'Klant') .  '</td>';
$custTable = new custtable($custAccount);
$html .= '<td class="normalTd" ' . $tdStyle . '>' . $custAccount . ' ' . $custTable->NAME() . '</td>';
$html .= '</tr>';
$html .= '</table>';        


$html .= '<table>';
$html .= '<tr>';
$html .= '<td class="normalTd"><input type="image" src="/img/round_plus.png" onclick="newContact(' . "'" . $custAccount . "'" . ');"  /></td>';
$html .= '<td class="normalTd" ' . $tdStyle . '>' . getTxt(18, $language, 'Contact toevoegen') . '</td>';
$html .= '</tr>';
$html .= '</table>';        
    
$firstTime = true;
$dataFound = false;

$extraClause = "left join smmFunctionGroup on contactPerson.function_ = smmFunctionGroup.functionId where custAccount = '" . $custAccount . "'";
$contactPerson = new dbMsSQLAX('R', '*', $environment, 'contactPerson', '', $extraClause);
$html .= '<table>';
while ($contactPerson->fetchRow()){

  $dataFound = true;
  if ($firstTime){
    $html .= '<tr>';
    $html .= '<th ' . $tdStyle . '>' . getTxt(1, $language, 'Contactnummer') . '</th>';
    $html .= '<th ' . $tdStyle . '>' . getTxt(2, $language, 'Naam') . '</th>';
    $html .= '<th ' . $tdStyle . '>' . getTxt(13, $language, 'Geslacht') . '</th>';
    $html .= '<th ' . $tdStyle . '>' . getTxt(6, $language, 'Functie') . '</th>';
    $html .= '<th ' . $tdStyle . '>' . getTxt(17, $language, 'Taal') . '</th>';
    $html .= '<th ' . $tdStyle . '>' . getTxt(21, $language, 'Telefoon') . '</th>';
    $html .= '<th ' . $tdStyle . '>' . getTxt(7, $language, 'Mobiel') . '</th>';
    $html .= '<th ' . $tdStyle . '>' . getTxt(8, $language, 'E-mail') . '</th>';

    $html .= '<th ' . $tdStyle . '>' . getTxt(3, $language, 'Wijzigen') . '</th>';
    $html .= '<th ' . $tdStyle . '>' . getTxt(4, $language, 'Wissen') . '</th>';
    $html .= '</tr>';
    $firstTime = false;
  }
  $html .= '<tr>';
  $contactPersonID = $contactPerson->result('contactPersonId');
  $html .= '<td class="tdCenter" ' . $tdStyle . '>' . $contactPersonID . '</td>';
  $html .= '<td ' . $tdStyle . '>' . $contactPerson->result('name') . '</td>';
  $gender = $contactPerson->result('gender');
  switch ($gender) {
    case 0:
      $genderText = getTxt(14, $language, 'Onbekend');
      break;
    case 1:
      $genderText = getTxt(15, $language, 'Mannelijk');
      break;
    case 2:
      $genderText = getTxt(16, $language, 'Vrouw');
      break;
    default:
    case 0:
      $genderText = getTxt(14, $language, 'Onbekend');
      break;
  }
  $html .= '<td ' . $tdStyle . '>' . $genderText . '</td>';
  $html .= '<td ' . $tdStyle . '>' . $contactPerson->result('description') . '</td>'; // functieomschrijving 
  $html .= '<td ' . $tdStyle . '>' . $contactPerson->result('nativeLanguage') . '</td>';
  $html .= '<td ' . $tdStyle . '>' . $contactPerson->result('phone') . '</td>';
  $html .= '<td ' . $tdStyle . '>' . $contactPerson->result('cellularPhone') . '</td>';
  $html .= '<td ' . $tdStyle . '>' . $contactPerson->result('email') . '</td>';
  $html .= '<td class="tdCenter"><input type="image" src="/img/edit.png" onclick="edit(' . "'" . $contactPersonID . "','" . $custAccount . "'" . ');" style="height:55px;width:45px"></td>';
  $html .= '<td class="tdCenter"><input type="image" src="/img/delete.png" onclick="deleteContact(' . "'" . $contactPersonID . "','" . $custAccount . "'" . ');" style="height:55px;width:45px"></td>';
  $html .= '</tr>';
}

if(!$dataFound){
  $html .= '<tr>';
  $html .= '<td ' . $tdStyle . '>' . getTxt(19, $language, 'Geen contacten gevonden') . '</td>';
  $html .= '</tr>';
}
$html .= '</table>';
$html .= '</div>';
$html .= '<div style="visibility:hidden;position:absolute" id="pleaseWaitDiv" name="pleaseWaitDiv">' .        
         '<img src="/img/loader2.gif" width="100px" heigth="100px" />&nbsp;' .
         '<span style="color: #008060;font-size:48px">' . getTxt(5, $language, 'Even geduld a.u.b.') . '</span>' .         
         '</div>';
$html .= '</body>';
$html .= '<html>';

echo $html;

?>