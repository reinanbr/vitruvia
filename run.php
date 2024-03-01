<?php

function runShell(String $command):String{
	return Shell_exec($command);
}

function getTypeFile(String $filename):String{
	if($filename==""){
		return 0;
	}else{
		$typeFile = explode(".",$filename)[1];
		return $typeFile;
	}
}

function globFile(String $typeFile, String $dir=""):array{
	$listFile = explode("\n",runShell("ls $dir*.$typeFile"));
	$resGlob = array();
	foreach($listFile as $file){
		$type = getTypeFile($file);
		if($type==$typeFile){
			$resGlob[] = $file;
		}
	}
	return $resGlob;
}

function requireFileDirPHP(String $dir){
	$fileListDir = globFile("php",$dir);
	foreach($fileListDir as $phpFile){
		require_once $phpFile;
	}
}

