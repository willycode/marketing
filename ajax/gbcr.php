<?php
	include('../includes/config.php');

	if(is_null($_GET['name'])){
		$date = date("Y-m-d");
	} else {
		$date = $_GET['name'];
	}

	$query = "select concat(fbad,webad) as adtrace, count(userid) as role from member where time LIKE '".$date."%' and userid IN (select DISTINCT userid from register where time LIKE '".$date."%' and userid IN (select userid from createrole where time LIKE '".$date."%')) and category = 'gamebase' group by adtrace order by role desc";

	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

	$arr = array();
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$arr[] = $row;	
		}
	}

	# JSON-encode the response
	$json_response = json_encode($arr);

	// # Return the response
	echo $json_response;
?>



