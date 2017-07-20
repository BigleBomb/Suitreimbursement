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
	

	<style>
	.scrollbar
	{
		margin-left: 30px;
		float: left;
		height: 300px;
		width: 65px;
		background: #F5F5F5;
		overflow-y: scroll;
		margin-bottom: 25px;
	}
	#style-10::-webkit-scrollbar-track
	{
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
		background-color: #F5F5F5;
		border-radius: 10px;
	}

	#style-10::-webkit-scrollbar
	{
		width: 10px;
		background-color: #F5F5F5;
	}

	#style-10::-webkit-scrollbar-thumb
	{
		background-color: #AAA;
		border-radius: 10px;
		background-image: -webkit-linear-gradient(90deg,
												rgba(0, 0, 0, .2) 25%,
												transparent 25%,
												transparent 50%,
												rgba(0, 0, 0, .2) 50%,
												rgba(0, 0, 0, .2) 75%,
												transparent 75%,
												transparent)
	}
	</style>
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
	                    <a href="projects.php">
	                        <i class="material-icons">content_paste</i>
	                        <p>Projects</p>
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
						<div class="col-md-12">
							<div class="card">
	                            <div class="card-header" data-background-color="orange">
	                                <h4 class="title">Projects list</h4>
	                                <p class="category">New project on 
										<?php
											$ch = curl_init();
											$token = $_SESSION['token'];
											$url = "$SERVER/project/last/1?token=".$token;
											curl_setopt($ch, CURLOPT_URL, $url);
											curl_setopt($ch, CURLOPT_POST, 0);
											curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
											$server_output = curl_exec ($ch);
											curl_close ($ch);
											$resp = json_decode($server_output);
											
											if($resp->success == true){
												foreach($resp->result as $result){
													echo date_format(date_create($result->created_at), 'jS F Y');
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
	                                    	<th class="col-lg-3">Project name</th>
											<th class="col-lg-2">User count</th>
	                                    	<th>Date</th>
											<th>Total</th>
											<th style='visibility:hidden'>Action</th>
	                                    </thead>
	                                    <tbody>
											<?php
												$ch = curl_init();

												$token = $_SESSION['token'];
												$url = "$SERVER/project/all?token=".$token;
												curl_setopt($ch, CURLOPT_URL, $url);
												curl_setopt($ch, CURLOPT_POST, 0);
												curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
												$server_output = curl_exec ($ch);
												curl_close ($ch);
												$resp = json_decode($server_output);
												if($resp->success!=false){
													foreach($resp->result as $result){

														echo "<tr id='tr".$result->id."'><td>#".$result->id."</td>
															<td>".$result->project_name."</td>
															<td>".$result->user_count."</td>
															<td>".date_format(date_create($result->date), 'jS F\,\ Y')
															."</td>
															<td>Rp ".number_format($result->total_cost, 0, ",", ".")."</td>
															<td><button type='button' class='btn btn-primary more-info' data-toggle='modal' data-background-color='orange'>More info</td>
															
														</tr>";
													}
												}
												else{
													echo "<tr><td colspan=6 align=center><h4>".$resp->message."</h4></td></tr>";
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

	// $('#content').on('click', '.add-user', function(){
		
	// });

	$('#content').on('click', '.reimburse-info', function() {
		var rid = $(this).closest('tr').prop('id').substr(2,2);
		$.ajax({
			type: "POST",
			url: "get_reimburse_info.php",
			data: 'reimburse_id='+rid,
			success: function(msg){
				$('#content').fadeOut(500, function(){
					$('#content').html(msg);
				});
				$('#content').fadeIn(500);					
			},	
			error: function(){
				alert("failure");
			}
		});
	});

	$('#content').on('click', "#accept", (function(){
		var reason = $("#reason").val();
		var id = $('.rid').prop('id').substr(1,2);
		var pid = $('.projectid').prop('id').substr(2,2);
		$.ajax({
			type: "POST",
			url: "accept_reimburse.php",
			data: 'reimburse_id='+id+'&reason='+reason,
			success: function(msg){
				getProjectInfo(pid);
				$(document).off('click', "#accept");
				$.notify(msg);
			},	
			error: function(){
				alert("failure");
			}
		});
	}));

	$('#content').on('click', "#reject", (function(){
		var reason = $("#reason").val();
		var id = $('.rid').prop('id').substr(1,2);
		var pid = $('.projectid').prop('id').substr(2,2);
		$.ajax({
			type: "POST",
			url: "reject_reimburse.php",
			data: 'reimburse_id='+id+'&reason='+reason,
			success: function(msg){
				getProjectInfo(pid);
				$(document).off('click', "#reject");
				$.notify(msg);
			},	
			error: function(){
				alert("failure");
			}
		});
	}));

	$('#content').on('click', "#back-to-project", function(){
		var pid = $('.projectid').prop('id').substr(2,2);
		getProjectInfo(pid);
		$(document).off('click', "#back-to-project");
	});

	$('#content').on('click', '.more-info', function() {
		var trId = $(this).closest('tr').prop('id').substr(2,2);
		getProjectInfo(trId);
	});

	function getProjectInfo(id){
		$.ajax({
				type: "POST",
				url: "get_project_info.php",
				data: 'project_id='+id,
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
								$(document).off('click', "#back");
							});
						});
					});
				},	
				error: function(){
					alert("failure");
				}
			});
	}
	</script>

	<div id="addUserModal" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Modal Header</h4>
				</div>
				<div class="modal-body">
					<p>Some text in the modal.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>

</html>

<?php

	}
	else{
		echo "Invalid session";
		header("Location: login.php");
	}
?>
