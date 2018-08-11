<div class="row">
	<div class="col-lg-12" style="padding:0px;">
		<div class="slider">
			<div><img src="<?php echo $base_url; ?>assets/images/1.jpg" /></div>
			<div><img src="<?php echo $base_url; ?>assets/images/2.jpg" /></div>
			<div><img src="<?php echo $base_url; ?>assets/images/3.jpg" /></div>
		</div>
	</div>

	<div class="col-lg-12" style="padding:0px">
		<div class="about green">
			<h3>About The Program</h3>
			<p>A non-profit fellowship program under the name “Shaghaf” brought to you by King Khalid Foundation and the Bill and Melinda Gates Foundation, to support the effectiveness of the NPO sector in the Kingdom of Saudi Arabia for the short and long term, as well as to improve the level of services provided by orgnizations to their community. </p>
		</div>
	</div>

	<div class="col-lg-12 green"  style="padding:0px">
<div class="row">
<div class="col-lg-12">
<br><br>
<h2>Dear Shaghaf Applicant,</h2>
 <p>
We are pleased to see your interest in joining Shaghaf program, and would like to announce that the application period has ended. If you have already applied and finished your application (100%), you should be expecting a call from us by the 30th of May for the selected applicants to enter the interview phase.
 </p>
All the best,
Shaghaf Team
<br><br>
</div>
</div>
		<div class="row" style="display:none;">
			<div class="col-lg-6">
				<div class="login">
					<h3>Login Area</h3>
					
					<form id="frm_signin" name="frm_signin" action="<?php echo $base_url ?>user/do_signin" method="POST">
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
				</div>
			</div>
			<div class="col-lg-6">
				<?php /* ?>
				<div class="time">
					<h3>Sign up will start after :</h3>
					<div class="clock"></div>
				</div>
				<?php /**/ ?>
				<div class="signup">
					<h3>Want to Join?</h3>
					<div class="m-b-20"></div>
					<p>This is a program targeting a specific number of saudi candidate, if you would like be part of it, start by checking your eligibility by click on start now</p>
					<div class="m-b-20"></div>
					<a href="<?php echo $base_url; ?>user/signup" class="btn btn-block pinkcolor">Start Now</a>
				</div>
			</div>
		</div>
		
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function()
	{
		$(".slider").owlCarousel({ items:1,autoplay:true});
	});
</script>

<script type="text/javascript">
	$(document).ready(function(e) 
	{
		var currentDate = new Date();
		var target = new Date('April 10, 2016');
		var diff = target-(currentDate.getTime() / 1000);
		var clock = $('.clock').FlipClock(target, 
		{
			clockFace: 'DailyCounter',
			countdown: true,
			showSeconds:false
		});
	});
</script>