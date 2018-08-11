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
                            <h1 class="text-inverse"><?php echo $count_all; ?></h1>
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
                            <h1 class="text-inverse"><?php echo round($avg_age , 2); ?></h1>
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
                            <h1 class="text-inverse"><?php echo round($avg_work , 2); ?></h1>
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
                            <h1 class="text-inverse"><?php echo $count_bachelor_degree; ?></h1>
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
                            <h1 class="text-inverse"><?php echo $count_graduate_degree; ?></h1>
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
                            <h1 class="text-inverse"><?php echo $count_awards; ?></h1>
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
                            <canvas id="pie-chart-region" height="400"></canvas>
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

<script src="<?php echo $base_url; ?>assets/panel/admin/../assets/node_modules/Chart.js/Chart.min.js"></script>
<script>
    $(function () {
    "use strict";
    
        // New chart
        new Chart(document.getElementById("pie-chart-gender"), {
            type: 'pie',
            data: {
                datasets: [{
                    data: [<?php echo $count_male ?>, <?php echo $count_female; ?>],
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
                    data: <?php echo json_encode($regions_icount) ?>,
                    backgroundColor: <?php echo json_encode($regions_icolor) ?>
                }],
                labels: <?php echo json_encode($regions_iname); ?>
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