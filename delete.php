<?php 

//$action = $_POST["test"];
//echo $action;

?>

<?php
    $id = $_POST['id'];
    //echo "The id is ". $id;

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


				$sql = $dbh->prepare("DELETE FROM `player_information` WHERE `Player_ID` = $id");
				$sql->execute();

				
				//the following 6 lines reset the player ids
				$sql = $dbh->prepare("ALTER TABLE `player_information` DROP `Player_ID`;");
				$sql->execute();

				$sql = $dbh->prepare("ALTER TABLE `player_information` AUTO_INCREMENT = 1;");
				$sql->execute();

				$sql = $dbh->prepare("ALTER TABLE `player_information` ADD `Player_ID` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;");
				$sql->execute();



				//ALTER TABLE `player_information` DROP `Player_ID`;
				//ALTER TABLE `player_information` AUTO_INCREMENT = 1;
				//ALTER TABLE `player_information` ADD `Player_ID` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
?>