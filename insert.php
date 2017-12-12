<?php

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

	$sql = $dbh->prepare("INSERT INTO `player_information` (`Player_ID`, `Name`, `Position`, `Skill_Level`, `Club`, `Country`, `Description`, `Date_Entered`) VALUES (NULL, '$name', '$position', '$skillLevel', '$club', '$country', '$description', '')");
	
	$sql->execute();

?>