<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>Admin dashboard</title>
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="skin-default-dark fixed-layout lock-nav">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label"> Admin dashboard </p>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <?php include('./header.php'); ?>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
       <? include 'menu.php'; ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor">Insights</h4>
                    </div>

                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
				<div class="row">
					<div class="col-lg-6">
					 <div class="card card-body">
                            <h5 class="card-title">Total Participants In Shaghaf Program</h5>
                            <div class="row">
                                <div class="col-12 ">
                                    <h1 class="text-inverse">920</h1>
                                    <p class="text-muted">Applicants</p>
                                </div>

                            </div>
                        </div>
					</div>
					<div class="col-lg-6">
					 <div class="card card-body">
                            <h5 class="card-title">Avg. Participants Age</h5>
                            <div class="row">
                                <div class="col-12 ">
                                    <h1 class="text-inverse">23.5</h1>
                                    <p class="text-muted">Years Old</p>
                                </div>

                            </div>
                        </div>
					</div>
				</div>
				<div class="row">
                    <!-- Column -->
                    
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3">
                        <div class="card card-body">
                            <h5 class="card-title">Avg. Work Experince</h5>
                            <div class="row">
                                <div class="col-12 ">
                                    <h1 class="text-inverse">3.5</h1>
                                    <p class="text-muted">Years</p>
                                </div>

                            </div>
                        </div>
                    </div>
					
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3">
                        <div class="card card-body">
                            <h5 class="card-title">Have a Bachelor’s degree</h5>
                            <div class="row">
                                <div class="col-12 ">
                                    <h1 class="text-inverse">120</h1>
                                    <p class="text-muted">Applicants</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3">
                        <div class="card card-body">
                            <h5 class="card-title">Have a Graduate degree</h5>
                            <div class="row">
                                <div class="col-12 ">
                                    <h1 class="text-inverse">20</h1>
                                    <p class="text-muted">Applicants</p>
                                </div>
                            </div>
                        </div>
                    </div>
					 <div class="col-lg-3">
                        <div class="card card-body">
                            <h5 class="card-title">Applicants with Awards</h5>
                            <div class="row">
                                <div class="col-12 ">
                                    <h1 class="text-inverse">20</h1>
                                    <p class="text-muted">Applicants</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
				
                <div class="row">

                    <!-- column -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Participation By Region</h4>
                                <div>
                                    <canvas id="pie-chart-region" height="150"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- column -->
                    <!-- column -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Participation By Gender</h4>
                                <div>
                                    <canvas id="pie-chart-gender" height="150"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- column -->
                    <!-- column -->
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="../assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../assets/node_modules/popper/popper.min.js"></script>
    <script src="../assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="dist/js/perfect-scrollbar.jquery.min.js"></script>
    <!--Wave Effects -->
    <script src="dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="dist/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="../assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="../assets/node_modules/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="dist/js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!-- Chart JS -->
    
    <script src="../assets/node_modules/Chart.js/Chart.min.js"></script>
	<script>
	$(function () {
    "use strict";
	// Bar chart
	
	// New chart
	new Chart(document.getElementById("pie-chart-gender"), {
		type: 'pie',
		data: {
            datasets: [{
                data: [70, 30],
                backgroundColor: ['#198b95', '#db396d']
            }],
            labels: ['male' , 'female']
        },
		options: {
				 legend: {
            display: true,
			position:'bottom',	
            labels: {
                fontColor: 'rgb(0, 0, 0)', boxWidth:10,fontSize:7
            }
        },
		  title: {
			display: true,
			text: ''
		  }
		}
	});
		new Chart(document.getElementById("pie-chart-region"), {
		type: 'doughnut',
		data: {
            datasets: [{
                data: [70, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30],
                backgroundColor: ['#198b95', '#db396d','#208b95','#120b95','#192095','#198b20','#19cc95','#cc8b95','#ff8b95','#19aa95','#dd8b95','#1eeb95','#130b95']
            }],
            labels: ['Riyadh','Makkah','Madinah','Qassim','Eastern Region','Asir','Tabuk','Hail','The Northern Border','Jazan','Najran','Al Baha','Al Jouf']
        },
		options: {
			
			 legend: {
            display: true,
			position:'bottom',	
            labels: {
                fontColor: 'rgb(0, 0, 0)', boxWidth:10,fontSize:7
            }
        },
		  title: {
			 
			display: true,
			text: ''
		  }
		}
	});	

 
}); 
	</script>
</body>

</html>