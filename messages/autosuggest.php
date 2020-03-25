<?php
  include_once("../connexion.php");
 
	$input = $_GET["q"];
	$data = array();
	// query your DataBase here looking for a match to $input
	$query = mysql_query("SELECT FirstName, LastName FROM person WHERE FirstName LIKE '%$input%' OR LastName LIKE '%$input%' LIMIT 10");
	while ($row = mysql_fetch_assoc($query)) {
	$json = array();
	$json['value'] = $row['FirstName']." ".$row['LastName'];
	$json['name'] = $row['FirstName']." ".$row['LastName'];
	//$json['image'] = $row['user_photo'];
	$data[] = $json;
	}
	header("Content-type: application/json");
	echo json_encode($data);

?>