<!doctype html>

<?php 
	session_start();

	include('config.php');

	if(isset($_SESSION['token'])){

?>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="./assets/img/favicon.png" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Material Dashboard by Creative Tim</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS     -->
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet" />

    <!--  Material Dashboard CSS    -->
    <link href="./assets/css/material-dashboard.css" rel="stylesheet"/>

    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="./assets/css/demo.css" rel="stylesheet" />

    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
</head>

<body>

	<div class="wrapper">

	    <div class="sidebar" data-color="purple" data-image="./assets/img/sidebar-1.jpg">
			<!--
		        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

		        Tip 2: you can also add an image using data-image tag
		    -->

			<div class="logo">
				<a href="http://www.suitmedia.com" class="simple-text">
					Creative Tim
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
	                <li>
	                    <a href="typography.html">
	                        <i class="material-icons">library_books</i>
	                        <p>Menu tambahan</p>
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
						<a class="navbar-brand" href="#">Material Dashboard</a>
					</div>
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav navbar-right">
							<li>
								<a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
									<i class="material-icons">dashboard</i>
									<p class="hidden-lg hidden-md">Dashboard</p>
								</a>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="material-icons">notifications</i>
									<span class="notification">5</span>
									<p class="hidden-lg hidden-md">Notifications</p>
								</a>
								<ul class="dropdown-menu">
									<li><a href="#">Mike John responded to your email</a></li>
									<li><a href="#">You have 5 new tasks</a></li>
									<li><a href="#">You're now friend with Andrew</a></li>
									<li><a href="#">Another Notification</a></li>
									<li><a href="#">Another One</a></li>
								</ul>
							</li>
							<li>
								<a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
	 							   <i class="material-icons">person</i>
	 							   <p class="hidden-lg hidden-md">Profile</p>
		 						</a>
							</li>
						</ul>
					</div>
				</div>
			</nav>

			<div class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-3 col-md-6 col-sm-6">
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
												
												if($resp['success']!=false){
													echo $resp['result']['count'];
												}
												else{
													echo "<tr><h4>".$resp['message']."</h4></tr>";
												}
										?>
										<small>Request</small></h4>
								</div>
								<div class="card-footer">
									<div class="stats">
										<i class="material-icons text-danger">warning</i> <a href="reimbursement.php">Check now...</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="card card-stats">
								<div class="card-header" data-background-color="green">
									<i class="material-icons">attach_money</i>
								</div>
								<div class="card-content">
									<p class="category">Pending amount</p>

									<h4 class="title"> Rp 
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
										
										if($resp['success']!=false){
											echo number_format($resp['result']['amount'], 0, ",", ".");
										}
										else{
											echo "<tr><h4>".$resp['message']."</h4></tr>";
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
 						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="card card-stats">
								<div class="card-header" data-background-color="red">
									<i class="material-icons">account_circle</i>
								</div>
								<div class="card-content">
									<p class="category">Registered user</p>
									<h3 class="title">
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
										
										if($resp['success']!=false){
											echo $resp['result']['count'];
										}
										else{
											echo $resp['message'];
										}
										?>
									</h3>
								</div>
								<!--<div class="card-footer">
									<div class="stats">
										<i class="material-icons">local_offer</i> Tracked from Github
									</div>
								</div>-->
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
											$url = "$SERVER/reimburse/latest?token=".$token;
											curl_setopt($ch, CURLOPT_URL, $url);
											curl_setopt($ch, CURLOPT_POST, 0);
											curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
											$server_output = curl_exec ($ch);
											curl_close ($ch);
											$resp = json_decode($server_output, true);
											
											if($resp!=null){
												echo date_format(date_create($resp['result']['tanggal']), 'jS F Y');		
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
											<th>Type</th>
	                                    	<th>Date</th>
											<th>Total</th>
											<th class='col-sm-2 text-center'>Status</th>
	                                    </thead>
	                                    <tbody>
											<?php
												$ch = curl_init();

												$token = $_SESSION['token'];
												$url = "$SERVER/reimburse/last10?token=".$token;
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
														
														switch($status){
															case 0:
																$label = 'info_outline';
																$color = 'orange';
																break;
															case 1:
																$label = 'done';
																$color = 'green';
																break;
															case 2:
																$label = 'clear';
																$color = 'red';
																break;
														}

														echo "<tr><td>#".$result['id']."</td>
															<td>".$result['user_data']['nama']."</td>
															<td>".$result['nama_proyek']."</td>
															<td>".$result['jenis_pengeluaran']."</td>
															<td>".date_format(date_create($result['tanggal']), 'jS F\,\ Y')
															."</td>
															<td>Rp ".number_format($result['jumlah_pengeluaran'], 0, ",", ".")."</td>
															<td class='text-center'><font class='material-icons' color='$color'>$label</font></td>
														</tr>";
													}
												}
												else{
													echo "<tr><h4>".$resp['message']."</h4></tr>";
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

			<!--<footer class="footer">
				<div class="container-fluid">
					<nav class="pull-left">
						<ul>
							<li>
								<a href="#">
									Home
								</a>
							</li>
							<li>
								<a href="#">
									Company
								</a>
							</li>
							<li>
								<a href="#">
									Portfolio
								</a>
							</li>
							<li>
								<a href="#">
								   Blog
								</a>
							</li>
						</ul>
					</nav>
					<p class="copyright pull-right">
						&copy; <script>document.write(new Date().getFullYear())</script> <a href="http://www.creative-tim.com">Creative Tim</a>, made with love for a better web
					</p>
				</div>
			</footer>-->
		</div>
	</div>

</body>

	<!--   Core JS Files   -->
	<script src="./assets/js/jquery-3.1.0.min.js" type="text/javascript"></script>
	<script src="./assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="./assets/js/material.min.js" type="text/javascript"></script>

	<!--  Charts Plugin -->
	<script src="./assets/js/chartist.min.js"></script>

	<!--  Notifications Plugin    -->
	<script src="./assets/js/bootstrap-notify.js"></script>

	<!--  Google Maps Plugin    -->
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

	<!-- Material Dashboard javascript methods -->
	<script src="./assets/js/material-dashboard.js"></script>

	<!-- Material Dashboard DEMO methods, don't include it in your project! -->
	<script src="./assets/js/demo.js"></script>

	<script type="text/javascript">
    	$(document).ready(function(){

			// Javascript method's body can be found in assets/js/demos.js
        	demo.initDashboardPageCharts();

    	});
	</script>

</html>

	<?php } 
	else{
		echo "Invalid session. Please login";
		header("Location: login.php");
	}
?>

