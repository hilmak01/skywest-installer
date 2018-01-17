<?php

if(!class_exists(SKYW\Installer::class)){ 
  
  require_once realpath(__DIR__.'/../src/Installer.php');
  
}

$Installer = new SKYW\Installer();

return $Installer->run();
