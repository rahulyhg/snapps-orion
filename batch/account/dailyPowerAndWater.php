<?php
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/../..'));
define('SF_APP',         'maintenance');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       false);


require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

	$sdt = Date('Y-m-d');
	$edt = Date('Y-m-d');
	//$edt = $sdt = '2016-01-18';
	$user = 'SYSTEM';
	$br = "\n\r";
	echo '*------------------------------*'.$br;
	echo 'Processing '.date('F j, Y, g:i a') . $br;
	echo 'Updating Power and Water Reading'.$br;
	echo 'Processing the Period of: '.DateUtils::DUFormat('F j, Y', $sdt).' to ' .DateUtils::DUFormat('F j, Y', $edt) . $br;	
	echo '*------------------------------*'.$br;
  	maintenanceLib::ComputeDailyPowerConsumption($sdt, $edt);
  	echo 'Power Entry... Ok'.$br;
  	maintenanceLib::ComputeDailyWaterConsumption($sdt, $edt);
	echo 'Water Entry... Ok'.$br;
	echo 'Success!'.$br;	
	
?>
