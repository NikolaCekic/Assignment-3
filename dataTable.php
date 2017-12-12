<?php

	session_start();
?>
<!DOCTYPE HTML>
<html>
	<head>
		<!-- Author: Nikola Cekic, 000333667 -->
		<!-- PHP page that validates input from the index pages form submission and either renders format error messages or displays the info in a table-->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<title>Data Table</title>
		<script>
			//prevents user reaching this page by pressing back button
			setTimeout(window.history.forward(), 0);
		</script>
		<style type="text/css">
			
			#clickable:hover {

				background-color: skyBlue;
			}

			#clickable { 

				cursor: pointer; 
			}

		</style>
	</head>
	<body>
		<?php
			
			//calls function to see whether correct username and password were entered.
			$errorMessagesArray = checkUsernameAndPassword();
			//calls function to generate HTML for page, some common and some depending on username and password check.
			commonMarkup($errorMessagesArray);
			
			//checks the username and password entered against a hard-coded user.
			function checkUsernameAndPassword() {
			
				$errorMessagesArray = array();
			
				if ($_POST["userName"] != "Nikola") {
					
					array_push($errorMessagesArray, "<b>The User Name that you entered was incorrect! Try again.</b>");
				}
				
				if ($_POST["password"] != "verySecurePassword23") {
					
					array_push($errorMessagesArray, "<b>The Password that you entered was incorrect! Try again.</b>");
				}
				
				return $errorMessagesArray;
			}
			
			//displays the error messages in h3 tags
			function markup_ErrorMessages($errorMessagesArray) {
				
				foreach($errorMessagesArray as $errorMessage)
					echo "<h3 class= \"text-center\"><span class = \"text-danger\" >$errorMessage</span></h3>";
			}
			
			//displays the player information in a formatted table
			function markup_playerInformation() {
				
				try{

					$dbh = new PDO("mysql:host=localhost;dbname=soccer_players","root","");

				} catch(Exception $e){

					$msg = $e->getMessage();
					//die("<p>ERROR:Couldn'tconnect.{$e‐>getMessage()}</p></body></html>");
				}

				$sql = $dbh->prepare("SELECT * FROM player_information");
				$sql->execute();
	
				$dataBaseFields = array("Player_ID", "Name", "Position", "Skill_Level", "Club", "Country", "Description", "Date_Entered");
								
				echo "<h1 class= \"text-center\"><span class = \"text-danger\" >Player Information</span></h1>";

				echo "<table class = \"container\">";
					
					echo "<tr class = \"row\" >";

					for($i = 1; $i < count($dataBaseFields) -1; $i++) {

						echo "<th class = \"col-xs-2\" ><b>$dataBaseFields[$i]</b></th>";

					}

					echo "</tr>";

					$x = 0;

					while($result = $sql->fetch(PDO::FETCH_ASSOC)){
				
						$x++;

						echo "<tr onclick = \"styleDeleteButton_and_showUpdateButtons();setID($x);\" style = class = \"row\" id = \"clickable\" data-toggle=\"modal\" data-target=\"#myModal\" data-book-id=\"my_id_value\" >";
						
						for($i = 0; $i < count($dataBaseFields) - 1; $i++){

							$value = $result[$dataBaseFields[$i]];
							echo "<td class = \"col-xs-2\" >$value</td>";
						}

						echo "</tr>";
						
						//echo "<hr>";
						//echo "<hr>";
				
					}
					
				echo "</table>";

			}

			//renders the HTML that will be common whether there is a format error or not.
			function commonMarkup($errorMessagesArray) {
				
				echo "<div>";
					echo "<div class = \"jumbotron\">";
				
						//decides whether to display error messages or a table with store info based on whether there were format errors found during validation.
						if ($errorMessagesArray != null) {
			
							markup_ErrorMessages($errorMessagesArray);
							$page = "index";
							$buttonValue = "Back to Login";
							$_SESSION["Logged In"] = false;
						
						} else {
							
							markup_playerInformation();
							$page = "index";
							$buttonValue = "Log Out";
							$_SESSION["Logged In"] = true;
						}
				
					echo "</div>";
					echo "<form  class = \"form-horizontal\"  action = \"$page.php\" method = \"GET\">";
						echo "<div class = \"form-group\">";
							echo "<div class = \"control-label col-xs-6\">";
								if($buttonValue == "Log Out")
									echo "<input style = \"margin-right: 25px\" class = \"btn btn-warning\" type = \"button\" onclick = \"styleModalForInsertClickEvent();\" value = \"Insert\" />";
								echo "<input class = \"btn btn-primary\" type = \"submit\" value = \"$buttonValue\" />";
							echo "</div>";
						echo "</div>";
					echo "</form>";
				echo "</div>";
			}
		?>
		<div class="container">
  
  			<div class="modal fade" id="myModal" role="dialog">
    
    			<div class="modal-dialog modal-lg">
    
      				<div class="modal-content">
        
        				<div class="modal-header">
        	
				        	<button type="button" class="close" data-dismiss="modal">&times;</button>
				        	
				        	<h4 class="modal-title">Change Player Information</h4>
        
        				</div>
        
				        <div class="modal-body">
				          
				        	<form role = "form" class = "form-inline" >

					            <div class = "form-group">
					            	<label>Name</label>
					            	<br>
					            	<input type = "text" class = "form-control" placeholder = "Enter name" />
					            </div>

					            <div class = "form-group">
					            	<label>Position</label>
					            	<br>
					            	<input type = "text" class = "form-control" placeholder = "Enter position" />
					            </div>

					            <div class = "form-group">
					            	<label>Skill Level</label>
					            	<br>
					            	<input type = "text" class = "form-control" placeholder = "Enter skill level" />
					            </div>

					            <div class = "form-group">
					            	<label>Club</label>
					            	<br>
					            	<input type = "text" class = "form-control" placeholder = "Enter club" />
					            </div>

					            <br>
					        	<br>

					            <div class = "form-group">
					            	<label>Country</label>
					            	<br>
					            	<input type = "text" class = "form-control" placeholder = "Enter country" />
					            </div>

					            <div class = "form-group">
					            	<label>Description</label>
					            	<br>
					            	<input style = "width: 400px" type = "text" class = "form-control" placeholder = "Enter breif description of player" />
					            </div>

					            <!--div class="form-group">
					              <label>Date Entered</label>
					              <br>
					              <!--label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label-->
					              <!--input type="text" class="form-control" placeholder="Enter password">
					            </div-->

								<input style = "margin-top: 25px;" type = "button" class = "btn btn-danger" onclick = "deleteRecord();" value = "Delete" />
						        <button style = "margin-top: 25px;" type = "button" class = "btn btn-success" onclick = "updateRecord();" >Update</button>
						        <button style = "margin-top: 25px;" type = "button" class = "btn btn-primary" data-dismiss = "modal" >Close</button>

				          	</form>
				        
				        </div>

				        <div class="modal-footer">
				        
				        </div>
      				
      				</div>
      
    			</div>
  
  			</div>
  
		</div>

	</body>

	
	<script>

		function setID(x){

			//alert("puta " + x);
			localStorage.setItem(id, x);

			var id = localStorage.getItem(id);
			//alert("id: " + id);
			$.ajax({ 
				url: "crud.php",
	         	//data: {action: 'test'},
	         	type: "POST",
	       		data: "id=" + id,
	       		dataType: "json",
	       		success: function(retrieved) {
	                     
	                //var x = localStorage.getItem(1); 
	                //alert(retrieved[0]);
	       			//document.getElementsByTagName('label')[4].innerHTML = retrieved[0];
	       			//var a = document.getElementsByTagName('input')[4];

	       			$(document.getElementsByTagName('input')[2]).attr('value', retrieved.name);
	       			$(document.getElementsByTagName('input')[3]).attr('value', retrieved.position);
	       			$(document.getElementsByTagName('input')[4]).attr('value', retrieved.skillLevel);
	       			$(document.getElementsByTagName('input')[5]).attr('value', retrieved.club);
	       			$(document.getElementsByTagName('input')[6]).attr('value', retrieved.country);
	       			$(document.getElementsByTagName('input')[7]).attr('value', retrieved.description);
	       			//$(document.getElementsByTagName('input')[7]).attr('placeholder', retrieved.dateEntered);

	       			//alert("retrieved: " + retrieved[0]);
	       			//$(a).attr('placeholder', retrieved[1]);

	       			//console.log(retrieved);

	       			//var data = jQuery.parseJSON(retrieved);
        			//alert(retrieved.name);
        			console.log(retrieved);

	       			//var resultObj = eval(retrieved);
        			//alert("resultOBJ "+ resultObj );

	                //$('#myModal').modal("hide");

	                //reloads page so deleted record is no longer visible
					//location.reload();
	            }
			});		
		}

		function deleteRecord() {
			
			var id = localStorage.getItem(id);
			//alert("id: " + id);
			
			var proceed = confirm("Are you sure you want to delete this record?");

			if (proceed) {
			    
			    $.ajax({ 
					url: "delete.php",
	         		type: "POST",
	         		data: "id=" + id,
	         		success: function(retrieved) {
	                      
	                    $('#myModal').modal("hide");

	                    //reloads page so deleted record is no longer visible
						location.reload();
	                }
				});			
			} 
		}

		function insertRecord() {
				
			var name = document.getElementsByTagName('input')[2].value;
			var position = document.getElementsByTagName('input')[3].value;
			var skillLevel = document.getElementsByTagName('input')[4].value;
			var club = document.getElementsByTagName('input')[5].value;
			var country = document.getElementsByTagName('input')[6].value;
			var description = document.getElementsByTagName('input')[7].value;

			$.ajax({
			    url: "insert.php",
			    data: {name: name, position: position, skillLevel: skillLevel, club: club, country: country, description: description},
			    type: "POST",
			    success: function(msg){

			    	//hides the modal upon successful insert
 					$('#myModal').modal("hide");

 					//reloads the page to see current records in up to date state
			    	location.reload();
		    	}
   			});
   		}

		function updateRecord() {
				
			var id = localStorage.getItem(id);
			alert(id);
			var name = document.getElementsByTagName('input')[2].value;
			var position = document.getElementsByTagName('input')[3].value;
			var skillLevel = document.getElementsByTagName('input')[4].value;
			var club = document.getElementsByTagName('input')[5].value;
			var country = document.getElementsByTagName('input')[6].value;
			var description = document.getElementsByTagName('input')[7].value;

			$.ajax({
			    url: "update.php",
			    data: {id: id, name: name, position: position, skillLevel: skillLevel, club: club, country: country, description: description},
			    type: "POST",
			    success: function(msg){

			    	//hides the modal upon successful update
 					$('#myModal').modal("hide");

 					//reloads the page to see current records in up to date state
			    	location.reload();
		    	}
   			});
			
		}

		function styleModalForInsertClickEvent(){

   			//remove values from text boxes in the case that the modal has been opened and therefore populated with values.
   			$(document.getElementsByTagName('input')[2]).attr('value', "");
	       	$(document.getElementsByTagName('input')[3]).attr('value', "");
	       	$(document.getElementsByTagName('input')[4]).attr('value', "");
	       	$(document.getElementsByTagName('input')[5]).attr('value', "");
	       	$(document.getElementsByTagName('input')[6]).attr('value', "");
	       	$(document.getElementsByTagName('input')[7]).attr('value', "");

	       	//changes delete button to become insert button
	       	$(document.getElementsByTagName('input')[8]).attr('value', "");
	       	$(document.getElementsByTagName('input')[8]).attr('value', "Insert");
	       	$(document.getElementsByTagName('input')[8]).attr('onclick', "insertRecord();");
	       	$(document.getElementsByTagName('input')[8]).attr('class', "btn btn-warning");
	       	
	       	//hides update button
	       	$(document.getElementsByTagName('button')[1]).hide();

   			$('#myModal').modal('show');
		}

		function styleDeleteButton_and_showUpdateButtons(){

			//changes insert button to become delete button
			$(document.getElementsByTagName('input')[8]).attr('value', "");
			$(document.getElementsByTagName('input')[8]).attr('value', "Delete");
	       	$(document.getElementsByTagName('input')[8]).attr('onclick', "deleteRecord();");
	       	$(document.getElementsByTagName('input')[8]).attr('class', "btn btn-danger");

	       	//shows update button
			$(document.getElementsByTagName('button')[1]).show();
		}

	</script>
	

</html>