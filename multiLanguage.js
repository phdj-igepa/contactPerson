
var txt = new Array(); 

txt[1]  = '---Vul een voornaam in !---Introduisez le prénom !';
txt[2]  = '---Vul een achternaam in !--- Introduisez le nom de famille!';
txt[3]  = '---Bent u zeker dat u dit contact wil wissen ?---Etes-vous sûr de vouloir supprimer ce contact ?';
txt[4]  = '---Geef een nummer in zoals +3293254545---Introduisez le numéro, exemple: +3293254545';
txt[5]  = '---Vul een geldig e-mailadres in---Adresse mail non valide';
txt[6]  = '---Maak een keuze, wil klant LEAF ontvangen ?------Faites un choix, le client souhaite-t-il recevoir notre LEAF ?'

function getText(number, language, comment){

  var temp = new Array();
  var numberLanguage;

  temp = txt[number].split('---');
  
  numberLanguage = 1;
  switch(language){
    case 'N':
      numberLanguage = 1;
      break    
    case 'F':
      numberLanguage = 2;
      break
  }
  
  return temp[numberLanguage];  
  
}