<?php
@include_once('config/config.php');
@include_once('../../config/config.php');
require_once(__PATH__.'/package/extras/class/Database.php');

class DaoMap{
	private $conn;
	
	public function __construct(){
		$this->conn = new Database();
	}
	
	public function __destruct(){
		$this->conn->getConn()->close();
	}
	
	public function saveMapCoord($map){
		$data = array();
		$data[] = $this->conn->clearData($map->getUser()->getId());
		$data[] = $this->conn->clearData($map->getLatitude());
		$data[] = $this->conn->clearData($map->getLongitude());
		$data[] = $this->conn->clearData($map->getAltitude());
		$data[] = $this->conn->clearData($map->getTime());
		
		$query = "INSERT INTO 
					laa_coordinate(id_user, latitude, longitude, altitude, time)
					VALUES (".$data[0].", '".$data[1]."', '".$data[2]."', '".$data[3]."', ".$data[4].")";
		
		$query = $this->conn->removeBreakLine($query);
		$this->conn->getConn()->query($query);
		return($this->conn->getConn()->affected_rows);
					
	}
	
	public function getLastMapCoord($user){
		$data = array();
		$data[] = $this->conn->clearData($user->getId());
		
		$query = "";
	}
	
	public function getLastMapCoord($user){
		$data = array();
		
		$data[] = $this->conn->cleanData($user->getId());
		
		$query = "SELECT latitude, longitude, altitude, time FROM laa_coordinate WHERE id_user = '".$data[0]."' ORDER BY id DESC LIMIT 1 ";
		
		$query = $this->conn->removeBreakLine($query);
		$result = $this->conn->getConn()->query($query);
		
		$map = NULL;
		while($data = $result->fetch_object()){
			$map = new Map();
			$map->setId($data->id);
			$map->setLatitude($data->latitude);
			$map->setLongitude($data->longitude);
			$map->setAltitude($data->altitude);
			break;
		}
		$result->free();
		return($map);
	}

}