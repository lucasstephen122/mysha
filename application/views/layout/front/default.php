<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<title>:: Shaghaf ::</title>
		
		<link rel="stylesheet" href="<?php echo $base_url; ?>assets/assets/bootstrap-3.3.6/dist/css/bootstrap.css">
		<link rel="stylesheet" href="<?php echo $base_url; ?>assets/assets/bootstrap-3.3.6/dist/css/bootstrap-theme.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

		<link rel="stylesheet" href="<?php echo $base_url; ?>assets/assets/slider/owl.carousel.css">
		<link rel="stylesheet" href="<?php echo $base_url; ?>assets/assets/flipclock/flipclock.css">
		<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/app.css">
		
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="<?php echo $base_url; ?>assets/assets/bootstrap-3.3.6/dist/js/bootstrap.js"></script>
		<script src="<?php echo $base_url; ?>assets/assets/slider/owl.carousel.min.js"></script>
		<script src="<?php echo $base_url; ?>assets/assets/flipclock/flipclock.min.js"></script>
		<script src="<?php echo $base_url; ?>assets/plugins/jquery-validation/js/jquery.validate.min.js"></script>
		<script src="<?php echo $base_url; ?>assets/plugins/jquery-validation/js/additional-methods.min.js"></script>

		<script src="<?php echo $base_url; ?>assets/plugins/owl.carousel/owl.carousel.js"></script>
		<link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/owl.carousel/assets/owl.carousel.css">
		<link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/owl.carousel/assets/owl.theme.default.css">
		
		<script src="<?php echo $base_url; ?>assets/plugins/uploader/js/vendor/jquery.ui.widget.js"></script>
		<script src="<?php echo $base_url; ?>assets/plugins/uploader/js/jquery.iframe-transport.js"></script>
		<script src="<?php echo $base_url; ?>assets/plugins/uploader/js/jquery.fileupload.js"></script>
		<link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/uploader/css/jquery.fileupload-ui.css" rel="stylesheet"/>

		<script src="<?php echo $base_url; ?>assets/js/ib-functions.js"></script>
		<script src="<?php echo $base_url; ?>assets/js/ib-global.js"></script>
		<script src="<?php echo $base_url; ?>assets/js/ib-ui.js"></script>
		<script src="<?php echo $base_url; ?>assets/js/util.js"></script>
		<script src="<?php echo $base_url; ?>assets/js/uploader.js"></script>

	</head>
	<body>
		<script type="text/javascript" language="javascript">

		var g = {
		base_url : '<?php echo $base_url; ?>'
		};

		</script>

		<div class="container" style="padding:0px; margin:0px auto;">
			
			<div class="row header">
				<div class="col-xs-6">
					<div class="leftlogo">
						<img src="<?php echo $base_url; ?>assets/images/kkflogo.jpg" class="img-responsive" />
					</div>
				</div>
				<div class="col-xs-6">
					<div class="rightlogo">
						<img src="<?php echo $base_url; ?>assets/images/shaghaflogo.png"  class="img-responsive"/>
					</div>
				</div>
			</div>

			<div class="row green margin-menu">
				<div class="col-xs-12">
					<div class="menu">
						<ul class="list-inline">
							<li><a href="<?php echo $base_url; ?>" class="<?php echo $menu == 'index' ? 'active' : ''; ?>">HOME</a></li>
							<li><a href="http://www.kkf.org.sa/ar/ProgramsAndGrants/Programs/CBForNPOs/Shaghaf/Pages/default.aspx" >ABOUT</a></li>
							<li><a href="<?php echo $base_url; ?>faq" class="<?php echo $menu == 'faq' ? 'active' : ''; ?>">FAQ</a></li>
						</ul>
					</div>
				</div>
			</div>

			<?php echo $layout_content; ?>

			<div class="row">
				<div class="col-lg-12 green">
					<div class="footer">
						Copyright &copy; King Khalid Foundation and Bill and Melinda Gates Foundation 2016 All rights reserved
					</div>
				</div>
			</div>
		</div>	

	</body>
</html>