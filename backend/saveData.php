<?php

	// Insert a new heatmap into database.
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	if(!isset($_REQUEST['heatmap'])){
		echo "NO HEATMAP";
		die();
	}

	$data = json_decode($_REQUEST['heatmap']);
	$recorder = $_REQUEST['recorder'];
	$patientId = $_REQUEST['patientId'];
	$patientStart = $_REQUEST['patientStart'];
	$patientEnd = $_REQUEST['patientEnd'];

	if($data == null){
		echo "HEATMAP EMPTY";
		die();
	}
	include 'db.php';
	$qry = "INSERT INTO CTrackerData.markup(recorder,ip,patientId, patientStart, patientEnd) VALUES ('".$recorder."','".getUserIpAddr()."','".$patientId."','".$patientStart."','".$patientEnd."')";
	//var_dump($qry);
	$result = $conn->query($qry);
	if($result){
		$last_id = mysqli_insert_id($conn);
		foreach ($data as $coordinate) {
			$conn->query("INSERT INTO CTrackerData.heatmap(mid,lat,lng,active) VALUES ($last_id,$coordinate[0],$coordinate[1],1)");
		}
		$tmp = array("patientId"=>$patientId,"recorder"=>$recorder,"id"=>$last_id);
		$tmp = json_encode($tmp);
		echo $tmp;
	}
?>