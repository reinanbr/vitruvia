<?php

$httpRequest = $_SERVER;
$methodHttp = $httpRequest["REQUEST_METHOD"];
$methodData = array();

if ($methodHttp == "GET"){
	$methodData = $_GET;
}
else if ($methodHttp == "POST"){
	$methodData = $_POST;
}

$phpInput = file_get_contents("php://input");
$phpInputJson = json_decode($phpInput);

$infoRequest = array(
	"methodData"=>$methodData,
	"allDataInput"=>$phpInputJson,
	"httpRequest"=>$httpRequest
);
echo json_encode($infoRequest);
