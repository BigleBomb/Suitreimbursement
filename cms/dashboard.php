<!doctype html>

<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="./assets/img/favicon.png" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Suitmedia Reimbursement </title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS     -->
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet" />

    <!--  Material Dashboard CSS    -->
    <link href="./assets/css/material-dashboard.css" rel="stylesheet"/>

    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>

	<!--   Core JS Files   -->
	<script src="./assets/js/jquery-3.1.0.min.js" type="text/javascript"></script>
	<script src="./assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="./assets/js/material.min.js" type="text/javascript"></script>

	<!--  Charts Plugin -->
	<script src="./assets/js/chartist.min.js"></script>

	<!--  Notifications Plugin    -->
	<script src="./assets/js/bootstrap-notify.js"></script>

	<!-- Material Dashboard javascript methods -->
	<script src="./assets/js/material-dashboard.js"></script>
	
</head>


<?php 
	session_start();

	include('config.php');

	if(isset($_SESSION['token'])){
		include('check_session.php');

?>

<body>

	<div class="wrapper">

	    <div class="sidebar" data-color="purple" data-image="./assets/img/sidebar-1.jpg">

			<div class="logo">
				<a href="http://www.suitmedia.com" class="simple-text">
					Reimbursement
				</a>
			</div>

	    	<div class="sidebar-wrapper">
	            <ul class="nav">
	                <li class="active">
	                    <a href="dashboard.php">
	                        <i class="material-icons">dashboard</i>
	                        <p>Dashboard</p>
	                    </a>
	                </li>
	                <li>
	                    <a href="user.php">
	                        <i class="material-icons">person</i>
	                        <p>User Management</p>
	                    </a>
	                </li>
	                <li>
	                    <a href="reimbursement.php">
	                        <i class="material-icons">content_paste</i>
	                        <p>Reimbursement</p>
	                    </a>
	                </li>
	            </ul>
	    	</div>
	    </div>

	    <div class="main-panel">
			<nav class="navbar navbar-transparent navbar-absolute">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">Dashboard</a>
					</div>
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav navbar-right">
							<li>
								<a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
	 							   <i class="material-icons">person</i>
	 							   <p class="hidden-lg hidden-md">Profile</p>
		 						</a>
								<ul class="dropdown-menu">
									<li><a href="#">Log out</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</nav>

			<div class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-4 col-md-6 col-sm-6">
							<div class="card card-stats">
								<div class="card-header" data-background-color="orange">
									<i class="material-icons">content_copy</i>
								</div>
								<div class="card-content">
									<p class="category">Pending reimburse</p>
									<h4 class="title">
										<?php
											$ch = curl_init();

												$token = $_SESSION['token'];
												$url = "$SERVER/reimburse/pending/totalcount?token=".$token;
												curl_setopt($ch, CURLOPT_URL, $url);
												curl_setopt($ch, CURLOPT_POST, 0);
												curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
												$server_output = curl_exec ($ch);
												curl_close ($ch);
												$resp = json_decode($server_output, true);
												
												if($resp!=null){
													if($resp['success']!=false){
														echo $resp['result']['count'];
														echo " <small>Request(s)</small>";
													}
													else{
														echo $resp['message'];
													}
												}else{
													echo "Cannot get data from the server.";
												}
										?>
										</h4>
								</div>
								<div class="card-footer">
									<div class="stats">
										<i class="material-icons text-danger">warning</i> <a href="reimbursement.php">Check now...</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-6 col-sm-6">
							<div class="card card-stats">
								<div class="card-header" data-background-color="green">
									<i class="material-icons">attach_money</i>
								</div>
								<div class="card-content">
									<p class="category">Pending amount</p>
									<h4 class=title>		
									<?php
										$ch = curl_init();
										$token = $_SESSION['token'];
										$url = "$SERVER/reimburse/pending/totalamount?token=".$token;
										curl_setopt($ch, CURLOPT_URL, $url);
										curl_setopt($ch, CURLOPT_POST, 0);
										curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
										$server_output = curl_exec ($ch);
										curl_close ($ch);
										$resp = json_decode($server_output, true);
										
										if($resp != null){
											if($resp['success']!=false){
												echo "Rp ";
												echo number_format($resp['result']['amount'], 0, ",", ".")."</h4>";
											}
											else{
												echo $resp['message'];
											}
										}
										else{
											echo "Cannot get data from the server.";
										}
									?>
									</h4>
								</div>
								<div class="card-footer">
									<div class="stats">
										<i class="material-icons">date_range</i> Last 24 Hours
									</div>
								</div>
							</div>
						</div>
 						<div class="col-lg-4 col-md-6 col-sm-6">
							<div class="card card-stats">
								<div class="card-header" data-background-color="red">
									<i class="material-icons">account_circle</i>
								</div>
								<div class="card-content">
									<p class="category">Registered user</p>
									<h4 class="title">
										<?php
										$ch = curl_init();
										$token = $_SESSION['token'];
										$url = "$SERVER/user/count?token=".$token;
										curl_setopt($ch, CURLOPT_URL, $url);
										curl_setopt($ch, CURLOPT_POST, 0);
										curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
										$server_output = curl_exec ($ch);
										curl_close ($ch);
										$resp = json_decode($server_output, true);
										
										if($resp != null){
											if($resp['success']!=false){
												echo $resp['result']['count'];
											}
											else{
												echo $resp['message'];
											}
										}else{
											echo "Cannot get data from the server.";
										}
										?>
									</h4>
								</div>
							<div class="card-footer">
									<div class="stats">
									<i class="material-icons">face</i> <a href="user.php">Manage User...</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="card">
	                            <div class="card-header" data-background-color="orange">
	                                <h4 class="title">Last 10 Reimbursement History</h4>
	                                <p class="category">New reimburse on 
										<?php
											$ch = curl_init();
											$token = $_SESSION['token'];
											$url = "$SERVER/reimburse/last/1?token=".$token;
											curl_setopt($ch, CURLOPT_URL, $url);
											curl_setopt($ch, CURLOPT_POST, 0);
											curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
											$server_output = curl_exec ($ch);
											curl_close ($ch);
											$resp = json_decode($server_output, true);
											
											if($resp['success'] == true){
												foreach($resp['result'] as $result){
													echo date_format(date_create($result['created_at']), 'jS F Y');
												}		
											}
											else{
												echo "Data not found";
											}
										?>
									</p>
	                            </div>
	                            <div class="card-content table-responsive">
	                                <table class="table table-hover">
	                                    <thead class="text-warning">
	                                        <th class="col-lg-1">RID</th>
	                                    	<th>Name</th>
	                                    	<th class="col-sm-2">Project name</th>
	                                    	<th>Date</th>
											<th>Total</th>
											<th class='col-sm-2 text-center'>Status</th>
	                                    </thead>
	                                    <tbody>
											<?php
												$ch = curl_init();

												$token = $_SESSION['token'];
												$url = "$SERVER/reimburse/last/10?token=".$token;
												curl_setopt($ch, CURLOPT_URL, $url);
												curl_setopt($ch, CURLOPT_POST, 0);
												curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
												$server_output = curl_exec ($ch);
												curl_close ($ch);
												$resp = json_decode($server_output, true);
												if($resp['success']!=false){
													foreach($resp['result'] as $result){
														$status = $result['status'];
														$label;
														$color;
														$title;
														
														switch($status){
															case 0:
																$label = 'info_outline';
																$color = 'orange';
																$title = 'Pending';
																break;
															case 1:
																$label = 'done';
																$color = 'green';
																$title = 'Accepted';
																break;
															case 2:
																$label = 'clear';
																$color = 'red';
																$title = 'Rejected';
																break;
														}

														echo "<tr><td>#".$result['id']."</td>
															<td>".$result['user_data']['nama']."</td>
															<td>".$result['project_name']."</td>
															<td>".date_format(date_create($result['date']), 'jS F\,\ Y')
															."</td>
															<td>Rp ".number_format($result['total_cost'], 0, ",", ".")."</td>
															<td class='text-center'><font title='$title' class='material-icons' color='$color'>$label</font></td>
														</tr>";
													}
												}
												else{
													echo "<tr><td colspan=6 align=center><h4>".$resp['message']."</h4></td></tr>";
												}
											?>
	                                    </tbody>
	                                </table>
	                            </div>
	                        </div>
						</div>
					</div> 
				</div>
			</div>
		</div>
	</div>

</body>

<script>
	setInterval(function(){
		$.ajax({                                      
			url: 'check_session.php',   
			success: function(msg){
				$(html).append(msg);
			} 
		});
	}, 1000);
	</script>

</html>

	<?php } 
	else{
		echo "Invalid session. Please login";
		header("Location: login.php");
	}
?>

