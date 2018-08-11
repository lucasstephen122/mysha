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
                            <h1 class="text-success"><?php echo $count_submitted; ?></h1>
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
                            <h1 class="text-danger"><?php echo $count_approved ?></h1>
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
                            <h1 class="text-inverse"><?php echo $count_rejected ?></h1>
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
                        <?php foreach ($comments as $comment) { ?>
                        <div class="message-box">
                            <div class="message-widget message-scroll">
                                <!-- Message -->
                                <a href="javascript:void(0)">
                                    <div class="user-img">
                                        <img src="<?php echo $comment['commenter']['photo_id'] ? $this->attachment_lib->render_url($comment['commenter']['photo_id']) : $base_url.'assets/panel/assets/images/users/nophoto.png' ?>" alt="user" class="img-circle">
                                        <span class="profile-status online pull-right"></span>
                                    </div>
                                    <div class="mail-contnet">
                                        <h5>#<?php echo $comment['auto_id']; ?></h5>
                                        <span class="mail-desc"><?php echo $comment['comment_html'] ?></span>
                                        <span class="time"><?php echo $comment['time'] ?></span>
                                    </div>
                                </a>

                                <div class="msg-reply">
                                    <a href="<?php echo $base_url ?>panel/application/view/<?php echo $comment['user_id'] ?>">
                                        <i class="fa fa-mail-reply"></i> Reply</a>
                                </div>

                            </div>
                        </div>
                        <?php } ?>
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

<!-- Chart JS -->
<script src="<?php echo $base_url; ?>assets/panel/admin/../assets/node_modules/Chart.js/Chart.min.js"></script>
    <script>    
    var ctx =  document.querySelector('#pie-chart').getContext('2d');
    var myPieChart = new Chart(ctx,{
        type: 'pie',
        data:  {
            datasets: [{
                data: [<?php echo $count_male ?>, <?php echo $count_female ?>],
                backgroundColor: ['#198b95', '#db396d']
            }],
            labels: ['male' , 'female']
        }
    });
</script>