<?php
// auto-generated by sfDatabaseConfigHandler
// date: 2016/01/23 10:00:02

$database = new sfPropelDatabase();
$database->initialize(array (
  'phptype' => 'mysql',
  'persistent' => true,
  'host' => '10.10.10.2',
  'database' => 'orion_snapps_sfguard',
  'username' => 'snapps',
  'password' => 'athousandless',
), 'sfguard');
$this->databases['sfguard'] = $database;

$database = new sfPropelDatabase();
$database->initialize(array (
  'phptype' => 'mysql',
  'persistent' => true,
  'host' => '10.10.1.249',
  'database' => 'snapps_general',
  'username' => 'snapps',
  'password' => 'athousandless',
), 'general');
$this->databases['general'] = $database;

$database = new sfPropelDatabase();
$database->initialize(array (
  'phptype' => 'mysql',
  'persistent' => true,
  'host' => '10.10.10.2',
  'database' => 'orion_snapps_hr',
  'username' => 'snapps',
  'password' => 'athousandless',
), 'hr');
$this->databases['hr'] = $database;

$database = new sfPropelDatabase();
$database->initialize(array (
  'phptype' => 'mysql',
  'persistent' => true,
  'host' => '10.10.10.2',
  'database' => 'orion_snapps_forecast',
  'username' => 'snapps',
  'password' => 'athousandless',
), 'forecast');
$this->databases['forecast'] = $database;

$database = new sfPropelDatabase();
$database->initialize(array (
  'phptype' => 'mysql',
  'persistent' => true,
  'host' => '10.10.1.249',
  'database' => 'snapps_philips',
  'username' => 'snapps',
  'password' => 'athousandless',
), 'hgas');
$this->databases['hgas'] = $database;

$database = new sfPropelDatabase();
$database->initialize(array (
  'phptype' => 'mysql',
  'persistent' => true,
  'host' => '10.10.1.250',
  'database' => 'mercury_online_garment',
  'username' => 'orion249',
  'password' => 'orion249',
), 'mercury_online_garment');
$this->databases['mercury_online_garment'] = $database;

$database = new sfPropelDatabase();
$database->initialize(array (
  'phptype' => 'mysql',
  'persistent' => true,
  'host' => '10.10.1.249',
  'database' => 'snapps_garment_rental',
  'username' => 'snapps',
  'password' => 'athousandless',
), 'rental');
$this->databases['rental'] = $database;

$database = new sfPropelDatabase();
$database->initialize(array (
  'phptype' => 'mysql',
  'persistent' => true,
  'host' => '10.10.1.249',
  'database' => 'snapps_hpreels',
  'username' => 'snapps',
  'password' => 'athousandless',
), 'hpreels');
$this->databases['hpreels'] = $database;

$database = new sfPropelDatabase();
$database->initialize(array (
  'phptype' => 'mysql',
  'persistent' => true,
  'host' => '10.10.1.249',
  'database' => 'snapps_reject_photo',
  'username' => 'snapps',
  'password' => 'athousandless',
), 'reject_photo');
$this->databases['reject_photo'] = $database;

$database = new sfPropelDatabase();
$database->initialize(array (
  'phptype' => 'mysql',
  'persistent' => true,
  'host' => 'localhost',
  'database' => 'snapps_hgas3',
  'username' => 'seagate',
  'password' => 'seagate123until1000',
), 'hgas3');
$this->databases['hgas3'] = $database;

$database = new sfPropelDatabase();
$database->initialize(array (
  'phptype' => 'mysql',
  'persistent' => true,
  'host' => '10.10.10.2',
  'database' => 'orion_snapps_iso',
  'username' => 'snapps',
  'password' => 'athousandless',
), 'iso');
$this->databases['iso'] = $database;
