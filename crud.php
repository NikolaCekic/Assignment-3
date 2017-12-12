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

					echo "<script>alert('catch')</script>";
					//$msg = $e->getMessage();
					//echo "<p>$msg</p>";
					//echo "<script>alert($msg)</script>";
					//die("<p>ERROR:Couldn'tconnect.{$e‐>getMessage()}</p></body></html>");
			}


				$stmt = $dbh->prepare("SELECT * FROM `player_information` WHERE `Player_ID` = $id");
				$stmt->execute();


				//$arr = [];
				$arr = array();
				//$arr = array(1,2,3);

				$x = 0;

				while ($row = $stmt->fetch()) {
				    
				    //echo "<script>localStorage.setItem(1, 'fook');var x = localStorage.getItem(1);</script>";
				    //echo "<scipt></script>";
				    
					for($i = 0; $i < 8; $i++)
				    	array_push($arr, $row[$i]);

				    //$y = $row[$x];
				    //echo "<script>alert($y)</script>";

				    $x++;
				}

				//array_push($arr, "foooooooooook");
				//$arr[0] = "foook";
				//for($i = 0; $i < count($arr); $i++)
					//echo json_encode($arr[$i]);

				//the following 6 lines reset the player ids
				//$sql = $dbh->prepare("ALTER TABLE `player_information` DROP `Player_ID`;");
				//$sql->execute();

				//$sql = $dbh->prepare("ALTER TABLE `player_information` AUTO_INCREMENT = 1;");
				//$sql->execute();

				//$sql = $dbh->prepare("ALTER TABLE `player_information` ADD `Player_ID` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;");
				//$sql->execute();



				//ALTER TABLE `player_information` DROP `Player_ID`;
				//ALTER TABLE `player_information` AUTO_INCREMENT = 1;
				//ALTER TABLE `player_information` ADD `Player_ID` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;


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

					//echo count($arr);
?>