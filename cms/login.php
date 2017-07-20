<!DOCTYPE html>
<html lang="en">

<?php
	include('config.php');
?>

<head>
	<meta charset="utf-8">
	<title>Daily UI - Day 1 Sign In</title>

	<!-- Google Fonts -->
	<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700|Lato:400,100,300,700,900' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="./css/animate.css">
	<!-- Custom Stylesheet -->
	<link rel="stylesheet" href="./css/style.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script><!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
	<div class="container">
		<div class="login-box animated fadeInUp">
			<div class="box-header">
				<h2>Log In</h2>
			</div>
			<form method=POST>
			<label for="email">Email</label>
			<br/>
			<input type="text" name="email">
			<br/>
			<label for="password">Password</label>
			<br/>
			<input type="password" name="password">
			<br/>
			<button type="submit" name="signin">Sign In</button>
			<br/>
			<a href="#"><p class="small">Forgot your password?</p></a></form>
			<?php 
				if(isset($_POST['signin'])){
					$email = $_POST['email'];
					$password = $_POST['password'];
					$ch = curl_init();

					curl_setopt($ch, CURLOPT_URL,"$SERVER/user/login");
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS,
            				"email=$email&password=$password");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$server_output = curl_exec ($ch);
					curl_close ($ch);
					$resp = json_decode($server_output);			

					var_dump($resp);

					if($resp != null){
						if ($resp->success===true){
							session_start();
							$_SESSION['token']= $resp->user_data->token;
							$_SESSION['user_id'] = $resp->user_data->id;
							echo $_SESSION['token'];
							header("Location: dashboard.php");
						}
						else {
							echo '<div class="alert alert-danger alert-dismissable">
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									<strong>Email or password is wrong</strong>
								</div>';
						}
					}
					else{
						echo '<div class="alert alert-danger alert-dismissable">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Could not connect to the server</strong>
							</div>';
					}

				}
			 ?>
		</div>
	</div>
</body>

<script>
	$(document).ready(function () {
    	$('#logo').addClass('animated fadeInDown');
    	$("input:text:visible:first").focus();
	});
	$('#username').focus(function() {
		$('label[for="username"]').addClass('selected');
	});
	$('#username').blur(function() {
		$('label[for="username"]').removeClass('selected');
	});
	$('#password').focus(function() {
		$('label[for="password"]').addClass('selected');
	});
	$('#password').blur(function() {
		$('label[for="password"]').removeClass('selected');
	});
</script>

</html>