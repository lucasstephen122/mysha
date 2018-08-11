<div class="row green">
	<div class="col-sm-12">
		<h3 class="text-center">Administrator Signin</h3>
	</div>
	<div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-12">
		<div class="m-b-20"></div>
		<p class="text-center">Please enter your credentials</p>
		<form id="frm_signin" name="frm_signin" action="<?php echo $base_url ?>admin/do_signin" method="POST">
			<?php show_error_message(); ?>
			<div class="form-group">
				<label for="email">Email address</label>
				<input type="email" class="form-control" id="email" name="email" placeholder="Email">
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="password" name="password" placeholder="Password">
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-block pinkcolor" id="submit" value="Login">
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function()
{
	init_signin();
});

function init_signin()
{
	var $frm_signin = $('#frm_signin');

	$frm_signin.validate(
	{
		rules:
		{
			email:
			{
				required: true,
				maxlength: 50,
				email: true
			},
			password:
			{
				required: true,
				maxlength: 50
			},			
		},

		messages:
		{
			email:
			{
				required: "Email is required",
				maxlength: "Email should not exceed 50 characters",
				email: "Invalid email address"
			},
			password:
			{
				required: "Password is required",
				maxlength: "Password should not exceed 50 characters"
			},			
		},

		submitHandler: function (form)
		{
			form[0].submit();
		}
	});

}
</script>
