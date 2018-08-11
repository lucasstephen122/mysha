<div class="row green">
	<div class="col-sm-12">
		<h3 class="text-center">Congrats</h3>
	</div>
	<div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-12">
		<div class="m-b-20"></div>
		<p class="text-center">Please check your email to get your login details</p>
		<form id="frm_signin" name="frm_signin" action="<?php echo $base_url ?>user/do_signin" method="POST">
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
				<div class="row row-pad">
					<div class="col-sm-6">
						<a href="<?php echo $base_url; ?>user/forgot_password">Forgot your password?</a>
					</div>
					<div class="col-sm-6">
						<input type="submit" class="btn btn-block pinkcolor" id="submit" value="Login">		
					</div>					
				</div>
			</div>
		</form>
		<div class="m-b-20"></div>
		<div class="text-center">
			<span class="m-r-15">Invite others</span>&nbsp;
			
			<a href="https://www.facebook.com/sharer/sharer.php?<?php echo http_build_query(['u' => $base_url]); ?>" class="m-r-15"><i class="fa fa-facebook"></i></a>&nbsp;
			<a href="https://twitter.com/home?<?php echo http_build_query(['status' => $base_url]); ?>" class="m-r-15"><i class="fa fa-twitter"></i></a>
		</div>
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
