<?php

$serverName = $_SERVER['SERVER_NAME'];
$serverPort = $_SERVER['SERVER_PORT'];

$environment = 'AX2009_LIVE';        
        
if ($serverName=='intralinux' ||
    $serverName=='10.98.2.21'){
  $environment = 'AX2009_LIVE';        
  // test omgeving = ACCEPT in AX
  if ($serverPort == 81){
    $environment = 'AX2009_LIVE';
  }
}

if ($serverName == 'sub.igepa.be' ||
    $serverName == '10.0.0.5'){
  $environment = 'AX2009_LIVE';
}

//echo 'serverName  : ' . $serverName  . '<br/>';
//echo 'serverPort  : ' . $serverPort  . '<br/>';
//echo 'environment : ' . $environment . '<br/>';
  
?>