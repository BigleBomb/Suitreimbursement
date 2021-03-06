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
	                <li class="active">
	                    <a href="user.php">
	                        <i class="material-icons">person</i>
	                        <p>User Management</p>
	                    </a>
	                </li>
	                <li>
	                    <a href="projects.php">
	                        <i class="material-icons">content_paste</i>
	                        <p>Projects</p>
	                    </a>
	                </li>
					<li>
	                    <a href="reimburse.php">
	                        <i class="material-icons">account_balance_wallet</i>
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
						<a class="navbar-brand" href="#">User Management</a>
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
	                <div class="column">
	                    <div class="col-md-12">
							<div class="col-md-3">
								<button type='button' class='btn btn-primary createuser' data-toggle="modal">Create user
							</div>
	                        <div class="card">
	                            <div class="card-header" data-background-color="purple">
	                                <h4 class="title">User list</h4>
									<p class="category">List of existing user</p>
	                            </div>
	                            <div class="card-content table-responsive">
	                                <table id='maintable' class="table">
	                                    <thead id='tablehead'class="text-primary">
											<th width=20px>UID</th>
	                                    	<th class='col-lg-4'>Name</th>
	                                    	<th width=250 align=left>Email</th>
	                                    	<th>Date registered</th>
											<th class='text-center'>Action</th>
	                                    </thead>
	                                    <tbody id='usertable'>
											<?php
												$ch = curl_init();

												$token = $_SESSION['token'];
												$url = "$SERVER/user/all?token=".$token;
												curl_setopt($ch, CURLOPT_URL, $url);
												curl_setopt($ch, CURLOPT_POST, 0);
												curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
												$server_output = curl_exec ($ch);
												curl_close ($ch);
												$resp = json_decode($server_output);
												if($resp->success != false){
													foreach($resp->result as $result){
														echo "<tr id='tr".$result->id."'>
															<td>#".$result->id."</td>
															<td>".$result->nama."</td>
															<td>".$result->email."</td>
															<td>".date_format(date_create($result->created_at), 'jS F\,\ Y')."</td>
															<td class='text-center'><button type='button' class='btn btn-primary modify-user' data-toggle='modal'>Modify<span><button type='button' class='btn btn-primary delete-user' data-toggle='modal'>Delete</td>
														</tr>";
													}
												}
												else{
													echo "<tr><td colspan=5 align=center><h4>".$resp->message."</h4></td></tr>";
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

	        <footer class="footer">
	            <div class="container-fluid">

	            </div>
	        </footer>
	    </div>
	</div>
	<div id="createUserModal" class="modal fade" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title text-primary" background="green">Create new user</h4><br>
						<div id='alertt'>
						</div>	
					</div>
						<div class="modal-body">
						<form id='userreg' class='userreg' method=POST>
							<div class="column">
								<div class="col-md-8">
									<div class="form-group label-floating">
										<label class="control-label">Name</label>
										<input type="text" id='nama' class="form-control" name="nama" required data-toggle="tooltip" data-placement="right" title="Masukkan nama">
									</div>
								</div>
								<div class="col-md-8">
									<div class="form-group label-floating">
										<label class="control-label">Username</label>
										<input type="text" id='username' class="form-control" name="username" required data-toggle="tooltip" data-placement="right" title="Masukkan username">
									</div>
								</div>
								<div class="col-md-8">
									<div class="form-group label-floating">
										<label class="control-label">Email</label>
										<input type="email" id='email' class="form-control" name="email" required data-toggle="tooltip" data-placement="right" title="Masukkan email">
									</div>
								</div>
								<div class="col-md-8">
									<div class="form-group label-floating">
										<label class="control-label">Privillege</label>
										<select id='selectPriv' form='userreg' class="form-control" name="priv">
											<option value='1'>User</option>
											<option value='2'>Admin</option>
										</select>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						</form>
						<div class="modal-footer">
							<button class="btn btn-success" id='submit'>Create</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal" id='cancelcreate'>Cancel</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="modifyUserModal" class="modal fade" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title text-primary" background="green" id='modify-header'>Modify user</h4><br>
					</div>
					<div class="modal-body modify-user-body">
					<div class="clearfix"></div>
					</div>
					<div class="modal-footer">
						<button class="btn btn-success" id='modify'>modify</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="deleteUserModal" class="modal fade" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title text-primary" background="green">Delete user</h4><br>
					</div>
					<div class="modal-body delete-user-body">
					<div class="clearfix"></div>
					</div>
					<div class="modal-footer">
						<button class="btn btn-danger" id='delete'>Delete</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal" id='canceldel'>Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>
<script>

	$(document).ready(function(){
		$('#createUserModal').on('hidden.bs.modal', function () {
			$('button#submit').unbind('click');
		})
	});

	$(document).ready(function(){
		$('#deleteUserModal').on('hidden.bs.modal', function () {
			$('button#delete').unbind('click');
		})
	});

	$(document).ready(function(){
		$('#modifyUserModal').on('hidden.bs.modal', function () {
			$(document).off('click', '.buttonedit');
			$("#modify").unbind('click');
		})
	});

	$(document).ready(function() {
		$(".createuser").click(function(){
			$("#createUserModal").modal('show');
			$("button#submit").click(function(){
				if($('form.userreg')[0].checkValidity()) {
					$.ajax({
						type: "POST",
						url: "register_user.php",
						data: $('form.userreg').serialize(),
						success: function(msg){
							$("#createUserModal").modal('hide');
							$('#maintable').load(location.href + ' #maintable');
							$("button#submit").unbind('click');
							$.notify(msg);
						},	
						error: function(){
							alert('error');
						}
					});
				}
				else{
					$('#nama').tooltip('show');
					$('#username').tooltip('show');
					$('#email').tooltip('show');
				}
			});
		});
	});
	
	
	$(document).ready(function(){
		$(document).on('click', ".delete-user", function() {
			var trId = $(this).closest('tr').prop('id').substr(2,2);
			$("#deleteUserModal").modal('show');
			$('.delete-user-body').show().html("<h4>Are you sure you want to delete this user?</h4><br><b>Note</b>: Deleting user will also delete its reimburse requests.");
			$("button#delete").click(function(){
				$.ajax({
					type: "POST",
					url: "delete_user.php",
					data: 'user_id='+trId,
					success: function(msg){
						$("#deleteUserModal").modal('hide'); 
						$('#maintable').load(location.href + ' #maintable');
						$.notify(msg);
						$("button#delete").unbind('click');
					},	
					error: function(){
						alert("failure");
					}
				});
			});
		});
	});
	
	$(document).on('click', '.modify-user', function() {
		var trId = $(this).closest('tr').prop('id').substr(2,2);
		$.ajax({
			type: "POST",
			url: "get_user_info.php",
			data: 'user_id='+trId,
			success: function(msg){
				$("#modifyUserModal").modal('show');
				$('#maintable').load(location.href + ' #maintable')
				$('.modify-user-body').show().html(msg);
				$('#modify-header').html("User ID #"+trId+" details");
				$(document).on('click', '.buttonedit',function() {
					var tdId = $(this).closest('td');
					if (tdId.find('input').length){
						tdId.text(tdId.find('input').val());
					}
					else {
						tdId.children('.buttonedit').remove();
						var t = tdId.text().trim();
						tdId.html($('<input />',{'value' : t}).val(t));
						tdId.children('input').addClass('form-control');
						tdId.children('input').focus();
						tdId.children('input').focusout(function(){
							var inside = tdId.children('input').val();
							tdId.children('input').remove();
							var button = "<button id='btnuser' type='button' rel='tooltip' class='btn btn-primary btn-simple btn-xs buttonedit'> <i class='material-icons'>edit</i></button>";
							tdId.html(inside+button);
						});
					}
				});
				$('#modify').click(function(){
					var name = $('#tdName').clone().children().remove().end().text().trim();
					var username = $('#tdUsername').clone().children().remove().end().text().trim();
					var email = $('#tdEmail').clone().children().remove().end().text().trim();
					var limit = $('#tdLimit').clone().children().remove().end().text().trim();
					$.ajax({
						type: "POST",
						url: "update_user.php",
						data: 'user_id='+trId+'&name='+name+'&username='+username+'&email='+email+'&limit='+limit,
						success: function(msg){
							$("#modify").unbind('click');
							$("#modifyUserModal").modal('hide'); 
							$('#maintable').load(location.href + ' #maintable');
							$.notify(msg);
						},	
						error: function(){
							alert("failure");
						}
					});
				});
			},	
			error: function(){
				alert("failure");
			}
		});
	});
	</script>

</html>

<?php
	}else{
		echo "Invalid session";
		header("Location:login.php");
	}
?>
