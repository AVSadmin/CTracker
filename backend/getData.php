<?php
	include "db.php";

	// Respond as JSON with key as id and set of coordinates as value.
	$resp = array();
	$result = $conn->query("SELECT id,lat,lng,intensity FROM heatmap");
	if($result){
		while($row = mysqli_fetch_assoc($result)){
			if(!isset($resp[$row['id']]))
				$resp[$row['id']] = array();
			array_push($resp[$row['id']],[$row['lat'],$row['lng'],$row['intensity']]);
		}
	}

	header('Content-Type: application/json');
	echo json_encode($resp);
?>