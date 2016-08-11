<?php 
session_start();
@include_once('config/config.php');
@include_once('../../config/config.php');
require_once(__PATH__.'/package/apl/AplMap.php');

if(preg_match('/^(send-map-coords){1}$/', $_POST['method']) || preg_match('/^(send-map-coords){1}$/', $_GET['method'])){
	$apl = new AplMap();
	$map = new Map();
	
	$map->post($_POST);
	
	$return = $apl->saveMapCoord($map);
	
	echo json_encode(array('feedback' => $return));
}
elseif(preg_match('/^(get-last-map-coords){1}$/', $_POST['method']) || preg_match('/^(get-last-map-coords){1}$/', $_GET['method'])){
	$apl = new AplMap();
	$user = new User(1);
	
	$map = $apl->getLastMapCoord($user);
	
	echo json_encode(array('map' => is_null($map) ? '' : $map->getDataJSON()));
}

