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
	                <li>
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
	                <li class="active">
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
						<a class="navbar-brand" href="#">Reimburesement</a>
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
	            <div id='content' class="container-fluid">
					<div class="row">
						<div class=" col-md-12">
							<div class="card card-nav-tabs">
								<div id='cardheader' class="card-header fade in" data-background-color="orange">
									<div class="nav-tabs-navigation">
										<div class="nav-tabs-wrapper">
											<span class="nav-tabs-title">Reimbursements:</span>
											<ul class="nav nav-tabs" data-tabs="tabs">
												<li class="active">
													<a href="#pending" id='pendingtab' data-toggle="tab">
														<i class="material-icons">info_outline</i>
														Pending
													<div class="ripple-container"></div></a>
												</li>
												<li class="">
													<a href="#accepted" id='acceptedtab' data-toggle="tab">
														<i class="material-icons">done</i>
														Accepted
													<div class="ripple-container"></div></a>
												</li>
												<li class="">
													<a href="#rejected" id='rejectedtab' data-toggle="tab">
														<i class="material-icons">close</i>
														Rejected
													<div class="ripple-container"></div></a>
												</li>
											</ul>
										</div>
									</div>
								</div>

								<div id ='relist' class="card-content">
									<div class="tab-content">
										<div class="tab-pane fade in active" id="pending">
											<table class="table">
												<thead class="text-primary">
													<th width=20px>RID</th>
													<th class='col-lg-3'>Name</th>
													<th width=250 align=left>Project name</th>
													<th>Date</th>
													<th>Total</th>
													<th>Action</th>
												</thead>
												<tbody>
													<?php
														$ch = curl_init();

														$token = $_SESSION['token'];
														$url = "$SERVER/reimburse/list/pending?token=".$token;
														curl_setopt($ch, CURLOPT_URL, $url);
														curl_setopt($ch, CURLOPT_POST, 0);
														curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
														$server_output = curl_exec ($ch);
														curl_close ($ch);
														$resp = json_decode($server_output, true);
														if($resp['success'] != false){
															foreach($resp['result'] as $result){
																echo "<tr><tr id='tr".$result['id']."'>
																	<td>#".$result['id']."</td>
																	<td>".$result['user_data']['nama']."</td>
																	<td>".$result['project_name']."</td>
																	<td>".date_format(date_create($result['date']), 'jS F\,\ Y')
																	."</td>
																	<td>Rp ".number_format($result['total_cost'], 0, ",", ".")."</td>
																	<td class='text-center'>
																	<button type='button' class='btn btn-primary more-info' data-toggle='modal' data-background-color='orange'>More info</td>
																</tr>";
															}
														}
														else{
															echo "<tr><td colspan='6' align=center><h4>".$resp['message']."</h4></td></tr>";
														}
													?>
												</tbody>
											</table>
										</div>
										<div class="tab-pane fade" id="accepted">
											<table class="table">
												<thead class="text-primary">
													<th width=20px>RID</th>
													<th class='col-lg-3'>Name</th>
													<th width=250 align=left>Project name</th>
													<th>Date</th>
													<th>Total</th>
													<th>Action</th>
												</thead>
												<tbody>
												<?php
													$ch = curl_init();

													$token = $_SESSION['token'];
													$url = "$SERVER/reimburse/list/accepted?token=".$token;
													curl_setopt($ch, CURLOPT_URL, $url);
													curl_setopt($ch, CURLOPT_POST, 0);
													curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
													$server_output = curl_exec ($ch);
													curl_close ($ch);
													$resp = json_decode($server_output, true);
													if($resp['success']!=false){
														foreach($resp['result'] as $result){
															echo "<tr><tr id='tr".$result['id']."'>
																<td>#".$result['id']."</td>
																<td>".$result['user_data']['nama']."</td>
																<td>".$result['project_name']."</td>
																<td>".date_format(date_create($result['date']), 'jS F\,\ Y')
																."</td>
																<td>Rp ".number_format($result['total_cost'], 0, ",", ".")."</td>
																<td class='text-center'>
																<button type='button' class='btn btn-primary more-info' data-toggle='modal' data-background-color='green'>More info</td>
															</tr>";
														}
													}
													else{
														echo "<tr><td colspan='6' align=center><h4>".$resp['message']."</h4></td></tr>";
													}
												?>
												</tbody>
											</table>
										</div>
										<div class="tab-pane fade" id="rejected">
											<table class="table">
												<thead class="text-primary">
													<th width=20px>RID</th>
													<th class='col-lg-3'>Name</th>
													<th width=250 align=left>Project name</th>
													<th>Date</th>
													<th>Total</th>
													<th>Action</th>
												</thead>
												<tbody><?php
														$ch = curl_init();

														$token = $_SESSION['token'];
														$url = "$SERVER/reimburse/list/rejected?token=".$token;
														curl_setopt($ch, CURLOPT_URL, $url);
														curl_setopt($ch, CURLOPT_POST, 0);
														curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
														$server_output = curl_exec ($ch);
														curl_close ($ch);
														$resp = json_decode($server_output, true);
														if($resp['success'] != false){
															foreach($resp['result'] as $result){
																echo "<tr id='tr".$result['id']."'>
																	<td>#".$result['id']."</td>
																	<td>".$result['user_data']['nama']."</td>
																	<td>".$result['project_name']."</td>
																	<td>".date_format(date_create($result['date']), 'jS F\,\ Y')
																	."</td>
																	<td>Rp ".number_format($result['total_cost'], 0, ",", ".")."</td>
																	<td class='text-center'>
																	<button type='button' class='btn btn-primary more-info' data-toggle='modal' data-background-color='red'>More info</td>
																</tr>";
															}
														}
														else{
															echo "<tr><td colspan='6' align=center><h4>".$resp['message']."</h4></td></tr>";
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

	        <footer class="footer">
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
	        </footer>
	    </div>
	</div>
	
</body>
<script>
	// setInterval(function(){
	// 	$.ajax({                                      
	// 		url: 'check_session.php',          
	// 		data: "",
	// 		dataType: 'json',                  
	// 		success: function(msg)
	// 		{
	// 			document.write(msg);
	// 		} 
	// 	});
	// }, 1000);
	$(document).ready(function(){
		$('#moreInfoModal').on('hidden.bs.modal', function () {
			$('button#accept').unbind('click');
			$('button#reject').unbind('click');
			$('body').off('click', '.more-info');
		})
	});

	$(document).ready(function(){
		$('#cardheader').addClass("fade in");
		$(document).on('click', '#pendingtab', (function(){
			$('#cardheader').attr('data-background-color', 'orange');
		}));
		$(document).on('click', '#acceptedtab', (function(){
			$('#cardheader').attr('data-background-color', 'green');
		}));
		$(document).on('click', '#rejectedtab', (function(){
			$('#cardheader').attr('data-background-color', 'red');
		}));
	})

	$(function(){
		$(document).on('click', '.more-info', function() {
			var trId = $(this).closest('tr').prop('id').substr(2,2);
			$.ajax({
				type: "POST",
				url: "get_reimburse_info.php",
				data: 'reimburse_id='+trId,
				success: function(msg){
					$('#content').fadeOut(500, function(){
						$('#content').html(msg);
					});
					$('#content').fadeIn(500);
					$(document).on('click', "#back", function(){
						$(window).scrollTop(0);
						$('#content').fadeOut(500, function(){
							$('#content').load(location.href + ' #content', function(){
								$('#content').fadeIn(500);
							});
						});
						$(document).off('click', "#back");
						$(document).off('click', "#accept");
						$(document).off('click', "#reject");
					});
					$(document).on('click', "#accept", (function(){
						var reason = $("#reason").val();
						$.ajax({
							type: "POST",
							url: "accept_reimburse.php",
							data: 'reimburse_id='+trId+'&reason='+reason,
							success: function(msg){
						$(window).scrollTop(0);
								$('#content').fadeOut(500, function(){
									$('#content').load(location.href + ' #content', function(){
										$('#content').fadeIn(500);
									});
								});
								$(document).off('click', "#back");
								$(document).off('click', "#accept");
								$(document).off('click', "#reject");
								$.notify(msg);
							},	
							error: function(){
								alert("failure");
							}
						});
						return;
					}));
					$(document).on('click', "#reject", (function(){
						var reason = $("#reason").val();
						$.ajax({
							type: "POST",
							url: "reject_reimburse.php",
							data: 'reimburse_id='+trId+'&reason='+reason,
							success: function(msg){
						$(window).scrollTop(0);
								$('#content').fadeOut(500, function(){
									$('#content').load(location.href + ' #content', function(){
										$('#content').fadeIn(500);
									});
								});
								$(document).off('click', "#back");
								$(document).off('click', "#accept");
								$(document).off('click', "#reject");
								$.notify(msg);
							},	
							error: function(){
								alert("failure");
							}
						});
						return;
					}));
				},	
				error: function(){
					alert("failure");
				}
			});
		});
	});
	</script>

</html>

<?php

	}
	else{
		echo "Invalid session";
		header("Location: login.php");
	}
?>
