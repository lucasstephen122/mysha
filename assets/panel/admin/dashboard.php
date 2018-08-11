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
    <title>Add new admin</title>
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <link href="dist/css/custom.css" rel="stylesheet">
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
                        <h1 class="text-themecolor">Dashboard </h1>
                    </div>

                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <!-- Column -->
                    
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-4">
                        <div class="card card-body">
                            <h5 class="card-title">Pending Participants</h5>
                            <div class="row">
                                <div class="col-12 ">
                                    <h1 class="text-success">920</h1>
                                    <p class="text-muted">Submissions</p>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-4">
                        <div class="card card-body">
                            <h5 class="card-title">Approved Participants</h5>
                            <div class="row">
                                <div class="col-12 ">
                                    <h1 class="text-danger">120</h1>
                                    <p class="text-muted">Submissions</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-4">
                        <div class="card card-body">
                            <h5 class="card-title">Rejected Participants </h5>
                            <div class="row">
                                <div class="col-12 ">
                                    <h1 class="text-inverse">20</h1>
                                    <p class="text-muted">Submissions</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row heading">
                                    <div class="col-lg-9">
                                        <h5 class="card-title">Insights</h5>
                                    </div>
                                    <div class="col-lg-3">
                                        <a href="insights.php" class="btn btn-block btn-primary">View All</a>
                                    </div>
                                </div>
                                <div>
                                    <canvas id="pie-chart"  class="chartjs-render-monitor" height="150"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row heading">
                                    <div class="col-lg-9">
                                        <h5 class="card-title">Broadcasts</h5>
                                    </div>
                                    <div class="col-lg-3">
                                        <a href="broadcasts.php" class="btn btn-block btn-primary">Advanced</a>
                                    </div>
                                </div>
                                <div>
                                    <form method="post" action="#" >
                                        <div class="form-group"> 
                                            <label>
                                                select your channel
                                            </label>
                                            <select class="form-control">
                                                <option value="sms"> SMS </option>
                                                <option value="email"> Email </option>
                                                <option value ="both"> Both </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label> Write your message </label>
                                            <textarea  name="your-message" class="form-control">

                                            </textarea>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" value="submit">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row heading">
                                    <div class="col-lg-9">
                                        <h5 class="card-title">Recent Updates</h5>
                                    </div>
                                    <div class="col-lg-3">
                                        <button class="btn btn-block btn-primary">View All</button>
                                    </div>
                                </div>
                                <div class="message-box">
                                    <div class="message-widget message-scroll">
                                        <!-- Message -->
                                        <a href="javascript:void(0)">
                                            <div class="user-img">
                                                <img src="../assets/images/users/1.jpg" alt="user" class="img-circle">
                                                <span class="profile-status online pull-right"></span>
                                            </div>
                                            <div class="mail-contnet">
                                                <h5>#1220</h5>
                                                <span class="mail-desc">Lorem Ipsum is simply dummy text of the printing and type setting industry.
                                                    Lorem Ipsum has been.</span>
                                                <span class="time">9:30 AM</span>
                                            </div>
                                        </a>

                                        <div class="msg-reply">
                                            <a href="#">
                                                <i class="fa fa-mail-reply"></i> Reply</a>
                                        </div>

                                    </div>
                                </div>
                                <div class="message-box">
                                    <div class="message-widget message-scroll">
                                        <!-- Message -->
                                        <a href="javascript:void(0)">
                                            <div class="user-img">
                                                <img src="../assets/images/users/1.jpg" alt="user" class="img-circle">
                                                <span class="profile-status online pull-right"></span>
                                            </div>
                                            <div class="mail-contnet">
                                                <h5>#1220</h5>
                                                <span class="mail-desc">Lorem Ipsum is simply dummy text of the printing and type setting industry.
                                                    Lorem Ipsum has been.</span>
                                                <span class="time">9:30 AM</span>
                                            </div>
                                        </a>

                                        <div class="msg-reply">
                                            <a href="#">
                                                <i class="fa fa-mail-reply"></i> Reply</a>
                                        </div>

                                    </div>
                                </div>
                                <div class="message-box">
                                    <div class="message-widget message-scroll">
                                        <!-- Message -->
                                        <a href="javascript:void(0)">
                                            <div class="user-img">
                                                <img src="../assets/images/users/1.jpg" alt="user" class="img-circle">
                                                <span class="profile-status online pull-right"></span>
                                            </div>
                                            <div class="mail-contnet">
                                                <h5>#1220</h5>
                                                <span class="mail-desc">Lorem Ipsum is simply dummy text of the printing and type setting industry.
                                                    Lorem Ipsum has been.</span>
                                                <span class="time">9:30 AM</span>
                                            </div>
                                        </a>

                                        <div class="msg-reply">
                                            <a href="#">
                                                <i class="fa fa-mail-reply"></i> Reply</a>
                                        </div>

                                    </div>
                                </div>
                                <div class="message-box">
                                    <div class="message-widget message-scroll">
                                        <!-- Message -->
                                        <a href="javascript:void(0)">
                                            <div class="user-img">
                                                <img src="../assets/images/users/1.jpg" alt="user" class="img-circle">
                                                <span class="profile-status online pull-right"></span>
                                            </div>
                                            <div class="mail-contnet">
                                                <h5>#1220</h5>
                                                <span class="mail-desc">Lorem Ipsum is simply dummy text of the printing and type setting industry.
                                                    Lorem Ipsum has been.</span>
                                                <span class="time">9:30 AM</span>
                                            </div>
                                        </a>

                                        <div class="msg-reply">
                                            <a href="#">
                                                <i class="fa fa-mail-reply"></i> Reply</a>
                                        </div>

                                    </div>
                                </div>
                                <div class="message-box">
                                    <div class="message-widget message-scroll">
                                        <!-- Message -->
                                        <a href="javascript:void(0)">
                                            <div class="user-img">
                                                <img src="../assets/images/users/1.jpg" alt="user" class="img-circle">
                                                <span class="profile-status online pull-right"></span>
                                            </div>
                                            <div class="mail-contnet">
                                                <h5>#1220</h5>
                                                <span class="mail-desc">Lorem Ipsum is simply dummy text of the printing and type setting industry.
                                                    Lorem Ipsum has been.</span>
                                                <span class="time">9:30 AM</span>
                                            </div>
                                        </a>

                                        <div class="msg-reply">
                                            <a href="#">
                                                <i class="fa fa-mail-reply"></i> Reply</a>
                                        </div>

                                    </div>
                                </div>
                                <div class="message-box">
                                    <div class="message-widget message-scroll">
                                        <!-- Message -->
                                        <a href="javascript:void(0)">
                                            <div class="user-img">
                                                <img src="../assets/images/users/1.jpg" alt="user" class="img-circle">
                                                <span class="profile-status online pull-right"></span>
                                            </div>
                                            <div class="mail-contnet">
                                                <h5>#1220</h5>
                                                <span class="mail-desc">Lorem Ipsum is simply dummy text of the printing and type setting industry.
                                                    Lorem Ipsum has been.</span>
                                                <span class="time">9:30 AM</span>
                                            </div>
                                        </a>

                                        <div class="msg-reply">
                                            <a href="#">
                                                <i class="fa fa-mail-reply"></i> Reply</a>
                                        </div>

                                    </div>
                                </div>
                                <div class="message-box">
                                    <div class="message-widget message-scroll">
                                        <!-- Message -->
                                        <a href="javascript:void(0)">
                                            <div class="user-img">
                                                <img src="../assets/images/users/1.jpg" alt="user" class="img-circle">
                                                <span class="profile-status online pull-right"></span>
                                            </div>
                                            <div class="mail-contnet">
                                                <h5>#1220</h5>
                                                <span class="mail-desc">Lorem Ipsum is simply dummy text of the printing and type setting industry.
                                                    Lorem Ipsum has been.</span>
                                                <span class="time">9:30 AM</span>
                                            </div>
                                        </a>

                                        <div class="msg-reply">
                                            <a href="#">
                                                <i class="fa fa-mail-reply"></i> Reply</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
      var ctx =  document.querySelector('#pie-chart').getContext('2d');
    var myPieChart = new Chart(ctx,{
        type: 'pie',
        data:  {
            datasets: [{
                data: [70, 30],
                backgroundColor: ['#198b95', '#db396d']
            }],
            labels: ['male' , 'female']
        }
    });
    </script>
    <!-- =================  ============================================= -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
</body>

</html>