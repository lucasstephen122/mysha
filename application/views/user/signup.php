<div class="row green">
	<div class="col-sm-12">
		<h3 class="text-center">Please provide us with you basic information to start the eligibility check</h3>
	</div>
	<div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-12">
		<div class="m-b-20"></div>
		<form id="frm_signup" name="frm_signup" action="<?php echo $base_url ?>user/do_signup" method="POST">
			<?php show_error_message(); ?>
			<div class="form-group">
				<label for="name">Full name</label>
				<input type="text" class="form-control" id="name" name="name" placeholder="Full name">
			</div>
			<div class="form-group">
				<label for="email">Email address</label>
				<input type="email" class="form-control" id="email" name="email" placeholder="Email">
			</div>
			<div class="form-group">
				<label for="phone">Mobile number</label>
				<input type="text" class="form-control" id="phone" name="phone" placeholder="Mobile number">
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-block pinkcolor" id="submit" value="Start">
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function()
{
	init_signup();
});

function init_signup()
{
	var $frm_signup = $('#frm_signup');

	$frm_signup.validate(
	{
		rules:
		{
			name:
			{
				required: true,
				maxlength: 50
			},
			email:
			{
				required: true,
				maxlength: 50,
				email: true
			},
			phone:
			{
				required: true,
				maxlength: 50
			},
		},

		messages:
		{
			name:
			{
				required: "Name is required",
				maxlength: "Name should not exceed 50 characters"
			},
			email:
			{
				required: "Email is required",
				maxlength: "Email should not exceed 50 characters",
				email: "Invalid email address"
			},
			phone:
			{
				required: "Phone is required",
				maxlength: "Phone should not exceed 50 characters"
			},
		},

		submitHandler: function (form)
		{
			console.log('here');
			form[0].submit();
		}
	});

}
</script>
