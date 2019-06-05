<?php

require("class_api.php");
$API = new Api();
$API->setAllowedMethods(array("GET"));


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: ".$API->printAllowedMethods());
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$API->loadRequest($_SERVER);
$API->setRequestMethod($_SERVER['REQUEST_METHOD']);
$API->requireSSL();
$API->loadParams($_GET);
$API->prepareData();
$API->response();

?>


