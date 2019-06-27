<?php

	function getTxt($number, $language, $comment){
	
		include('multiLanguageArray.php');
	
	  $getText = '!!! NO TEXT !!!';
	  
	  if (isset($txt[$number])) {
	
	    $a = explode('---',$txt[$number]) ;
	
	    switch ($language) {
	      case 'N':{
	        $getText = $a[1];
	        break;
	      }
	      case 'F':{
	        $getText = $a[2];
	        break;
	      }
	      case 'D':{
	        $getText = $a[3];
	        break;
	      }
	      case 'E':{
	        $getText = $a[4];
	        break;
	      }	      
	    }
	  }
	
	  return($getText);
	
	}
	
	//echo getTxt(1,'F','Test');

?>