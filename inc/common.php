<?php

error_reporting(E_ERROR);
ini_set('default_charset', 'UTF-8');
session_start();

include_once ("../custom/config.php");
include_once (DB_CLASS); // DEPRECATED ***************************

function __autoload($class) {
	require_once("../inc/classes/" . $class . ".php");
}

include_once ("../custom/mydefines.php");
