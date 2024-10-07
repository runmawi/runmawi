
<!--   Icon Section   -->
<div class="row">
	<div class="col s12 m6">
	  <div class="icon-block">
		<h5 class="mb-3 text-center">Change password</h5>
		<form class="mt-4" id="account_changepassword" action="actions/account_update.php">
			<input type="hidden" name="actionid" value=2>
			<div class="form-group">
				<label>Current password</label>
				<input type="password" class="form-control mb-0" name="password1" placeholder="" autocomplete="off" required>
			</div>
			<div class="form-group">
				<label>New password</label>
				<input type="password" class="form-control mb-0" name="password2" placeholder=""  autocomplete="off"  required>
			</div>
			<div class="form-group">
				<label>Repeat new password</label>
				<input type="password" class="form-control mb-0" name="password3" placeholder="" autocomplete="off" required>
			</div>
			<div class="d-flex text-end">
			   <input type=submit class="btn btn-hover" value="Update">
			</div>
		</form>
	  </div>
	</div>
</div>

<script>
$(function() {
    $('#account_changepassword').submit(function (event){
        event.preventDefault();
        var form = $(event.target); 
		var formData = form.serialize();
        var url = form.attr('action');
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
			timeout: 10000,
			beforeSend: function(){
				//Loading(1);
			},
            success: function (data) {
				/*
					data is in JSON format;
					status = 1: Success
					status = 0: Failed
				*/
				const obj = JSON.parse(data); 
				
				status = obj.status;
				
				if(status == 1){
					alert("Password changed succesfully.");
					$("#account_changepassword").trigger("reset");
				}
				else if(status == 2)  alert("New passwords does not match.");
				else if(status == 3) alert("Current password is incorrect");
				else alert("There's a problem, please try again." + data);
		
				//Loading(0);	
            },
			
            error: function (e) {
                alert("Cannot reach server.. Please try again. ");
				//Loading(0);

            }
        });
    });
});
</script>