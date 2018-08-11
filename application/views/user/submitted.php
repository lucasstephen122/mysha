<div class="row green">
	<div class="col-sm-12">
		<h2 class="text-center">Thank you</h2>
	</div>
	<div class="col-sm-12">
		<div class="row">
			<div class="col-md-6">
				<h1 class="m-v-0">Welcome,</h1>
				<h3 class="m-v-0"><?php echo $user['name']; ?> &nbsp; <a href="<?php echo $base_url; ?>user/signout" class="">(logout)</a></h3>
				<div class="m-b-20"></div>

				<div class="progress">
					<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $user['progress'] ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $user['progress'] ?>%">
						<span class="sr-only"><?php echo $user['progress'] ?>% Complete</span>
					</div>
				</div>
				<p><?php echo $user['progress'] ?>% Complete</p>
			</div>
		</div>
		
	</div>
	<div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-12">		
		<div class="m-b-20"></div>
		<h3 class="text-center">Your Application Under Review - We Will Contact You Soon</h3>
		<div class="m-b-20"></div>
		<div class="text-center">
			<span class="m-r-15">Invite friends</span>&nbsp;
			<a href="https://www.facebook.com/sharer/sharer.php?<?php echo http_build_query(['u' => $base_url]); ?>" class="m-r-15"><i class="fa fa-facebook"></i></a>&nbsp;
			<a href="https://twitter.com/home?<?php echo http_build_query(['status' => $base_url]); ?>" class="m-r-15"><i class="fa fa-twitter"></i></a>
		</div>
	</div>
</div>
