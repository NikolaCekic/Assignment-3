<?php

	$id = $_POST['id'];
	$arr = array();
	$x = 0;

	try{

		$dbh = new PDO("mysql:host=localhost;dbname=soccer_players","root","");

	} catch(Exception $e){

		//$msg = $e->getMessage();
		//die("<p>ERROR:Couldn'tconnect.{$e‐>getMessage()}</p></body></html>");
	}


	$stmt = $dbh->prepare("SELECT * FROM `player_information` WHERE `Player_ID` = $id");
	$stmt->execute();

	while ($row = $stmt->fetch()) {
				    
		for($i = 0; $i < 8; $i++)
			array_push($arr, $row[$i]);		    
		
		$x++;		    
	}				

	$playerInfo = array(
		
		"name" => $arr[1],
		"position" => $arr[2],
		"skillLevel" => $arr[3],
		"club" => $arr[4],
		"country" => $arr[5],
    	"description" => $arr[6],
        "dateEntered" => $arr[7],
	);

	echo json_encode($playerInfo);

?>