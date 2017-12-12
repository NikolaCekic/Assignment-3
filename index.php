<?php
	
	session_start();
	
	session_unset();
	session_destroy();	
	
	session_start();

?>
<!DOCTYPE HTML>
<html>
	<head>
		<!-- Author: Nikola Cekic, 000333667 -->
		<!-- PHP page with an HTML form that collects data for user authentication-->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<title>Log In</title>
		<script>
			//prevents user reaching this page by pressing back button
			setTimeout(window.history.forward(), 0);
		</script>
	</head>
	<body>
		<div>
			<div class = "jumbotron">
				<h1 class= "text-center"><span class = "text-danger" >Log In!</span></h1>
			</div>
			<form  class = "form-horizontal" action = "dataTable.php" method = "POST">
				<div class = "form-group">
					<label class = "control-label col-xs-5" >User Name:</label>
					<div class="col-xs-3">
						<input class = "form-control" type = "text" name = "userName" placeholder = "Enter User Name" required />
					</div>
				</div>
				<div class = "form-group">
					<label class="control-label col-xs-5">Password:</label>
					<div class="col-xs-3">
						<input class = "form-control" type = "text" name = "password" placeholder = "Enter Password" required />
					</div>
				</div>
				<div class = "form-group">
					<div class="control-label col-xs-7">
						<input class = "btn btn-primary" type = "submit" name = "logIn" value = "Log In" />
					</div>
				</div>
			</form>
		</div>
	</body>
</html>