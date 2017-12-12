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
			
			//calls function to validate info from form submission on index page.
			$errorMessagesArray = validateInput();
			//calls function to generate HTML for page, some common and some depeninding on validation.
			commonMarkup($errorMessagesArray);
			
			//validates form input from index page using regular expressions and adds an error message to the error message array if an error is found
			//the strings are not sanitized because the regular expressions don't allow for HTML tags to be added
			function validateInput() {
			
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
			
			//displays the store information in a formatted table
			function markup_StorePropertiesTable() {
				
				try{

					$dbh = new PDO("mysql:host=localhost;dbname=soccer_players","root","");
					//echo "<script>alert('hola')</script>";

				} catch(Exception $e){

					echo "<script>alert('puta')</script>";
					$msg = $e->getMessage();
					echo "<p>$msg</p>";
					//echo "<script>alert($msg)</script>";
					//die("<p>ERROR:Couldn'tconnect.{$e‐>getMessage()}</p></body></html>");
				}


				$sql = $dbh->prepare("SELECT * FROM player_information");
				
				//$query = $dbh->query("SELECT * FROM `player_information`");
				//echo "<script>alert('query: ' . $query)</script>";

				//if($query)
					//echo "<script>alert('true')</script>";
				//else
					//echo "<script>alert('false')</script>";



				$sql->execute();

				/*while($result = $sql->fetch(PDO::FETCH_ASSOC)){
				
					echo $result['Player ID'];
					echo $result['Name'];
					echo $result['Position'];
					echo $result['Skill Level'];
					echo $result['Club'];
					echo $result['Country'];
					echo $result['Description'];
					echo $result['Date Entered'];
				
				}
				/*$command = "SELECT * FROM player_information";
				$stmnt = $dbh->prepare($command);
				//$stmnt->execute();
				echo "<script>alert('1')</script>";
				$users = $stmnt->fetchAll();
				echo "<script>alert('2')</script>";
				echo "<script>alert($users[0])</script>";
				echo "<script>alert($users)</script>";

				/*for($i = 0; $i < count($users) -1; $i++){

					echo "<script>alert($users[$i])</script>";
				}*/

				/*foreach ($users as $user) {
				    echo "<script>alert('foreach')</script>";
				    echo $user . '<br />';
				}*/

				/*if($row = $stmnt->fetch()){

					echo "<table><tr>";

						foreach($row as $key => $value){

							echo "<td>$value</td>";
						}

					echo "</tr></table>";
				}*/


	
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
						//echo "<script>alert('yes ' + x);</script>";

						$txtBoxVals = array();

						for($i = 0; $i < count($dataBaseFields) - 1; $i++){

							//array_push($txtBoxVals, $dataBaseFields[$i]);
							//$value = $result[$dataBaseFields[$i]];
							//echo "<script>alert($value)</script>";
						}


						echo "<tr onclick = \"styleDeleteButton_and_showUpdateButtons();func($txtBoxVals);setID($x);\" style = class = \"row\" id = \"clickable\" data-toggle=\"modal\" data-target=\"#myModal\" data-book-id=\"my_id_value\" >";
						
						for($i = 0; $i < count($dataBaseFields) - 1; $i++){

							$value = $result[$dataBaseFields[$i]];
							echo "<td class = \"col-xs-2\" >$value</td>";
							//echo "<script>alert($value)</script>";
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
						
						} else {
							
							markup_StorePropertiesTable();
							$page = "index";
							$buttonValue = "Log Out";
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
				          
				        	<!--p>Some text in the modal.</p-->
				        	<form role = "form" class = "form-inline" >

					            <div class = "form-group">
					            	<script>

					            		//$("document").ready(function(){

						            		//func();

						            		/*function func(){

							            		var a = localStorage.getItem(id);
							            		var b = document.getElementsByTagName("label")[3];
							            		b.innerHTML = "puta";
							            		alert(a);
						            		}*/
						            	//});

					            	</script>
					              <label>Name</label>
					              <br>
					              <input type = "text" class = "form-control" placeholder = "Enter name" required />
					            </div>

					            <div class = "form-group">
					              <label>Position</label>
					              <br>
					              <!--label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label-->
					              <input type = "text" class = "form-control" placeholder = "Enter position" required />
					            </div>

					            <div class = "form-group">
					              <label>Skill Level</label>
					              <br>
					              <!--label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label-->
					              <input type = "text" class = "form-control" placeholder = "Enter skill level" required />
					            </div>

					            <div class = "form-group">
					              <label>Club</label>
					              <br>
					              <!--label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label-->
					              <input type = "text" class = "form-control" placeholder = "Enter club" required />
					            </div>

					            <br>
					        	<br>

					            <div class = "form-group">
					              <label>Country</label>
					              <br>
					              <!--label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label-->
					              <input type = "text" class = "form-control" placeholder = "Enter country" required />
					            </div>

					            <div class = "form-group">
					              <label>Description</label>
					              <br>
					              <!--label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label-->
					              <input style = "width: 400px" type = "text" class = "form-control" placeholder = "Enter breif description of player" required />
					            </div>

					            <!--div class="form-group">
					              <label>Date Entered</label>
					              <br>
					              <!--label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label-->
					              <!--input type="text" class="form-control" placeholder="Enter password">
					            </div-->

					            <!--div class="checkbox">
					              <label><input type="checkbox" value="" checked>Remember me</label>
					            </div-->

				              	<!--button type="submit" class="btn btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Login</button-->

								<input style = "margin-top: 25px;" type = "button" class = "btn btn-danger" onclick = "deleteRecord();" value = "Delete" />
						        <!--button type="button" class="btn btn-default" onclick = "styleModalForInsertClickEvent();" >Insert</button-->
						        <button style = "margin-top: 25px;" type = "button" class = "btn btn-success" onclick = "updateRecord();" >Update</button>
						        <button style = "margin-top: 25px;" type = "button" class = "btn btn-primary" onclick = "//location.reload();" data-dismiss = "modal" >Close</button>

				          	</form>
				        
				        </div>

				        <div class="modal-footer">

					        
					        <!--button type="button" class="btn btn-default" onclick = "deleteRecord();" >Delete</button>
					        <!--button type="button" class="btn btn-default" onclick = "styleModalForInsertClickEvent();" >Insert</button-->
					        <!--button type="button" class="btn btn-default" onclick = "updateRecord();" >Update</button>
					        <button type="button" class="btn btn-default" onclick = "location.reload();" data-dismiss = "modal" >Close</button-->

				        </div>
      				
      				</div>
      
    			</div>
  
  			</div>
  
		</div>

	</body>

	
	<script>
		
		/*$('#my_modal').on('show.bs.modal', function(e) {

				var bookId = $(e.relatedTarget).data('book-id');
				alert("yo " + bookId);
			});*/


		//var id = 0;

		//function getId(id){

		//	return id;
		//}

		function func(txtBoxVals){

			//var a = localStorage.getItem(id);
			//var b = document.getElementsByTagName("label")[3];
			//b.innerHTML = "puta";
			//alert(a);

			//document.getElementsByTagName('label')[3].innerHTML = "mf";
			//b.innerHTML = "Puta";

			for(var i = 0; i < txtBoxVals.length; i++){
				//alert(txtBoxVals[i]);
				//document.getElementsByTagName('label')[i].innerHTML = txtBoxVals[i];
			}
		}

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
	         		//data: {action: 'test'},
	         		type: "POST",
	         		data: "id=" + id,
	         		success: function(retrieved) {
	                      
	                    //alert(retrieved);
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

   			$(document.getElementsByTagName('input')[8]).attr('value', "");


   			//remove values from text boxes in the case that the modal has been opened and therefore populated with values.
   			$(document.getElementsByTagName('input')[2]).attr('value', "");
	       	$(document.getElementsByTagName('input')[3]).attr('value', "");
	       	$(document.getElementsByTagName('input')[4]).attr('value', "");
	       	$(document.getElementsByTagName('input')[5]).attr('value', "");
	       	$(document.getElementsByTagName('input')[6]).attr('value', "");
	       	$(document.getElementsByTagName('input')[7]).attr('value', "");

	       	//
	       	$(document.getElementsByTagName('input')[8]).attr('value', "");
	       	$(document.getElementsByTagName('input')[8]).attr('value', "Insert");
	       	$(document.getElementsByTagName('input')[8]).attr('onclick', "insertRecord();");
	       	$(document.getElementsByTagName('input')[8]).attr('class', "btn btn-warning");
	       	


	       	//$(document.getElementsByTagName('button')[1]).hide();
	       	$(document.getElementsByTagName('button')[1]).hide();

   			$('#myModal').modal('show');
		}

		function styleDeleteButton_and_showUpdateButtons(){

			$(document.getElementsByTagName('input')[8]).attr('value', "");
			$(document.getElementsByTagName('input')[8]).attr('value', "Delete");
	       	$(document.getElementsByTagName('input')[8]).attr('onclick', "deleteRecord();");
	       	$(document.getElementsByTagName('input')[8]).attr('class', "btn btn-danger");

			$(document.getElementsByTagName('button')[1]).show();
	       	//$(document.getElementsByTagName('button')[2]).show();
		}

	</script>
	

</html>