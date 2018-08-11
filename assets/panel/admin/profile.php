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
    <link href="dist/css/custom.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
	<style>
		.customtab li a.nav-link, .profile-tab li a.nav-link{padding: 20px 14px;}
	</style>
</head>

<body class="skin-default-dark fixed-layout lock-nav">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Participant dashboard </p>
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
                        <h4 class="text-themecolor">Profile</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            
                            <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Update Application</button>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-3 col-xlg-2 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <center class="m-t-10"> <img src="../assets/images/users/5.jpg" class="img-circle" width="75" /><br><br>
                                    <h4 class="card-title">User Full Name</h4>
									<small>Submission Date: 02/02/2018</small>
                                   
                                </center>
							 
								 
                            </div>
							<hr>
							<div class="card-body">
							<h4 class="card-title"><small>Form Status:&nbsp;<span class="badge badge-pill badge-primary">Uncompleted</span></small></h4>
								<div class="progress">
<div class="progress-bar bg-success" role="progressbar" style="width: 75%;height:15px;" role="progressbar"> 75% </div>
</div>
								
								 
								
							</div>
							<hr>
							<div class="card-body">
							<h4 class="card-title">
									<small>Application Edit Status:</small></h4>
								<div class="form-group">
                                      
                                            <select class="custom-select col-12" id="inlineFormCustomSelect">
                                                <option selected="">Open</option>
                                                <option value="1">Closed</option>
                                                
                                            </select>
                                       
                                    </div>
							</div>
							<hr>
							<div class="card-body">
								<h4 class="card-title">
									<small>Application Status:</small></h4>
								<div class="form-group">
                                      
                                            <select class="custom-select col-12" id="inlineFormCustomSelect">
                                                <option selected="">Approved</option>
                                                <option value="1">Rejected</option>
                                                <option value="2">In Review</option>
												 <option value="3">Reviewed</option>
                                              
                                            </select>
                                       
                                    </div>
							</div>
							 <hr>
                            <div>
                               
								<div class="card-body">
							<div class="row">
											<div class="col-lg-12">The uploaded CV by the applicant<br><br><div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu">
                                              
                                                <a class="dropdown-item" href="javascript:void(0)">View</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="javascript:void(0)">Delete</a>
                                            </div>
                                        </div></div>
										 
										</div>
								</div>
							
							</div>
                            
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-9 col-xlg-10 col-md-8">
                        <div class="card">
                            <!-- Nav tabs -->
<ul class="nav nav-tabs profile-tab" role="tablist">
<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#comments" role="tab">Comments</a> </li>
<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#personal" role="tab">Personal  </a> </li>
<li class="nav-item"> <a class="nav-link " data-toggle="tab" href="#education" role="tab">Education </a> </li>
<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#workexp" role="tab">Work</a> </li>
<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#activity" role="tab">Activities</a> </li>
<li class="nav-item"> <a class="nav-link " data-toggle="tab" href="#qa" role="tab">Q &amp; A</a> </li>
<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#awards" role="tab">Awards</a> </li>
<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#jobpref" role="tab">Job Pref.</a> </li>
<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#ref" role="tab">Refrences</a> </li>
 
</ul>
                            <!-- Tab panes -->
							
                            <div class="tab-content">
								 <div class="tab-pane active" id="comments" role="tabpanel">
                                    <div class="card-body">
										<h4 class="card-title"><small>Write down your comment on this application:</small></h4>
										<div class="form-group">
											<textarea rows="3" class="form-control"></textarea>
										</div>
										<div class="form-group">
										<input class="btn btn-block btn-primary" type="button" value="Submit your comment"/>
										</div>
										<hr>
										<h4 class="card-title"><small>All Comments For this Application:</small></h4>
									 <div class="profiletimeline">
                                        
                                            <div class="sl-item">
                                                <div class="sl-left"> <img src="../assets/images/users/4.jpg" alt="user" class="img-circle"> </div>
                                                <div class="sl-right">
                                                    <div><a href="javascript:void(0)" class="link">John Doe</a> <span class="sl-date">5 minutes ago</span>
                                                        <blockquote class="m-t-10">
                                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt
                                                        </blockquote>
                                                    </div>
                                                </div>
                                            </div>
										 <hr>
										    <div class="sl-item">
                                                <div class="sl-left"> <img src="../assets/images/users/4.jpg" alt="user" class="img-circle"> </div>
                                                <div class="sl-right">
                                                    <div><a href="javascript:void(0)" class="link">John Doe</a> <span class="sl-date">5 minutes ago</span>
                                                        <blockquote class="m-t-10">
                                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt
                                                        </blockquote>
                                                    </div>
                                                </div>
                                            </div>
										 
                                        </div>

							

							
                                </div>
								</div>
                                <div class="tab-pane " id="education" role="tabpanel">
                                    <div class="card-body">
                                        <div class="row">
											<div class="col-lg-12">
											<div class="form-group">
								<label for="highest_qualification">Highest Acedemic Qualificatoin</label>
								<input type="text" class="form-control" id="highest_qualification" name="highest_qualification" placeholder="Highest Acedemic Qualificatoin" value="Bachelor">
							</div>
											</div>
                                    </div>
										 
										<div class="row">
											<div class="col-lg-4">	<div class="form-group">
								<label for="bachelor_degree">Bachelor's Degree</label>
								<input type="text" class="form-control" id="bachelor_degree" name="bachelor_degree" placeholder="Bachelor's Degree" value="English language and litrature">
							</div></div>
											<div class="col-lg-4">
												<div class="form-group">
								<label for="bachelor_university">Bachelor's University Name</label>
								<input type="text" class="form-control" id="bachelor_university" name="bachelor_university" placeholder="Bachelor's University Name" value="Qassim university">
							</div>
											</div>
											<div class="col-lg-4">
											<div class="form-group">
								<label for="bachelor_university_address">University Location</label>
								<input type="text" class="form-control" id="bachelor_university_address" name="bachelor_university_address" placeholder="University Location" value="alrass">
							</div>
											</div>
										</div>
										 
										<div class="row">
											<div class="col-lg-4"><div class="form-group">
								<label for="bachelor_enrollment">Period of enrollment</label>
								<input type="text" class="form-control" id="bachelor_enrollment" name="bachelor_enrollment" placeholder="mm/yyyy - mm/yyyy, or present" value="09/2010 - 06/2015">
							</div></div>
											<div class="col-lg-4">	<div class="form-group">
								<label for="bachelor_major">Bachelor's Major (& Minor)</label>
								<input type="text" class="form-control" id="bachelor_major" name="bachelor_major" placeholder="Bachelor's Major (& Minor)" value="English language and literature ">
							</div></div>
											<div class="col-lg-4"><div class="form-group">
								<label for="bachelor_gpa">Bachelor's final GPA</label>
								<input type="text" class="form-control" id="bachelor_gpa" name="bachelor_gpa" placeholder="Bachelor's final GPA" value="3,90">
							</div></div>
										</div>
										 
										<div class="row">
											<div class="col-lg-12"><div class="form-group">
								<label for="undergraduate_ranking">Undergraduate Final Year Student Ranking</label>
								<input type="text" class="form-control" id="undergraduate_ranking" name="undergraduate_ranking" placeholder="Ranking" value="">
							</div></div>
                                    </div>
										<hr>
										
										<div class="row">
											<div class="col-lg-12"><div class="form-group">
								<label for="graduate_degree">Graduate Degree</label>
								<input type="text" class="form-control" id="graduate_degree" name="graduate_degree" placeholder="Graduate Degree" value="">
							</div></div>
										</div>
										<div class="row">
											<div class="col-lg-4"><div class="form-group">
								<label for="graduate_university">Graduate University Name</label>
								<input type="text" class="form-control" id="graduate_university" name="graduate_university" placeholder="Graduate University Name" value="">
							</div></div>
											<div class="col-lg-4"><div class="form-group">
								<label for="graduate_university_address">University Location</label>
								<input type="text" class="form-control" id="graduate_university_address" name="graduate_university_address" placeholder="University Location" value="">
							</div></div>
											<div class="col-lg-4"><div class="form-group">
								<label for="graduate_enrollment">Period of enrollment</label>
								<input type="text" class="form-control" id="graduate_enrollment" name="graduate_enrollment" placeholder="mm/yyyy - mm/yyyy, or present" value="">
							</div></div>
										</div>
										<div class="row">
											<div class="col-lg-6"><div class="form-group">
								<label for="graduate_major">Graduate Emphasis</label>
								<input type="text" class="form-control" id="graduate_major" name="graduate_major" placeholder="Graduate Emphasis" value="">
							</div></div>
											<div class="col-lg-6"><div class="form-group">
								<label for="graduate_gpa">Graduate final GPA</label>
								<input type="text" class="form-control" id="graduate_gpa" name="graduate_gpa" placeholder="Graduate final GPA" value="">
							</div></div>
											 
										</div>
										<div class="row">
											<div class="col-lg-12"><div class="form-group">
								<label for="graduate_ranking">Graduate Final Year Student Ranking</label>
								<input type="text" class="form-control" id="graduate_ranking" name="graduate_ranking" placeholder="Ranking" value="">
							</div></div>
										</div>
										
										<hr>
										
										<div class="row">
											<div class="col-lg-12"><div class="form-group">
								<label for="highschool_name">High School Name</label>
								<input type="text" class="form-control" id="highschool_name" name="highschool_name" placeholder="High School Name" value="first high school">
							</div></div>
										</div>
										<div class="row">
											<div class="col-lg-6"><div class="form-group">
								<label for="highschool_gpa">High School GPA</label>
								<input type="text" class="form-control" id="highschool_gpa" name="highschool_gpa" placeholder="High School GPA" value="96%">
							</div></div>
											<div class="col-lg-6"><div class="form-group">
								<label for="highschool_ranking">High School Final Year Ranking</label>
								<input type="text" class="form-control" id="highschool_ranking" name="highschool_ranking" placeholder="High School Final Year Ranking" value="97%">
							</div></div>
										</div>

							

							
                                </div>
								</div>
								
								<div class="tab-pane" id="personal" role="tabpanel">
								<div class="card-body"> 
								 
									<div class="row">
										<div class="col-lg-4"><div class="form-group">
								<label for="first_name">First name<span class="astk">*</span></label>
								<input type="text" class="form-control" id="first_name" name="first_name" placeholder="First name" value="fatemah">
							</div></div>
										<div class="col-lg-4"><div class="form-group">
								<label for="middle_name">Middle name<span class="astk">*</span></label>
								<input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Middle name" value="khaled">
							</div></div>
										<div class="col-lg-4"><div class="form-group">
								<label for="last_name">Last name<span class="astk">*</span></label>
								<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last name" value="Alhawas">
							</div></div>
									</div>
							
									<div class="row">
										<div class="col-lg-4"><div class="form-group">
								<label for="dob">Birth Date<span class="astk">*</span></label>
								<input type="text" class="form-control" id="dob" name="dob" placeholder="Birth Date (D/M/YY)" value="18/01/1993" aria-required="true" aria-invalid="false">
							</div></div>
										<div class="col-lg-4"><div class="form-group">
								<label for="gender">Gender<span class="astk">*</span></label>
								<select class="form-control" id="gender" name="gender">
									<option value="Male">Male</option>
									<option value="Female" selected="">Female</option>
								</select>
							</div></div>
										<div class="col-lg-4"><div class="form-group">
								<label for="email">Email Address<span class="astk">*</span></label>
								<input type="text" class="form-control" id="email" name="email" placeholder="Email Address" value="d0o0ome@hotmail.com">
							</div></div>
									</div>
							
									<div class="row">
										<div class="col-lg-4"><div class="form-group">
								<label for="phone">Phone number<span class="astk">*</span></label>
								<input type="text" class="form-control" id="phone" name="phone" placeholder="Phone number" value="0569442330">
							</div></div>
										<div class="col-lg-4"><div class="form-group">
								<label for="address">Mailing Address<span class="astk">*</span></label>
								<input type="text" class="form-control" id="address" name="address" placeholder="Mailing Address" value="51921">
							</div></div>
										<div class="col-lg-4"><div class="form-group">
								<label for="city">City of Residence<span class="astk">*</span></label>
								<input type="text" class="form-control" id="city" name="city" placeholder="City of Residence" value="Alrass">
							</div></div>
									</div>
							

							

							

							

							

							

							

					 
                            </div>
								</div>
									 
                                <div class="tab-pane" id="workexp" role="tabpanel">
                                    <div class="card-body">
										<div class="row">
											<div class="col-lg-6"><div class="form-group">
								<label for="work">Number of years of work experience if applicable:</label>
								<input type="text" class="form-control" id="work" name="work" placeholder="Years" value="3">
							</div></div>
											<div class="col-lg-6"><div class="form-group">
								<label for="work_area">What is your main area of expertise?:</label>
								<input type="text" class="form-control" id="work_area" name="work_area" placeholder="Area of expertise" value="managerial ">
							</div></div>
										</div>
										<hr>
										<h4>Experience Timeline</h4>
										<br>
										
										
										<div class="card">
                            
                              <div class="card-body">
                                <div class="row">
												<div class="col-lg-4">
													 
													<div class="form-group">
														<label>Employment Period</label>
													<input type="text" class="form-control" id="work_period_0" value="9/1/2012" name="work_period_0">
													</div>
												</div>
												<div class="col-lg-4">
													<div class="form-group">
												<label>Company / Orgnisation</label>
													<input type="text" class="form-control" id="work_company_0" value="alber charity in alrass ( montada alrefag program) " name="work_company_0">
													</div>
												</div>
												<div class="col-lg-4">
													<div class="form-group">
													<label>Location <small>(City, Country)</small></label>
													<input type="text" class="form-control" id="work_location_0" value="Qassim , Alrass" name="work_location_0">
													</div>
												</div>
											</div>
								  
										<div class="row">
										<div class="col-lg-12">
											
											 
										 
													<div class="form-group">
													<label>Key Responsibilities</label>
													<textarea type="text" class="form-control" id="work_responsibility_1" value="" name="work_responsibility_1"></textarea>
											</div>
											</div>
										</div>
                              </div>
                            </div>
										
										 <hr>
										<div class="card">
                            
                              <div class="card-body">
                                <div class="row">
												<div class="col-lg-4">
													 
													<div class="form-group">
														<label>Employment Period</label>
													<input type="text" class="form-control" id="work_period_0" value="9/1/2012" name="work_period_0">
													</div>
												</div>
												<div class="col-lg-4">
													<div class="form-group">
												<label>Company / Orgnisation</label>
													<input type="text" class="form-control" id="work_company_0" value="alber charity in alrass ( montada alrefag program) " name="work_company_0">
													</div>
												</div>
												<div class="col-lg-4">
													<div class="form-group">
													<label>Location <small>(City, Country)</small></label>
													<input type="text" class="form-control" id="work_location_0" value="Qassim , Alrass" name="work_location_0">
													</div>
												</div>
											</div>
								  
										<div class="row">
										<div class="col-lg-12">
											
											 
										 
													<div class="form-group">
													<label>Key Responsibilities</label>
													<textarea type="text" class="form-control" id="work_responsibility_1" value="" name="work_responsibility_1"></textarea>
											</div>
											</div>
										</div>
                              </div>
                            </div>
										<hr>
										 
										<div class="card">
                            
                              <div class="card-body">
                                <div class="row">
												<div class="col-lg-4">
													 
													<div class="form-group">
														<label>Employment Period</label>
													<input type="text" class="form-control" id="work_period_0" value="9/1/2012" name="work_period_0">
													</div>
												</div>
												<div class="col-lg-4">
													<div class="form-group">
												<label>Company / Orgnisation</label>
													<input type="text" class="form-control" id="work_company_0" value="alber charity in alrass ( montada alrefag program) " name="work_company_0">
													</div>
												</div>
												<div class="col-lg-4">
													<div class="form-group">
													<label>Location <small>(City, Country)</small></label>
													<input type="text" class="form-control" id="work_location_0" value="Qassim , Alrass" name="work_location_0">
													</div>
												</div>
											</div>
								  
										<div class="row">
										<div class="col-lg-12">
											
											 
										 
													<div class="form-group">
													<label>Key Responsibilities</label>
													<textarea type="text" class="form-control" id="work_responsibility_1" value="" name="work_responsibility_1"></textarea>
											</div>
											</div>
										</div>
                              </div>
                            </div>
										<hr>
										 
										<div class="card">
                            
                              <div class="card-body">
                                <div class="row">
												<div class="col-lg-4">
													 
													<div class="form-group">
														<label>Employment Period</label>
													<input type="text" class="form-control" id="work_period_0" value="9/1/2012" name="work_period_0">
													</div>
												</div>
												<div class="col-lg-4">
													<div class="form-group">
												<label>Company / Orgnisation</label>
													<input type="text" class="form-control" id="work_company_0" value="alber charity in alrass ( montada alrefag program) " name="work_company_0">
													</div>
												</div>
												<div class="col-lg-4">
													<div class="form-group">
													<label>Location <small>(City, Country)</small></label>
													<input type="text" class="form-control" id="work_location_0" value="Qassim , Alrass" name="work_location_0">
													</div>
												</div>
											</div>
								  
										<div class="row">
										<div class="col-lg-12">
											
											 
										 
													<div class="form-group">
													<label>Key Responsibilities</label>
													<textarea type="text" class="form-control" id="work_responsibility_1" value="" name="work_responsibility_1"></textarea>
											</div>
											</div>
										</div>
                              </div>
                            </div>
									 
										 
											</div>
								</div>
								<div class="tab-pane" id="activity" role="tabpanel">
                                    <div class="card-body">
                                      <div class="table-responsive">
								<table class="table table-striped table-hover">
									<thead>
										<tr>
											<th>Period of Employment</th>
											<th>Volunteering/Extra-curricular</th>
											<th>Location (City, Country)</th>
											<th>Key Responsibilities</th>
										</tr>
									</thead>
									<tbody>
																				<tr>
											<td><input type="text" class="form-control" id="extra_period_0" value="2015" name="extra_period_0"></td>
											<td><input type="text" class="form-control" id="extra_extra_0" value="courses' supervisor " name="extra_extra_0"></td>
											<td><input type="text" class="form-control" id="extra_location_0" value="Alrass" name="extra_location_0"></td>
											<td><input type="text" class="form-control" id="extra_responsibility_0" value="to prepare courses" name="extra_responsibility_0"></td>
										</tr>
																				<tr>
											<td><input type="text" class="form-control" id="extra_period_1" value="2012 - 2013" name="extra_period_1"></td>
											<td><input type="text" class="form-control" id="extra_extra_1" value="instractor " name="extra_extra_1"></td>
											<td><input type="text" class="form-control" id="extra_location_1" value="Alrass" name="extra_location_1"></td>
											<td><input type="text" class="form-control" id="extra_responsibility_1" value="to taking care of students between age 16 - 18 and giving them so many skills " name="extra_responsibility_1"></td>
										</tr>
																				<tr>
											<td><input type="text" class="form-control" id="extra_period_2" value="2009 -2010 - 2011 - 2013 - 2014 " name="extra_period_2"></td>
											<td><input type="text" class="form-control" id="extra_extra_2" value="alqassim Bazar (five years )" name="extra_extra_2"></td>
											<td><input type="text" class="form-control" id="extra_location_2" value="Alrass" name="extra_location_2"></td>
											<td><input type="text" class="form-control" id="extra_responsibility_2" value="- Second Bazar : as a volunteer in the organizing committee - Third Bazar : as a volunteer in the printing workshop. - Fourth and Fifth Bazar : as a volunteer in Public Relations -and Media department. - Sixth Bazar : to define about Montad Alrefag ." name="extra_responsibility_2"></td>
										</tr>
																				<tr>
											<td><input type="text" class="form-control" id="extra_period_3" value="" name="extra_period_3"></td>
											<td><input type="text" class="form-control" id="extra_extra_3" value="" name="extra_extra_3"></td>
											<td><input type="text" class="form-control" id="extra_location_3" value="" name="extra_location_3"></td>
											<td><input type="text" class="form-control" id="extra_responsibility_3" value="" name="extra_responsibility_3"></td>
										</tr>
																			</tbody>
								</table>
							</div>
                                    </div>
                                </div>
								<div class="tab-pane" id="qa" role="tabpanel">
									<div class="card-body">
							<div class="form-group">
								<label for="qna_trigger">What triggers your interest to apply for Shaghaf Program?<span class="astk">*</span></label>
								<textarea class="form-control" id="qna_trigger" name="qna_trigger" placeholder="">trying new experience to be my best self </textarea>
							</div>

							<div class="form-group">
								<label for="qna_priority">What are your top priorities in life, what do you want to achieve (bucket list/dream)?<span class="astk">*</span></label>
								<textarea class="form-control" id="qna_priority" name="qna_priority" placeholder="">I Want to achieve my best: self , family, relationships , practical life , and society which they are my priorities </textarea>
							</div>

							<div class="form-group">
								<label for="qna_achievement">What do you consider your greatest achievement so far?<span class="astk">*</span></label>
								<textarea class="form-control" id="qna_achievement" name="qna_achievement" placeholder="">to be the youngest and the most successful leader in my charity   </textarea>
							</div>

							<div class="form-group">
								<label for="qna_role_model">Who is your role model? and why?<span class="astk">*</span></label>
								<textarea class="form-control" id="qna_role_model" name="qna_role_model" placeholder="">as Muslim my role model is prophet Muhammad 
I'm trying to learn from others OF COURSE ,but no role model in my life so this is my charisma</textarea>
							</div>

							<div class="form-group">
								<label for="qna_hobbies">What are your hobbies or talents? <span class="astk">*</span></label>
								<textarea class="form-control" id="qna_hobbies" name="qna_hobbies" placeholder="">planing , leadership , organizing </textarea>
							</div>

							<div class="form-group">
								<label for="qna_passion">What are you most passionate about?<span class="astk">*</span></label>
								<textarea class="form-control" id="qna_passion" name="qna_passion" placeholder="">leading work teams </textarea>
							</div>

							<div class="form-group">
								<label for="qna_contribute">How do you think you can contribute to the non-profit organizations that you would join to make a positive change in the sector?<span class="astk">*</span></label>
								<textarea class="form-control" id="qna_contribute" name="qna_contribute" placeholder="">by changing  IDEAS </textarea>
							</div>

							<div class="form-group">
								<label for="qna_wand">
									If you were given a magic wand, how would you use it to change an issue at:<br>
									a.	At a personal level? <br>
									b.	At a global level? <br>
									Please answer with a maximum of 300 words in total.
								<span class="astk">*</span></label>
								<textarea class="form-control" id="qna_wand" name="qna_wand" placeholder="">a. I see that we have abilities and power which overcome magic to change at least ourselves
b. ending wars , poverty , diseases , unawareness</textarea>
							</div>

									</div>
								</div>
								<div class="tab-pane" id="awards" role="tabpanel">
									<div class="card-body">
									<div class="form-group">
								<label for="awards">
									Please use this area to tell us about any significant awards or recognitions that you have received in the last 3 years (i.e., prizes, honors, other fellowships, etc.).  You can say 'none' if this does not apply. 
								</label>
								<textarea class="form-control" id="awards" name="awards" placeholder=""></textarea>
							</div>
									</div>
								</div>
								<div class="tab-pane" id="jobpref" role="tabpanel">
								<div class="card-body">
									<div class="table-responsive">
								<table class="table table-striped table-hover">
									<tbody>

										<tr>
											<td>First Preference</td>
											<td>
												<select name="first_preference" id="first_preference" class="form-control">
													<option value="">-- Select --</option>
																										<option value="Education & Training" selected>Education & Training</option>
																										<option value="Programs Design" >Programs Design</option>
																										<option value="Strategic partnerships" >Strategic partnerships</option>
																										<option value="Fundraising and events" >Fundraising and events</option>
																										<option value="Human Resources" >Human Resources</option>
																										<option value="Supporting services" >Supporting services</option>
																										<option value="Awareness & Event Planning" >Awareness & Event Planning</option>
																										<option value="Public Relations & Social Media" >Public Relations & Social Media</option>
																										<option value="Accountant" >Accountant</option>
																										<option value="Social Work" >Social Work</option>
																									</select>
											</td>
										</tr>
										
										<tr>
											<td>Second Preference</td>
											<td>
												<select name="second_preference" id="second_preference" class="form-control">
													<option value="">-- Select --</option>
																										<option value="Education & Training" >Education & Training</option>
																										<option value="Programs Design" >Programs Design</option>
																										<option value="Strategic partnerships" >Strategic partnerships</option>
																										<option value="Fundraising and events" >Fundraising and events</option>
																										<option value="Human Resources" >Human Resources</option>
																										<option value="Supporting services" >Supporting services</option>
																										<option value="Awareness & Event Planning" selected>Awareness & Event Planning</option>
																										<option value="Public Relations & Social Media" >Public Relations & Social Media</option>
																										<option value="Accountant" >Accountant</option>
																										<option value="Social Work" >Social Work</option>
																									</select>
											</td>
										</tr>	

										<tr>
											<td>Third Preference</td>
											<td>
												<select name="third_preference" id="third_preference" class="form-control">
													<option value="">-- Select --</option>
																										<option value="Education & Training" >Education & Training</option>
																										<option value="Programs Design" >Programs Design</option>
																										<option value="Strategic partnerships" >Strategic partnerships</option>
																										<option value="Fundraising and events" >Fundraising and events</option>
																										<option value="Human Resources" >Human Resources</option>
																										<option value="Supporting services" >Supporting services</option>
																										<option value="Awareness & Event Planning" >Awareness & Event Planning</option>
																										<option value="Public Relations & Social Media" >Public Relations & Social Media</option>
																										<option value="Accountant" >Accountant</option>
																										<option value="Social Work" selected>Social Work</option>
																									</select>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
								</div>
								</div>
								<div class="tab-pane" id="ref" role="tabpanel">
									<div class="card-body">
									<div class="row">
								<div class="col-sm-6">
									
									<h4>Reference # 1</h4>	
									<div class="form-group">
										<label for="contact_name_1">Name<span class="astk">*</span></label>
										<input class="form-control" id="contact_name_1" name="contact_name_1" placeholder="" value="ghadeer Alalwi">
									</div>

									<div class="form-group">
										<label for="contact_title_1">Title<span class="astk">*</span></label>
										<input class="form-control" id="contact_title_1" name="contact_title_1" placeholder="" value="Supervisor of the investments programs In Alber Chairty">
									</div>

									<div class="form-group">
										<label for="contact_organization_1">Organization<span class="astk">*</span></label>
										<input class="form-control" id="contact_organization_1" name="contact_organization_1" placeholder="" value="Alber charity in Alrass">
									</div>

									<div class="form-group">
										<label for="contact_email_1">Email Address<span class="astk">*</span></label>
										<input class="form-control" id="contact_email_1" name="contact_email_1" placeholder="" value="Gmfh3@hotmail.com">
									</div>

									<div class="form-group">
										<label for="contact_phone_1">Phone Number<span class="astk">*</span></label>
										<input class="form-control" id="contact_phone_1" name="contact_phone_1" placeholder="" value="+966565280378">
									</div>

									<div class="form-group">
										<label for="contact_relationship_1">Relationship<span class="astk">*</span></label>
										<input class="form-control" id="contact_relationship_1" name="contact_relationship_1" placeholder="" value="supervisor ">
									</div>

								</div>
								<div class="col-sm-6">
									
									<h4>Reference # 2</h4>
									<div class="form-group">
										<label for="contact_name_2">Name<span class="astk">*</span></label>
										<input class="form-control" id="contact_name_2" name="contact_name_2" placeholder="" value="Rawan Alonizan">
									</div>

									<div class="form-group">
										<label for="contact_title_2">Title<span class="astk">*</span></label>
										<input class="form-control" id="contact_title_2" name="contact_title_2" placeholder="" value="principal for Alrass international school ">
									</div>

									<div class="form-group">
										<label for="contact_organization_2">Organization<span class="astk">*</span></label>
										<input class="form-control" id="contact_organization_2" name="contact_organization_2" placeholder="" value="Alrass international school">
									</div>

									<div class="form-group">
										<label for="contact_email_2">Email Address<span class="astk">*</span></label>
										<input class="form-control" id="contact_email_2" name="contact_email_2" placeholder="" value="-">
									</div>

									<div class="form-group">
										<label for="contact_phone_2">Phone Number<span class="astk">*</span></label>
										<input class="form-control" id="contact_phone_2" name="contact_phone_2" placeholder="" value="+96655837707">
									</div>

									<div class="form-group">
										<label for="contact_relationship_2">Relationship<span class="astk">*</span></label>
										<input class="form-control" id="contact_relationship_2" name="contact_relationship_2" placeholder="" value="supervisor ">
									</div>

								</div>
							</div>
										 
									</div>
								</div>
								 
                                    </div>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>
                        <div class="r-panel-body">
                            <ul id="themecolors" class="m-t-20">
                                <li><b>With Light sidebar</b></li>
                                <li><a href="javascript:void(0)" data-skin="skin-default" class="default-theme">1</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-green" class="green-theme">2</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-red" class="red-theme">3</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-blue" class="blue-theme">4</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-purple" class="purple-theme">5</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-megna" class="megna-theme">6</a></li>
                                <li class="d-block m-t-30"><b>With Dark sidebar</b></li>
                                <li><a href="javascript:void(0)" data-skin="skin-default-dark" class="default-dark-theme">7</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-green-dark" class="green-dark-theme">8</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-red-dark" class="red-dark-theme working">9</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-blue-dark" class="blue-dark-theme">10</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-purple-dark" class="purple-dark-theme">11</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-megna-dark" class="megna-dark-theme ">12</a></li>
                            </ul>
                            <ul class="m-t-20 chatonline">
                                <li><b>Chat option</b></li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/1.jpg" alt="user-img" class="img-circle"> <span>Varun Dhavan <small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/2.jpg" alt="user-img" class="img-circle"> <span>Genelia Deshmukh <small class="text-warning">Away</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/3.jpg" alt="user-img" class="img-circle"> <span>Ritesh Deshmukh <small class="text-danger">Busy</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/4.jpg" alt="user-img" class="img-circle"> <span>Arijit Sinh <small class="text-muted">Offline</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/5.jpg" alt="user-img" class="img-circle"> <span>Govinda Star <small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/6.jpg" alt="user-img" class="img-circle"> <span>John Abraham<small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/7.jpg" alt="user-img" class="img-circle"> <span>Hritik Roshan<small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/8.jpg" alt="user-img" class="img-circle"> <span>Pwandeep rajan <small class="text-success">online</small></span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
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
	
	  <script src="../assets/node_modules/footable/js/footable.all.min.js"></script>
    <!--FooTable init-->
	<script>
	 
			 $( document ).ready(function() {
       $('#demo-foo-accordion').footable().on('footable_row_expanded', function(e) {
		$('#demo-foo-accordion tbody tr.footable-detail-show').not(e.row).each(function() {
			$('#demo-foo-accordion').data('footable').toggleDetail(this);
		});
	});
    });
			
		 
 
	</script>
    
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!-- Chart JS -->
</body>

</html>