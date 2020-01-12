<?php

// FOR DEV PURPOSES; TO BE DISABLED ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');
ini_set('display_startup_errors', 1);

date_default_timezone_set('Europe/Stockholm');

require_once('Application.php');

$app = new Application();
$app->run();
