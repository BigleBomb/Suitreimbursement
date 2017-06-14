<html>
	
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet" />
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<body>
    <div class="col-md-3">
        <button type='button' class='btn btn-primary' data-toggle="modal" data-target="#createUserModal">Create user
    </div>
    <div id="createUserModal" class="modal fade" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
        			<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title text-primary" background="green">Create new user</h4>
					<div id='alertt'>
					</div>	
					</div>
					<form class='userreg' method=POST>
						<div class="modal-body">
							<div class="column">
								<div class="col-md-8">
									<div class="form-group label-floating">
										<label class="control-label">Name</label>
										<input type="text" class="form-control" name="nama">
									</div>
								</div>
								<div class="col-md-8">
									<div class="form-group label-floating">
										<label class="control-label">Username</label>
										<input type="text" class="form-control" name="username">
									</div>
								</div>
								<div class="col-md-8">
									<div class="form-group label-floating">
										<label class="control-label">Email</label>
										<input type="email" class="form-control" name="email" >
									</div>
								</div>
								<div class="col-md-8">
									<div class="form-group label-floating">
										<label class="control-label">Privillege</label>
										<select class="form-control" name="priv">
											<option>Karyawan</option>
											<option>Atasan</option>
											<option>Admin</option>
										</select>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="modal-footer">
							<button class="btn btn-success" id='submit'>Create</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>

<script>
	$(function() {
		$("button#submit").click(function(){
			$.ajax({
				type: "POST",
				url: "register_user.php",
				data: $('form.userregis').serialize(),
					success: function(msg){
							$("#alertt").html(msg)
					$("#form-content").modal('hide'); 
					},	
					error: function(){
						alert("failure");
					}
			});
		});
	});
</script>
</html>