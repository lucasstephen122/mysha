<div class="row green">
	<div class="col-sm-12">
		<h3 class="text-center">Forgot password?</h3>
	</div>
	<div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-12">
		<div class="m-b-20"></div>
		<p class="text-center">Please enter your email address to reset password</p>
		<form id="frm_forgot_password" name="frm_forgot_password" action="<?php echo $base_url ?>user/do_forgot_password" method="POST">
			<?php show_error_message(); ?>
			<div class="form-group">
				<label for="email">Email address</label>
				<input type="email" class="form-control" id="email" name="email" placeholder="Email">
			</div>
			<div class="form-group">
				<div class="row row-pad">
					<div class="col-sm-12">
						<input type="submit" class="btn btn-block pinkcolor" id="submit" value="Resend Password">		
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
	init_forgot_password();
});

function init_forgot_password()
{
	var $frm_forgot_password = $('#frm_forgot_password');

	$frm_forgot_password.validate(
	{
		rules:
		{
			email:
			{
				required: true,
				maxlength: 50,
				email: true
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
		},

		submitHandler: function (form)
		{
			form[0].submit();
		}
	});

}
</script>
