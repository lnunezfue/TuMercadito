<?php
require_once 'config/database.php';
require_once 'helpers/session_helper.php';
require_once 'helpers/prediction_helper.php';

spl_autoload_register(function($className){
  require_once 'libraries/' . $className . '.php';
});
