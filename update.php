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
					//echo "<script>alert('try')</script>";

				} catch(Exception $e){

					//echo "<script>alert('catch')</script>";
					//$msg = $e->getMessage();
					//echo "<p>$msg</p>";
					//echo "<script>alert($msg)</script>";
					//die("<p>ERROR:Couldn'tconnect.{$e‐>getMessage()}</p></body></html>");
			}


				//$sql = $dbh->prepare("INSERT INTO `player_information` (`Player_ID`, `Name`, `Position`, `Skill_Level`, `Club`, `Country`, `Description`, `Date_Entered`) VALUES (NULL, $name, $position, $skillLevel, $club, $country, $description, '')");


				$sql = $dbh->prepare("UPDATE `player_information` SET `Player_ID` = '$id', `Name` = '$name', `Position` = '$position', `Skill_Level` = '$skillLevel', `Club` = '$club', `Country` = '$country', `Description` = '$description' WHERE `Player_ID` = $id");



				//UPDATE Customers
				//SET ContactName = 'Alfred Schmidt', City= 'Frankfurt'
				//WHERE CustomerID = 1;


				//INSERT INTO `soccer_players`.`player_information` (`Player_ID`, `Name`, `Position`, `Skill_Level`, `Club`, `Country`, `Description`, `Date_Entered`) VALUES (NULL, 'sada', 'a', '4', 'sada', 'sadas', 'sadas', '');


				$sql->execute();

				
				//the following 6 lines reset the player ids
				/*$sql = $dbh->prepare("ALTER TABLE `player_information` DROP `Player_ID`;");
				$sql->execute();

				$sql = $dbh->prepare("ALTER TABLE `player_information` AUTO_INCREMENT = 1;");
				$sql->execute();

				$sql = $dbh->prepare("ALTER TABLE `player_information` ADD `Player_ID` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;");
				$sql->execute();



				//ALTER TABLE `player_information` DROP `Player_ID`;
				//ALTER TABLE `player_information` AUTO_INCREMENT = 1;
				//ALTER TABLE `player_information` ADD `Player_ID` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
?>