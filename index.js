
function deleteContact(contactPersonId, custAccount){  
  
  var language = getCookie('userLanguage');
  
  if (confirm(getText(3, language, 'Bent u zeker dat u dit contact wil wissen ?'))){
    hideDiv();
    window.location.href = 'dbAction.php?action=delete&contactPersonId=' + contactPersonId + '&custAccount=' + custAccount;
  }
  
}

function edit(contactPersonId, custAccount){    
  window.location.href = 'editContact.php?action=edit&contactPersonId=' + contactPersonId + '&custAccount=' + custAccount;
}

function newContact(custAccount){    
  window.location.href = 'editContact.php?action=new&custAccount=' + custAccount;
}

function back(custAccount){
  //window.location.href = 'index.php?&custAccount=' + custAccount;
  window.history.back();
}

function onLoadSetValues(functionId, genderParameter, nativeLanguageParameter){
  functionSelect = document.getElementById('functionSelect');
  functionSelect.value = functionId;
  
  gender = document.getElementById('gender');
  gender.value = genderParameter;

  nativeLanguage = document.getElementById('nativeLanguage');
  nativeLanguage.value = nativeLanguageParameter;
  
}

function save(){   
  
  if (checksOK()){
    hideDiv();
    $('#mainForm').attr('action', 'saveContact.php');
    $('#mainForm').submit();
  }
}

function checksOK(){
  
  var ok = true;
  var language = getCookie('userLanguage');
  
  firstName = document.getElementById('firstName');
  if (ok && firstName.value == ''){  
    firstName.focus();
    alert(getText(1, language,'Vul een voornaam in !'));
    ok = false;
  }
  
  lastName = document.getElementById('lastName');
  if (ok && lastName.value == ''){  
    lastName.focus();
    alert(getText(2, language,'Vul een achternaam in !'));
    ok = false;
  }
    
//  patt = /^\+\d+$/;
//  phone = document.getElementById('phone');
//  if (ok & phone.value != '' & !patt.test(phone.value)){
//    phone.select();
//    phone.focus();
//    alert(getText(4, language, 'Geef een nummer in zoals +3293254545'));
//    ok = false;
//  }

//  cellularPhone = document.getElementById('cellularPhone');
//  if (ok & cellularPhone.value != '' & !patt.test(cellularPhone.value)){
//    cellularPhone.select();
//    cellularPhone.focus();
//    alert(getText(4, language, 'Geef een nummer in zoals +3293254545'));
//    ok = false;
//  }
  
  email = document.getElementById('email');
  if (email.value.length > 0 && !isEmail(email.value)){
    email.select();
    email.focus();
    alert(getText(5, language, 'Vul een geldig e-mailadres in'));
    ok = false;
  }
  
//  leafSelect        = document.getElementById('leafSelect');
//  leafSelectedValue = leafSelect.options[leafSelect.selectedIndex].value;  
//  if (ok && leafSelectedValue == ''){  
//    leafSelect.focus();
//    alert(getText(6, language,'Maak een keuze'));
//    ok = false;
//  }
  
  return ok;
}

function hideDiv(){
  mainDivObj = document.getElementById('mainDiv');
  mainDivObj.style.visibility = 'hidden';  
  
  pleaseWaitDivObj = document.getElementById('pleaseWaitDiv');
  pleaseWaitDivObj.style.visibility = 'visible';  
  pleaseWaitDivObj.style.left = '50px';
  pleaseWaitDivObj.style.top  = '50px';
}

function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}