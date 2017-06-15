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

  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	  
	<link href="./css/modal.css" rel="stylesheet"/>

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
						<a class="navbar-brand" href="#">Table List</a>
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

						<form class="navbar-form navbar-right" role="search">
							<div class="form-group  is-empty">
	                        	<input type="text" class="form-control" placeholder="Search">
	                        	<span class="material-input"></span>
							</div>
							<button type="submit" class="btn btn-white btn-round btn-just-icon">
								<i class="material-icons">search</i><div class="ripple-container"></div>
							</button>
	                    </form>
					</div>
				</div>
			</nav>

	        <div class="content">
	            <div class="container-fluid">
					<div class="row">
						<div class=" col-md-12">
							<div class="col-md-3">
								<button type='button' id='addnew' class='btn btn-warning createuser' data-toggle="modal">Add new
							</div>
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

								<div  class="card-content">
									<div id='relist' class="tab-content">
										<div class="tab-pane fade in active" id="pending">
											<table class="table">
												<thead class="text-primary">
													<th width=20px>RID</th>
													<th class='col-lg-3'>Name</th>
													<th width=250 align=left>Project name</th>
													<th class='col-lg-1'>Type</th>
													<th>Date</th>
													<th>Total</th>
													<th>Action</th>
												</thead>
												<tbody>
													<?php
														$ch = curl_init();

														$token = $_SESSION['token'];
														$url = "$SERVER/reimburse/pending/all?token=".$token;
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
																	<td>".$result['nama_proyek']."</td>
																	<td>".$result['jenis_pengeluaran']."</td>
																	<td>".date_format(date_create($result['tanggal']), 'jS F\,\ Y')
																	."</td>
																	<td>Rp ".number_format($result['jumlah_pengeluaran'], 0, ",", ".")."</td>
																	<td class='text-center'>
																	<button type='button' class='btn btn-primary more-info' data-toggle='modal' data-background-color='orange'>More info</td>
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
										<div class="tab-pane fade" id="accepted">
											<table class="table">
												<thead class="text-primary">
													<th width=20px>RID</th>
													<th class='col-lg-3'>Name</th>
													<th width=250 align=left>Project name</th>
													<th class='col-lg-1'>Type</th>
													<th>Date</th>
													<th>Total</th>
													<th>Action</th>
												</thead>
												<tbody><?php
														$ch = curl_init();

														$token = $_SESSION['token'];
														$url = "$SERVER/reimburse/accepted?token=".$token;
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
																	<td>".$result['nama_proyek']."</td>
																	<td>".$result['jenis_pengeluaran']."</td>
																	<td>".date_format(date_create($result['tanggal']), 'jS F\,\ Y')
																	."</td>
																	<td>Rp ".number_format($result['jumlah_pengeluaran'], 0, ",", ".")."</td>
																	<td class='text-center'>
																	<button type='button' class='btn btn-primary more-info' data-toggle='modal' data-background-color='green'>More info</td>
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
										<div class="tab-pane fade" id="rejected">
											<table class="table">
												<thead class="text-primary">
													<th width=20px>RID</th>
													<th class='col-lg-3'>Name</th>
													<th width=250 align=left>Project name</th>
													<th class='col-lg-1'>Type</th>
													<th>Date</th>
													<th>Total</th>
													<th>Action</th>
												</thead>
												<tbody><?php
														$ch = curl_init();

														$token = $_SESSION['token'];
														$url = "$SERVER/reimburse/rejected?token=".$token;
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
																	<td>".$result['nama_proyek']."</td>
																	<td>".$result['jenis_pengeluaran']."</td>
																	<td>".date_format(date_create($result['tanggal']), 'jS F\,\ Y')
																	."</td>
																	<td>Rp ".number_format($result['jumlah_pengeluaran'], 0, ",", ".")."</td>
																	<td class='text-center'>
																	<button type='button' class='btn btn-primary more-info' data-toggle='modal' data-background-color='red'>More info</td>
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

	<div id="moreInfoModal" class="modal fade" role="dialog" style='z-index:100000'>
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title text-primary" background="green">Reimburse info</h4><br>
				</div>
				<form class='modifyuser' method=POST>
				<div class="modal-body">
					<div class="clearfix"></div>
				</div>
				<div class="modal-footer">
					<button type='button' class="btn btn-success" id='accept'>Accept</button>
					<button type='button' class="btn btn-danger" id='reject'>Reject</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	
</body>
	<script>
	$('#pendingtab').click(function(){
		$('#cardheader').attr('data-background-color', 'orange');
	});
	$('#acceptedtab').click(function(){
		$('#cardheader').attr('data-background-color', 'green');
	});
	$('#rejectedtab').click(function(){
		$('#cardheader').attr('data-background-color', 'red');
	});

	$(function(){
		$(document).on('click', '.more-info', function() {
			var trId = $(this).closest('tr').prop('id').substr(2,2);
			$("#moreInfoModal").modal('show');
			$.notify('opened');
			$("button#accept").click(function(){
				$.ajax({
					type: "POST",
					url: "accept_reimburse.php",
					data: 'reimburse_id='+trId,
					success: function(msg){
						$("#moreInfoModal").modal('hide'); 
						$("#relist").load(location.href + " #relist");
						$("button#accept").unbind('click');
						$("button#reject").unbind('click');
						$.notify(msg);
					},	
					error: function(){
						alert("failure");
					}
				});
				return;
			});
			$("button#reject").click(function(){
				$.ajax({
					type: "POST",
					url: "reject_reimburse.php",
					data: 'reimburse_id='+trId,
					success: function(msg){
						$("#moreInfoModal").modal('hide'); 
						$("#relist").load(location.href + " #relist");
						$("button#accept").unbind('click');
						$("button#reject").unbind('click');
						$.notify(msg);
					},	
					error: function(){
						alert("failure");
					}
				});
				return;
			});
		});
	});

	</script>
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

</html>

<?php

	}
	else{
		echo "Invalid session";
	}
?>
