<?php

	$id = $_POST['id'];
    $name = $_POST['name'];
    $position = $_POST['position'];
    $skillLevel = $_POST['skillLevel'];
    $club = $_POST['club'];
    $country = $_POST['country'];
    $description = $_POST['description'];

    


   try{

		$dbh = new PDO("mysql:host=localhost;dbname=soccer_players","root","");

	} catch(Exception $e){

		//$msg = $e->getMessage();
		//die("<p>ERROR:Couldn'tconnect.{$e‐>getMessage()}</p></body></html>");
	}

	$sql = $dbh->prepare("UPDATE `player_information` SET `Player_ID` = '$id', `Name` = '$name', `Position` = '$position', `Skill_Level` = '$skillLevel', `Club` = '$club', `Country` = '$country', `Description` = '$description' WHERE `Player_ID` = $id");

	$sql->execute();

?>