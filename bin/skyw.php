<?php

if(!class_exists(SKYW\Installer)){ 
  
  require_once realpath(__DIR__.'/../src/Installer.php');
  
}
new SKYW\Installer();
