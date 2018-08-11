<?php 
	$application = $user['application']; 
?>
<style>
	.hidden{
		display:none;
	}
	.description{
		padding-top:10px;
		padding-bottom:10px;
		border-bottom:1px solid #ccc;
		margin-bottom:10px;
	}
	.description .title{
		font-size:20px;
		font-weight:bold;
		margin-bottom:10px;
	}
</style>
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
    	<?php 
    		if($type == 'admin') {
    			$url = $base_url.'panel/application/update/'.$user['user_id'];
    		} else {
    			$url = $base_url.'user/update';
    		}
    	?>
        <form id="frm_application" name="frm_application" action="<?php echo $url ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="user_id" id="user_id" value="<?php echo $user['user_id']; ?>">
		<input type="hidden" name="status" id="status" value="<?php echo $application['status']; ?>">
		<input type="hidden" name="required_fields" id="required_fields" value=""/>

        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Profile</h4>
            </div>
            <?php if($type == 'admin') { ?>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <button type="submit" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Update Application</button>
                </div>
            </div>
            <?php } ?>
			<?php if($type == 'user' && $user['status_edit'] == 'open') { ?>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
	                <button type="submit" id="btn_draft" name="draft" class="btn btn-default d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Save as Draft</button>
                    <button type="submit" id="btn_submit" name="submitted" class="btn btn-info d-none d-lg-block m-l-15" <?= getRemainingSeconds($user) <= 0 ? 'disabled' : '' ?>><i class="fa fa-plus-circle"></i> Submit</button>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php show_success_message(); ?>
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
                        <center class="m-t-10"> <img src="<?php echo $application['photo_id'] ? $this->attachment_library->render_url($application['photo_id']) : $base_url.'assets/panel/assets/images/users/nophoto.png'; ?>" class="img-circle" style="cursor:pointer" width="75" id="profile_picture" /><br><br>
                            <h4 class="card-title"><?php echo $user['first_name'] ?> <?php echo $user['middle_name'] ?> <?php echo $user['last_name'] ?></h4>
							<small>Submission Date: <?php echo format_date($user['created_on']) ?></small>
                           
                        </center>
					 
						 
                    </div>
					<hr>
					<div class="card-body">
					<h4 class="card-title"><small>Form Status:&nbsp;<span class="badge badge-pill badge-<?php echo $user['progress'] == 100 ? 'success' : 'primary' ?>"><?php echo $user['progress'] == 100 ? 'Completed' : 'Uncompleted' ?></span></small></h4>
						<div class="progress">
							<div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $user['progress']; ?>%;height:15px;" role="progressbar"> <?php echo $user['progress']; ?>% </div>
						</div>
					</div>
					<hr>
					<div class="card-body">
						<h4 class="card-title">
							<small>Current Application Edit Status:</small>
						</h4>
						<div class="form-group">
							<b><?php echo ucwords($user['status_edit']) ?></b>
						</div>	
						<?php if($type == 'admin') { ?>
						<h4 class="card-title">
							<small>Change Application Edit Status:</small>
						</h4>
						<div class="form-group">
                            <select class="custom-select col-12" id="status_edit" name="status_edit">
                                <option value="open" <?php echo $user['status_edit'] == 'open' ? 'selected' : '' ?>>Open</option>
                                <option value="closed" <?php echo $user['status_edit'] == 'closed' ? 'selected' : '' ?>>Closed</option>
                            </select>
                        </div>
                        <?php } ?>
					</div>
					<hr>
					<div class="card-body">
						<h4 class="card-title">
							<small>Current Application Status:</small>
						</h4>
						<div class="form-group">
							<b><?php echo ucwords($user['status']) ?></b>
						</div>	
						<?php if($type == 'admin') { ?>
						<h4 class="card-title">
							<small>Change Application Status:</small>
						</h4>
						<div class="form-group">
                      		<?php if($this->app_library->is_role_session('admin')) { ?>
                            <select class="custom-select col-12" id="status" name="status">
                            	<option value="">- Change Status -</option>
                            	<option value="draft" <?php echo $user['status'] == 'draft' ? 'selected' : '' ?>>Draft</option>
                                <option value="submitted" <?php echo $user['status'] == 'submitted' ? 'selected' : '' ?>>Submitted</option>
                                <option value="reviewed" <?php echo $user['status'] == 'reviewed' ? 'selected' : '' ?>>Reviewed</option>
                                <option value="approved" <?php echo $user['status'] == 'approved' ? 'selected' : '' ?>>Approved</option>
                                <option value="rejected" <?php echo $user['status'] == 'rejected' ? 'selected' : '' ?>>Rejected</option>
                            </select>
                            <?php } ?>
                            <?php if($this->app_library->is_role_session('reviewer')) { ?>
                            <select class="custom-select col-12" id="status" name="status">
                            	<option value="">- Change Status -</option>
                            	<option value="draft" <?php echo $user['status'] == 'draft' ? 'selected' : '' ?>>Draft</option>
                                <option value="submitted" <?php echo $user['status'] == 'submitted' ? 'selected' : '' ?>>Submitted</option>
                                <option value="reviewed" <?php echo $user['status'] == 'reviewed' ? 'selected' : '' ?>>Reviewed</option>
                            </select>
                            <?php } ?>

                            <?php if($this->app_library->is_role_session('approver')) { ?>
                            <select class="custom-select col-12" id="status" name="status">
                            	<option value="">- Change Status -</option>
                                <option value="approved" <?php echo $user['status'] == 'approved' ? 'selected' : '' ?>>Approved</option>
                                <option value="rejected" <?php echo $user['status'] == 'rejected' ? 'selected' : '' ?>>Rejected</option>
                            </select>
                            <?php } ?>
                   		</div>
                   		<?php } ?>
					</div>
					<hr>
					<div>
					<div class="card-body">
						<h4 class="card-title">
							<small>End Date:</small>
						</h4>
						<input name="end_date" value="<?=date('Y-m-d H:i', strtotime($user['end_date']))?>" class="form-control" id="end_date"/>
					</div>
                       
						<div class="card-body">
							<div class="row">
								<div class="col-lg-12">
									<div class="btn-group">
	                                    <div class="file-uploader-outer" style='display:none'>
	                                    	<?php if($type == 'admin' || ($type == 'user' && $user['status_edit'] == 'open')) { ?>
		                                    <a href="javascript:;"  class="btn btn-primary thumbnail file-thumbnail-text file-uploader" id="lnk_photo" data-module="CV">Upload Photo
		                                        <input type="hidden" id="photo_id" name="photo_id" value="<?php echo $application['photo_id']; ?>">
		                                    </a>
		                                    <br/>
		                                    <div class="clearfix"></div>
		                                    <br/>
		                                    <?php } ?>
		                                    <a class="download" style="padding: 0;" href="<?php echo $this->attachment_library->download_url($application['photo_id']); ?>"><?php echo $this->attachment_library->get_name($application['photo_id']); ?></a>
		                                    <div class="clearfix"></div>
		                                </div>
	                                </div>
                            	</div>
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
					<!-- <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#comments" role="tab">Comments</a> </li> -->
					<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#personal" role="tab">Personal  </a> </li>
					<li class="nav-item"> <a class="nav-link " data-toggle="tab" href="#education" role="tab">Education </a> </li>
					<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#workexp" role="tab">Work</a> </li>
					<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#activity" role="tab">Activities</a> </li>	
					<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#awards" role="tab">Awards</a> </li>
					<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#jobpref" role="tab">Job Pref.</a> </li>
					<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#ref" role="tab">Refrences</a> </li>
					<li class="nav-item"> <a class="nav-link " data-toggle="tab" href="#qa" role="tab">Q &amp; A</a> </li>

					</ul>
                    <!-- Tab panes -->
					
                    <div class="tab-content">
						 <div class="tab-pane" id="comments" role="tabpanel">
                            <div class="card-body">
                            	<?php if($type == 'admin' || ($type == 'user' && $user['status_edit'] == 'open')) { ?>
								<h4 class="card-title"><small>Write down your comment on this application:</small></h4>
								<div class="form-group">
									<textarea rows="3" class="form-control" name="comment" id="comment"></textarea>
								</div>
								<?php if($this->app_library->is_role_session('reviewer')) { ?>
								<div class="form-group">
									<input type="checkbox" name="public" id="public" value="Y"> Share this comment with user
								</div>
								<?php } ?>
								<div class="form-group">
								<input class="btn btn-block btn-primary" type="button" id="btn_comment" value="Submit your comment"/>
								</div>
								<hr>
								<?php } ?>
								<h4 class="card-title"><small>All Comments For this Application:</small></h4>
							 	<div class="profiletimeline" id="cnt_comments">

                                </div>

                                <div style="display: none">
                                	<div id="cnt_comment">
	                                	<div class="sl-item">
	                                        <div class="sl-left"> <img src="" alt="user" class="img-circle commenter_photo"> </div>
	                                        <div class="sl-right">
	                                            <div><a href="javascript:void(0)" class="link commenter"></a> <span class="sl-date comment_on"></span>
	                                                <blockquote class="m-t-10 comment">
	                                                </blockquote>
	                                            </div>
	                                        </div>
	                                    </div>
	                                    <hr>
	                                </div> 
                                </div>
					
                        </div>
						</div>
                        <div class="tab-pane " id="education" role="tabpanel">
                            <div class="card-body">
								<div class='description'>
									<div class='title'>
										This is Desc panel
									</div>
									<div class='content'>
										This is personal desc panel , in this section you need to enter these data to system be able to register you.
									</div>
								</div>
                                <div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="education_country">Country*</label>
											<select id="education_country" class='form-control' name="education_country">
												<?php foreach($countries as $country):?>
													<option value="<?=$country['id']?>" <?php echo $application["education_country"]==$country['id']?"selected":"" ?> ><?=$country['name']?></option>
												<?php endforeach?>
											</select>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="highest_qualification">Highest Acedemic Qualificatoin</label>
											<input type="text" class="form-control" id="highest_qualification" name="highest_qualification" placeholder="Highest Acedemic Qualificatoin" value="<?php echo $application['highest_qualification'] ?>">
										</div>
									</div>
                            	</div>
								 
								<div class="row">
									<div class="col-lg-4">	
										<div class="form-group">
											<label for="bachelor_degree">Bachelor's Degree</label>
											<input type="text" class="form-control" id="bachelor_degree" name="bachelor_degree" placeholder="Bachelor's Degree" value="<?php echo $application['bachelor_degree'] ?>">
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label for="bachelor_university_id">Bachelor's University</label>
											<select id="bachelor_university_id" class='form-control' name="bachelor_university_id">
												<option value='0'></option>
												<?php foreach($universities as $university):?>
													<option value="<?=$university['id']?>" <?php echo $application["bachelor_university_id"]==$university['id']?"selected":"" ?> ><?=$university['name']?></option>
												<?php endforeach?>
												<option value='-1' <?php echo $application["bachelor_university_id"]==-1 ? "selected":"" ?> >Input Manually</option>
											</select>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group <?php echo $application["bachelor_university_id"] != -1 ?'hidden':''?>" id="bachelor_university_container">
												<label for="bachelor_university">Bachelor's University Name</label>
												<input type="text" class="form-control" id="bachelor_university" name="bachelor_university" placeholder="Bachelor's University Name" value="<?php echo $application['bachelor_university'] ?>">
										</div>
									</div>
								</div>
								 
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group">
											<label for="bachelor_university_address">University Location</label>
											<input type="text" class="form-control" id="bachelor_university_address" name="bachelor_university_address" placeholder="University Location" value="<?php echo $application['bachelor_university_address'] ?>">
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label for="bachelor_enrollment">Period of enrollment</label>
											<input type="text" class="form-control"  id="bachelor_enrollment" name="bachelor_enrollment" placeholder="mm/yyyy - mm/yyyy, or present" value="<?php echo $application['bachelor_enrollment'] ?>">
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label for="bachelor_major">Bachelor's Major (& Minor)</label>
											<input type="text" class="form-control" id="bachelor_major" name="bachelor_major" placeholder="Bachelor's Major (& Minor)" value="<?php echo $application['bachelor_major'] ?>">
										</div>
									</div>
									
								</div>
								 
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="bachelor_gpa">Bachelor's final GPA</label>
											<input type="text" class="form-control" id="bachelor_gpa" name="bachelor_gpa" placeholder="Bachelor's final GPA" value="<?php echo $application['bachelor_gpa'] ?>">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="undergraduate_ranking">Undergraduate Final Year Student Ranking</label>
											<input type="text" class="form-control" id="undergraduate_ranking" name="undergraduate_ranking" placeholder="Ranking" value="<?php echo $application['undergraduate_ranking'] ?>">
										</div>
									</div>
								</div>
								
								<hr>
								
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<label for="graduate_degree">Graduate Degree</label>
											<input type="text" class="form-control" id="graduate_degree" name="graduate_degree" placeholder="Graduate Degree" value="<?php echo $application['graduate_degree'] ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group">
											<label for="graduate_university_id">Graduate University</label>
											<select id="graduate_university_id" class='form-control' name="graduate_university_id">
												<option value='0'></option>
												<?php foreach($universities as $university):?>
													<option value="<?=$university['id']?>" <?php echo $application["graduate_university_id"]==$university['id']?"selected":"" ?> ><?=$university['name']?></option>
												<?php endforeach?>
												<option value="-1" <?php echo $application["graduate_university_id"]==-1 ? "selected":"" ?>>Input Manually</option>
											</select>
										</div>
									</div>
									<div class="col-lg-4 <?php echo $application["graduate_university_id"] != -1 ?'hidden':''?>" id="graduate_university_container">
										<div class="form-group" id="graduate_university_container">
											<label for="graduate_university">Graduate University Name</label>
											<input type="text" class="form-control" id="graduate_university" name="graduate_university" placeholder="Graduate University Name" value="<?php echo $application['graduate_university'] ?>">
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label for="graduate_university_address">University Location</label>
											<input type="text" class="form-control" id="graduate_university_address" name="graduate_university_address" placeholder="University Location" value="<?php echo $application['graduate_university_address'] ?>">
										</div>
									</div>
									
								</div>
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group">
											<label for="graduate_enrollment">Period of enrollment</label>
											<input type="text" class="form-control date-range" id="graduate_enrollment" name="graduate_enrollment" placeholder="mm/yyyy - mm/yyyy, or present" value="<?php echo $application['graduate_enrollment'] ?>">
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label for="graduate_major">Graduate Emphasis</label>
											<input type="text" class="form-control" id="graduate_major" name="graduate_major" placeholder="Graduate Emphasis" value="<?php echo $application['graduate_major'] ?>">
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label for="graduate_gpa">Graduate final GPA</label>
											<input type="text" class="form-control" id="graduate_gpa" name="graduate_gpa" placeholder="Graduate final GPA" value="<?php echo $application['graduate_gpa'] ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<label for="graduate_ranking">Graduate Final Year Student Ranking</label>
											<input type="text" class="form-control" id="graduate_ranking" name="graduate_ranking" placeholder="Ranking" value="<?php echo $application['graduate_ranking'] ?>">
										</div>
									</div>
								</div>
                        </div>
						</div>
						
						<div class="tab-pane active" id="personal" role="tabpanel">
						<div class="card-body"> 
							<div class='description'>
								<div class='title'>
									This is Desc panel
								</div>
								<div class='content'>
									This is personal desc panel , in this section you need to enter these data to system be able to register you.
								</div>
							</div>
							<div class="row">
								<div class="col-lg-4">
									<div class="form-group">
										<label for="first_name">First name</label>
										<input type="text" class="form-control" id="first_name" name="first_name" placeholder="First name" value="<?php echo $user['first_name'] ?>">
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<label for="middle_name">Middle name</label>
										<input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Middle name" value="<?php echo $user['middle_name'] ?>">
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<label for="last_name">Last name</label>
										<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last name" value="<?php echo $user['last_name'] ?>">
									</div>
								</div>
							</div>
					
							<div class="row">
								<div class="col-lg-4">
									<div class="form-group">
										<label for="dob">Birth Date</label>
										<input type="text" class="form-control" id="dob" name="dob" placeholder="Birth Date (D/M/YY)" value="<?php echo $user['dob'] ?>" aria-required="true" aria-invalid="false">
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<label for="gender">Gender</label>
										<select class="form-control" id="gender" name="gender">
											<option value="Male" <?php echo $user['gender'] == "Male" ? 'selected' : '' ?>>Male</option>
											<option value="Female" <?php echo $user['gender'] == "Female" ? 'selected' : '' ?>>Female</option>
										</select>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<label for="email">Email Address</label>
										<input type="text" class="form-control" id="email" name="email" placeholder="Email Address" value="<?php echo $user['email'] ?>">
									</div>
								</div>
							</div>
					
							<div class="row">
								<div class="col-lg-4">
									<div class="form-group">
										<label for="phone">Phone number</label>
										<input type="text" class="form-control" id="phone" name="phone" placeholder="Phone number" value="<?php echo $user['phone'] ?>">
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<label for="address">Mailing Address</label>
										<input type="text" class="form-control" id="address" name="address" placeholder="Mailing Address" value="<?php echo $user['address'] ?>">
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<label for="city">City of Residence</label>
										
										<select class="form-control" name="city" id="city">
											<option value="">- Select City -</option>
											<option value="Abhā" <?php echo $user['city'] == "Abhā" ? 'selected' : ''; ?> >Abhā</option>
											<option value="Abqaiq" <?php echo $user['city'] == "Abqaiq" ? 'selected' : ''; ?> >Abqaiq</option>
											<option value="Al-Baḥah" <?php echo $user['city'] == "Al-Baḥah" ? 'selected' : ''; ?> >Al-Baḥah</option>
											<option value="Al-Dammām" <?php echo $user['city'] == "Al-Dammām" ? 'selected' : ''; ?> >Al-Dammām</option>
											<option value="Al-Hufūf" <?php echo $user['city'] == "Al-Hufūf" ? 'selected' : ''; ?> >Al-Hufūf</option>
											<option value="Al-Jawf" <?php echo $user['city'] == "Al-Jawf" ? 'selected' : ''; ?> >Al-Jawf</option>
											<option value="Al-Kharj (oasis)" <?php echo $user['city'] == "Al-Kharj (oasis)" ? 'selected' : ''; ?> >Al-Kharj (oasis)</option>
											<option value="Al-Khubar" <?php echo $user['city'] == "Al-Khubar" ? 'selected' : ''; ?> >Al-Khubar</option>
											<option value="Al-Qaṭīf" <?php echo $user['city'] == "Al-Qaṭīf" ? 'selected' : ''; ?> >Al-Qaṭīf</option>
											<option value="Al-Ṭaʾif" <?php echo $user['city'] == "Al-Ṭaʾif" ? 'selected' : ''; ?> >Al-Ṭaʾif</option>
											<option value="ʿArʿar" <?php echo $user['city'] == "ʿArʿar" ? 'selected' : ''; ?> >ʿArʿar</option>
											<option value="Buraydah" <?php echo $user['city'] == "Buraydah" ? 'selected' : ''; ?> >Buraydah</option>
											<option value="Dhahran" <?php echo $user['city'] == "Dhahran" ? 'selected' : ''; ?> >Dhahran</option>
											<option value="Ḥāʾil" <?php echo $user['city'] == "Ḥāʾil" ? 'selected' : ''; ?> >Ḥāʾil</option>
											<option value="Jiddah" <?php echo $user['city'] == "Jiddah" ? 'selected' : ''; ?> >Jiddah</option>
											<option value="Jīzān" <?php echo $user['city'] == "Jīzān" ? 'selected' : ''; ?> >Jīzān</option>
											<option value="Khamīs Mushayt" <?php echo $user['city'] == "Khamīs Mushayt" ? 'selected' : ''; ?> >Khamīs Mushayt</option>
											<option value="King Khalīd Military City" <?php echo $user['city'] == "King Khalīd Military City" ? 'selected' : ''; ?> >King Khalīd Military City</option>
											<option value="Mecca" <?php echo $user['city'] == "Mecca" ? 'selected' : ''; ?> >Mecca</option>
											<option value="Medina" <?php echo $user['city'] == "Medina" ? 'selected' : ''; ?> >Medina</option>
											<option value="Najrān" <?php echo $user['city'] == "Najrān" ? 'selected' : ''; ?> >Najrān</option>
											<option value="Ras Tanura" <?php echo $user['city'] == "Ras Tanura" ? 'selected' : ''; ?> >Ras Tanura</option>
											<option value="Riyadh" <?php echo $user['city'] == "Riyadh" ? 'selected' : ''; ?> >Riyadh</option>
											<option value="Sakākā" <?php echo $user['city'] == "Sakākā" ? 'selected' : ''; ?> >Sakākā</option>
											<option value="Tabūk" <?php echo $user['city'] == "Tabūk" ? 'selected' : ''; ?> >Tabūk</option>
											<option value="Yanbuʿ" <?php echo $user['city'] == "Yanbuʿ" ? 'selected' : ''; ?> >Yanbuʿ</option>
										</select>		
									</div>
								</div>
							</div>
					

					

					

					

					

					

					

			 
                    </div>
						</div>
							 
                        <div class="tab-pane" id="workexp" role="tabpanel">
                            <div class="card-body">
								<div class='description'>
									<div class='title'>
										This is Desc panel
									</div>
									<div class='content'>
										This is personal desc panel , in this section you need to enter these data to system be able to register you.
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="work">Number of years of work experience if applicable:</label>
											<input type="text" class="form-control" id="work" name="work" placeholder="Years" value="<?php echo $application['work'] ?>">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="work_area">What is your main area of expertise?:</label>
											<input type="text" class="form-control" id="work_area" name="work_area" placeholder="Area of expertise" value="<?php echo $application['work_area'] ?>">
										</div>
									</div>
								</div>
								<div class='cv-pane'>
									<div class="btn-group" class='pull-right'>
	                                    <div class="file-uploader-outer">
	                                    	<?php if($type == 'admin' || ($type == 'user' && $user['status_edit'] == 'open')) { ?>
		                                    <a href="javascript:;" class="btn btn-primary thumbnail file-thumbnail-text file-uploader" id="lnk_cv" data-module="CV">Upload new CV
		                                        <input type="hidden" id="cv_id" name="cv_id" value="<?php echo $application['cv_id']; ?>">
		                                    </a>
		                                    <br/>
		                                    <div class="clearfix"></div>
		                                    <br/>
		                                    <?php } ?>
		                                    <a class="download" style="padding: 0;" href="<?php echo $this->attachment_library->download_url($application['cv_id']); ?>"><?php echo $this->attachment_library->get_name($application['cv_id']); ?></a>
		                                    <div class="clearfix"></div>
		                                </div>
	                                </div>
								</div>
								<hr>
								
								<br>
								<div style='height:40px;'>	
									<?php if(($type == 'admin') || ($type == 'user' && $user['status_edit'] == 'open')): ?>
										<button type="button" id="works_new_entry" class="btn btn-info d-none d-lg-block m-l-15 pull-right"><i class="fa fa-plus-circle"></i> Add New Entry</button>
									<?php endif?>
									<h4>Experience Timeline</h4>
								</div><hr>
								<?php
									$works_indexes = explode(",",$application["works_index"]);
									if($application["works_index"] == "")$works_indexes = array();
								?>
								<div class='works_form' id="works_form">
								<?php foreach($works_indexes as $i):?>
								<div class='works'>
									<div class="card">
										<div class="card-body">
											<div class="row">
												<div class="col-lg-4">
													<div class="form-group">
														<label>Employment Period</label>
														<select class='form-control' name="work_period_<?php echo $i; ?>">
															<option value="0" <?php echo $application['work_period_'.$i]=='0'?"selected":""?> >0</option>
															<option value="1" <?php echo $application['work_period_'.$i]=='1'?"selected":""?>>1</option>
															<option value="2" <?php echo $application['work_period_'.$i]=='2'?"selected":""?>>2</option>
															<option value="3" <?php echo $application['work_period_'.$i]=='3'?"selected":""?>>3</option>
															<option value="3+" <?php echo $application['work_period_'.$i]=='3+'?"selected":""?>>3+</option>
														</select>
														</select>
													</div>
												</div>
												<div class="col-lg-4">
													<div class="form-group">
														<label>Company / Orgnisation</label>
														<input type="text" class="form-control" name="work_company_<?php echo $i; ?>" value="<?php echo $application['work_company_'.$i] ?>">
													</div>
												</div>
												<div class="col-lg-4">
													<div class="form-group">
														<?php if(($type == 'admin') || ($type == 'user' && $user['status_edit'] == 'open')): ?>
															<a  class="remove_works pull-right" data-index="<?=$i?>" onclick='removeWorks($(this))'><i class="fa fa-minus-circle" ></i></a>
														<?php endif?>
														<label>Location <small>(City, Country)</small></label>
														<input type="text" class="form-control" name="work_location_<?php echo $i; ?>" value="<?php echo $application['work_location_'.$i] ?>">
													</div>
												</div>
											</div>
							
											<div class="row">
												<div class="col-lg-12">
													<div class="form-group">
														<label>Key Responsibilities</label>
														<textarea type="text" class="form-control" name="work_responsibility_<?php echo $i; ?>"><?php echo $application['work_responsibility_'.$i] ?></textarea>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
                    			<?php endforeach ?>
								</div>
								<input type='hidden' id="works_index" name="works_index" value="<?php echo $application['works_index']; ?>">
							</div>
						</div>
						<div class="tab-pane" id="activity" role="tabpanel">
                            <div class="card-body">
								<div class='description'>
									<div class='title'>
										This is Desc panel
									</div>
									<div class='content'>
										This is personal desc panel , in this section you need to enter these data to system be able to register you.
									</div>
								</div>
                              	<div class="table-responsive">
									<div style='height:40px;'>	
										<?php if(($type == 'admin') || ($type == 'user' && $user['status_edit'] == 'open')): ?>
											<button type="button" id="activity_new_entry" class="btn btn-info d-none d-lg-block m-l-15 pull-right"><i class="fa fa-plus-circle"></i> Add New Entry</button>
										<?php endif?>
									</div>
									<?php
										$activity_indexes = explode(",",$application["activity_index"]);
										if($application["activity_index"] == "")$activity_indexes = array();
									?>
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th>Activity period</th>
												<th>Volunteering/Extra-curricular</th>
												<th>Location (City, Country)</th>
												<th>Key Responsibilities</th>
												<th style='width:50px;'></th>
											</tr>
										</thead>
										<tbody id="activity_form">
											<?php foreach($activity_indexes as $i):?>
											<tr>
												<td><input type="text" class="form-control date-range"  id="extra_period_<?php echo $i; ?>" name="extra_period_<?php echo $i; ?>" value="<?php echo $application['extra_period_'.$i] ?>"></td>
												<td><input type="text" class="form-control" id="extra_extra_<?php echo $i; ?>" name="extra_extra_<?php echo $i; ?>" value="<?php echo $application['extra_extra_'.$i] ?>"></td>
												<td><input type="text" class="form-control" id="extra_location_<?php echo $i; ?>" name="extra_location_<?php echo $i; ?>" value="<?php echo $application['extra_location_'.$i] ?>"></td>
												<td><input type="text" class="form-control" id="extra_responsibility_<?php echo $i; ?>" name="extra_responsibility_<?php echo $i; ?>" value="<?php echo $application['extra_responsibility_'.$i] ?>"></td>
												<td>
													<?php if(($type == 'admin') || ($type == 'user' && $user['status_edit'] == 'open')): ?>
														<a  class="remove_activity pull-right" data-index="<?=$i?>" onclick='removeActivity($(this))'><i class="fa fa-minus-circle" ></i></a>
													<?php endif?>
												</td>
											</tr>
											<?php endforeach ?>
										</tbody>
									</table>
									<input type='hidden' id="activity_index" name="activity_index" value="<?php echo $application['activity_index']; ?>">
								</div>
								<hr>
                            </div>
                        </div>

						<div class="tab-pane" id="qa" role="tabpanel">
							<div class="card-body">
								<div class='description'>
									<div class='title'>
										This is Desc panel
									</div>
									<div class='content'>
										This is personal desc panel , in this section you need to enter these data to system be able to register you.
									</div>
								</div>
								<div class="form-group">
									<label for="qna_trigger">What triggers your interest to apply for Shaghaf Program?</label>
									<textarea class="form-control" id="qna_trigger" name="qna_trigger" placeholder=""><?php echo $application['qna_trigger']; ?></textarea>
								</div>

								<div class="form-group">
									<label for="qna_priority">What are your top priorities in life, what do you want to achieve (bucket list/dream)?</label>
									<textarea class="form-control" id="qna_priority" name="qna_priority" placeholder=""><?php echo $application['qna_priority']; ?></textarea>
								</div>

								<div class="form-group">
									<label for="qna_achievement">What do you consider your greatest achievement so far?</label>
									<textarea class="form-control" id="qna_achievement" name="qna_achievement" placeholder=""><?php echo $application['qna_achievement']; ?></textarea>
								</div>

								<div class="form-group">
									<label for="qna_role_model">Who is your role model? and why?</label>
									<textarea class="form-control" id="qna_role_model" name="qna_role_model" placeholder=""><?php echo $application['qna_role_model']; ?></textarea>
								</div>

								<div class="form-group">
									<label for="qna_hobbies">What are your hobbies or talents? </label>
									<textarea class="form-control" id="qna_hobbies" name="qna_hobbies" placeholder=""><?php echo $application['qna_hobbies']; ?></textarea>
								</div>

								<div class="form-group">
									<label for="qna_passion">What are you most passionate about?</label>
									<textarea class="form-control" id="qna_passion" name="qna_passion" placeholder=""><?php echo $application['qna_passion']; ?></textarea>
								</div>

								<div class="form-group">
									<label for="qna_contribute">How do you think you can contribute to the non-profit organizations that you would join to make a positive change in the sector?</label>
									<textarea class="form-control" id="qna_contribute" name="qna_contribute" placeholder=""><?php echo $application['qna_contribute']; ?></textarea>
								</div>

								<div class="form-group">
									<label for="qna_wand">
										If you were given a magic wand, how would you use it to change an issue at:<br>
										a.	At a personal level? <br>
										b.	At a global level? <br>
										Please answer with a maximum of 300 words in total.
									</label>
									<textarea class="form-control" id="qna_wand" name="qna_wand" placeholder=""><?php echo $application['qna_wand'] ?></textarea>
								</div>
								<hr>
							</div>
						</div>
						<div class="tab-pane" id="awards" role="tabpanel">
							<div class="card-body">
								<div class='description'>
									<div class='title'>
										This is Desc panel
									</div>
									<div class='content'>
										This is personal desc panel , in this section you need to enter these data to system be able to register you.
									</div>
								</div>
								<div style='height:30px;'>
									<?php if(($type == 'admin') || ($type == 'user' && $user['status_edit'] == 'open')): ?>
										<button type="button" id="adwards_new_entry" class="btn btn-info d-none d-lg-block m-l-15 pull-right"><i class="fa fa-plus-circle"></i> Add New Entry</button>
									<?php endif?>
								</div><hr>
								<?php
									$adwards_indexes = explode(",",$application["adwards_index"]);
									if($application["adwards_index"] == "")$adwards_indexes = array();
								?>
								<div class='adwards_form' id="adwards_form">
									<?php foreach($adwards_indexes as $index):?>
									<div class='adwards'>
										<div class='form-group'>
											<div class="col-lg-12">
												<?php if(($type == 'admin') || ($type == 'user' && $user['status_edit'] == 'open')): ?>
													<a  class="remove_adwards pull-right" data-index="<?=$index?>" onclick='removeAdwards($(this))'><i class="fa fa-minus-circle" ></i></a>
												<?php endif?>
												<label for="adwards_title">Title</label>
												<input type='text' class='form-control'  name="adwards_title_<?=$index?>" value="<?php echo $application['adwards_title_'.$index] ?>">	
											</div>
										</div>
										<div class='form-group'>
											<div class='row'>
												<div class="col-lg-6">
													<label for="adwards_issuer">Issuer</label>
													<input type='text' class='form-control' name="adwards_issuer_<?=$index?>" value="<?php echo $application['adwards_issuer_'.$index] ?>">	
												</div>
												<div class="col-lg-6">
													<label for="adwards_title">Date</label>
													<input type="text" class="form-control datepicker" name="adwards_date_<?=$index?>" placeholder="Date (D/M/YY)"  value="<?php echo $application['adwards_date_'.$index] ?>" aria-required="true" aria-invalid="false">	
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="awards">Description</label>
											<textarea class="form-control" name="awards_<?=$index?>" placeholder=""><?php echo $application['awards_'.$index]; ?></textarea>
										</div>
										<hr>
									</div>
									<?php endforeach;?>
								</div>
								<input type='hidden' id="adwards_index" name="adwards_index" value="<?php echo $application['adwards_index']; ?>">
							</div>
						</div>
						<div class="tab-pane" id="jobpref" role="tabpanel">
							<div class="card-body">
								<div class='description'>
									<div class='title'>
										This is Desc panel
									</div>
									<div class='content'>
										This is personal desc panel , in this section you need to enter these data to system be able to register you.
									</div>
								</div>
								<div class="table-responsive">
									<table class="table table-striped table-hover">
										<tbody>
											
											<?php 
												$roles = 
												[
													"Education & Training" , 
													"Programs Design" , 
													"Strategic partnerships" , 
													"Fundraising and events" , 
													"Human Resources" , 
													"Supporting services" , 
													"Awareness & Event Planning" , 
													"Public Relations & Social Media" , 
													"Accountant" , 
													"Social Work"
												]; 
											?>

											<tr>
												<td>First Preference</td>
												<td>
													<select name="first_preference" id="first_preference" class="form-control">
														<option value="">-- Select --</option>
														<?php foreach ($roles as $role) { ?>
														<option value="<?php echo $role; ?>" <?php echo $role == $application['first_preference'] ? 'selected' : ''; ?>><?php echo $role; ?></option>
														<?php } ?>
													</select>
												</td>
											</tr>
											
											<tr>
												<td>Second Preference</td>
												<td>
													<select name="second_preference" id="second_preference" class="form-control">
														<option value="">-- Select --</option>
														<?php foreach ($roles as $role) { ?>
														<option value="<?php echo $role; ?>" <?php echo $role == $application['second_preference'] ? 'selected' : ''; ?>><?php echo $role; ?></option>
														<?php } ?>
													</select>
												</td>
											</tr>	

											<tr>
												<td>Third Preference</td>
												<td>
													<select name="third_preference" id="third_preference" class="form-control">
														<option value="">-- Select --</option>
														<?php foreach ($roles as $role) { ?>
														<option value="<?php echo $role; ?>" <?php echo $role == $application['third_preference'] ? 'selected' : ''; ?>><?php echo $role; ?></option>
														<?php } ?>
													</select>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<hr>
							</div>
						</div>
						<div class="tab-pane" id="ref" role="tabpanel">
							<div class="card-body">
							<div class='description'>
								<div class='title'>
									This is Desc panel
								</div>
								<div class='content'>
									This is personal desc panel , in this section you need to enter these data to system be able to register you.
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									
									<h4>Reference # 1</h4>	
									<div class="form-group">
										<label for="contact_name_1">Name</label>
										<input class="form-control" id="contact_name_1" name="contact_name_1" placeholder="" value="<?php echo $application['contact_name_1']; ?>">
									</div>

									<div class="form-group">
										<label for="contact_title_1">Title</label>
										<input class="form-control" id="contact_title_1" name="contact_title_1" placeholder="" value="<?php echo $application['contact_title_1']; ?>">
									</div>

									<div class="form-group">
										<label for="contact_organization_1">Organization</label>
										<input class="form-control" id="contact_organization_1" name="contact_organization_1" placeholder="" value="<?php echo $application['contact_organization_1']; ?>">
									</div>

									<div class="form-group">
										<label for="contact_email_1">Email Address</label>
										<input class="form-control" id="contact_email_1" name="contact_email_1" placeholder="" value="<?php echo $application['contact_email_1']; ?>">
									</div>

									<div class="form-group">
										<label for="contact_phone_1">Phone Number</label>
										<input class="form-control" id="contact_phone_1" name="contact_phone_1" placeholder="" value="<?php echo $application['contact_phone_1']; ?>">
									</div>

									<div class="form-group">
										<label for="contact_relationship_1">Relationship</label>
										<input class="form-control" id="contact_relationship_1" name="contact_relationship_1" placeholder="" value="<?php echo $application['contact_relationship_1']; ?>">
									</div>

								</div>
								<div class="col-sm-6">
									
									<h4>Reference # 2</h4>
									<div class="form-group">
										<label for="contact_name_2">Name</label>
										<input class="form-control" id="contact_name_2" name="contact_name_2" placeholder="" value="<?php echo $application['contact_name_2']; ?>">
									</div>

									<div class="form-group">
										<label for="contact_title_2">Title</label>
										<input class="form-control" id="contact_title_2" name="contact_title_2" placeholder="" value="<?php echo $application['contact_title_2']; ?>">
									</div>

									<div class="form-group">
										<label for="contact_organization_2">Organization</label>
										<input class="form-control" id="contact_organization_2" name="contact_organization_2" placeholder="" value="<?php echo $application['contact_organization_2']; ?>">
									</div>

									<div class="form-group">
										<label for="contact_email_2">Email Address</label>
										<input class="form-control" id="contact_email_2" name="contact_email_2" placeholder="" value="<?php echo $application['contact_email_2']; ?>">
									</div>

									<div class="form-group">
										<label for="contact_phone_2">Phone Number</label>
										<input class="form-control" id="contact_phone_2" name="contact_phone_2" placeholder="" value="<?php echo $application['contact_phone_2']; ?>">
									</div>

									<div class="form-group">
										<label for="contact_relationship_2">Relationship</label>
										<input class="form-control" id="contact_relationship_2" name="contact_relationship_2" placeholder="" value="<?php echo $application['contact_relationship_2']; ?>">
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
        </form>
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
                            <a href="javascript:void(0)"><img src="<?php echo $base_url; ?>assets/panel/admin/../assets/images/users/1.jpg" alt="user-img" class="img-circle"> <span>Varun Dhavan <small class="text-success">online</small></span></a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"><img src="<?php echo $base_url; ?>assets/panel/admin/../assets/images/users/2.jpg" alt="user-img" class="img-circle"> <span>Genelia Deshmukh <small class="text-warning">Away</small></span></a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"><img src="<?php echo $base_url; ?>assets/panel/admin/../assets/images/users/3.jpg" alt="user-img" class="img-circle"> <span>Ritesh Deshmukh <small class="text-danger">Busy</small></span></a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"><img src="<?php echo $base_url; ?>assets/panel/admin/../assets/images/users/4.jpg" alt="user-img" class="img-circle"> <span>Arijit Sinh <small class="text-muted">Offline</small></span></a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"><img src="<?php echo $base_url; ?>assets/panel/admin/../assets/images/users/5.jpg" alt="user-img" class="img-circle"> <span>Govinda Star <small class="text-success">online</small></span></a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"><img src="<?php echo $base_url; ?>assets/panel/admin/../assets/images/users/6.jpg" alt="user-img" class="img-circle"> <span>John Abraham<small class="text-success">online</small></span></a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"><img src="<?php echo $base_url; ?>assets/panel/admin/../assets/images/users/7.jpg" alt="user-img" class="img-circle"> <span>Hritik Roshan<small class="text-success">online</small></span></a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"><img src="<?php echo $base_url; ?>assets/panel/admin/../assets/images/users/8.jpg" alt="user-img" class="img-circle"> <span>Pwandeep rajan <small class="text-success">online</small></span></a>
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

<script>
	var action = 'draft'; 
	var adwards_indexes = $("#adwards_index").val();
	var adwards_indexes_array = adwards_indexes.split(",");
	if($("#adwards_index").val() == "")adwards_indexes_array = []
	function removeAdwards($obj){
		// console.log("this",obj);
		var old_index = $obj.data("index");
		var index = adwards_indexes_array.indexOf(old_index);
		if(index < 0){
			index = adwards_indexes_array.indexOf(old_index.toString());
		}
		if (index > -1) {
			adwards_indexes_array.splice(index, 1);
		}
		$("#adwards_index").val(adwards_indexes_array.join(","));
		$obj.parent().parent().parent().remove();
	}

	var works_indexes = $("#works_index").val();
	var works_indexes_array = works_indexes.split(",");
	if($("#works_index").val() == "")works_indexes_array = []
	function removeWorks($obj){
		// console.log("this",obj);
		var old_index = $obj.data("index");
		var index = works_indexes_array.indexOf(old_index);
		if(index < 0){
			index = works_indexes_array.indexOf(old_index.toString());
		}
		if (index > -1) {
			works_indexes_array.splice(index, 1);
		}
		$("#works_index").val(works_indexes_array.join(","));
		$obj.parent().parent().parent().parent().remove();
	}

	var activity_indexes = $("#activity_index").val();
	var activity_indexes_array = activity_indexes.split(",");
	if($("#activity_index").val() == "")activity_indexes_array = []
	function removeActivity($obj){
		// console.log("this",obj);
		var old_index = $obj.data("index");
		var index = activity_indexes_array.indexOf(old_index);
		if(index < 0){
			index = activity_indexes_array.indexOf(old_index.toString());
		}
		if (index > -1) {
			activity_indexes_array.splice(index, 1);
		}
		$("#activity_index").val(activity_indexes_array.join(","));
		$obj.parent().parent().remove();
	}

	$( document ).ready(function() {
		// $('#demo-foo-accordion').footable().on('footable_row_expanded', function(e) {
		// 	$('#demo-foo-accordion tbody tr.footable-detail-show').not(e.row).each(function() {
		// 		$('#demo-foo-accordion').data('footable').toggleDetail(this);
		// 	});
		// });
    });

	$(function()
	{
		var $frm_application = $('#frm_application');

		$(document).ready(function() 
		{
			init_application();
			init_comment();
			show_comments(<?php echo json_encode($comments) ?>);
		});

		function init_comment() {
			$('#btn_comment').click(function() {
				var comment = $('#comment').val();
				if($.trim(comment)) {
					var data = {
						user_id : $('#user_id').val(),
						comment : $('#comment').val(),
						<?php if($this->app_library->is_role_session('reviewer')) { ?>
						public : $('#public').is(':checked') ? 'Y' : 'N',
						<?php } else if($this->app_library->is_role_session('approver')) { ?>
						public : 'N',
						<?php } else { ?>
						public : 'Y',
						<?php } ?>
					}

					$('#btn_comment').html('Please wait ...');

					post_data('<?php echo $type == 'admin' ? 'panel/application/comment' : 'user/comment' ?>' , data , function(result) {
						show_comments(result);
						$('#comment').val('');
						$('#btn_comment').html('Submit your comment');
					});
				}
			});
		}

		function show_comments(comments) {
			$('#cnt_comments').html('');
			if(comments.length == 0) {
				$('#cnt_comments').html('<small>No comments available.</small>');
			} else {
				for(var i = 0 ; i < comments.length ; i ++) {
					var comment = comments[i];
					var $cnt_comment = $('#cnt_comment').clone();
					$cnt_comment.attr('id' , 'comment_' + comment.commentId);
					$cnt_comment.appendTo($('#cnt_comments'));

					$('.commenter' , $cnt_comment).html(comment.commenter.name);
					$('.commenter_photo' , $cnt_comment).attr('src' , comment.commenter.photo_id ? get_render_url(comment.commenter.photo_id) : g.base_url + 'assets/panel/assets/images/users/nophoto.png');
					$('.comment' , $cnt_comment).html(comment.comment_html);
					$('.comment_on' , $cnt_comment).html(timeAgo(comment.created_on) + ' ago');
				}
			}
		}
		function init_daterangepicker($obj){
			$obj.dateRangePicker(
			{
				startOfWeek: 'monday',
				separator : ' ~ ',
				format: 'MM/DD/YYYY',
				autoClose: false,
				monthSelect: true,
    			yearSelect: [1900, moment().get('year')]
			});
		}
		function init_application()
		{
			// $('#dob').datepicker({dateFormat: 'dd/mm/yy'});
			$('#end_date').bootstrapMaterialDatePicker({ format : 'YYYY:MM:DD HH:mm' });
			$(".datepicker").datepicker({dateFormat: 'dd/mm/yy'});

			$('#adwards_date').datepicker({dateFormat: 'dd/mm/yy'});
			$('#btn_draft').click(function() {
				action = 'draft';
			});
			// $(".date-range").dateRangePicker({});
			init_daterangepicker($('#bachelor_enrollment'));
			init_daterangepicker($('#graduate_enrollment'));
			activity_indexes_array.forEach(function(value){
				init_daterangepicker($('#extra_period_'+value));
			})
			$('#btn_submit').click(function() {
				action = 'submit';
			});

			$frm_application.validate(
			{
				submitHandler: function(form)
				{
					if(action == 'submit') {
						var result = confirm('Are you sure you want to submit? You will not be able to modify details after submission.');
						if(result) {
							form.submit();		
						}
					} else {
						form.submit();
					}
				},

				rules:
				{
					first_name : 
					{
						required : true,
						maxlength : 50
					},

					middle_name : 
					{
						required : true,
						maxlength : 50
					},		

					last_name : 
					{
						required : true,
						maxlength : 50
					},

					dob : 
					{
						required : true,
						maxlength : 50
					},

					gender : 
					{
						required : true,
					},

					email : 
					{
						required : true,
						maxlength : 50
					},

					phone : 
					{
						required : true,
						maxlength : 50
					},

					address : 
					{
						required : true,
						maxlength : 500
					},

					city : 
					{
						required : true,
						maxlength : 50
					},

					highest_qualification : 
					{
						required : true,
						maxlength : 500
					},

					bachelor_degree : 
					{
						required : true,
						maxlength : 500
					},

					bachelor_university : 
					{
						required : true,
						maxlength : 500
					},

					bachelor_university_address : 
					{
						required : true,
						maxlength : 500
					},
					bachelor_university_id : 
					{
						required : true,
					},
					bachelor_enrollment : 
					{
						required: true,
						maxlength : 500
					},

					bachelor_major : 
					{
						required : true,
						maxlength : 500
					},

					bachelor_gpa : 
					{
						required : true,
						maxlength : 500
					},

					work : 
					{
						required : true,
						maxlength : 500
					},

					work_area : 
					{
						required : true,
						maxlength : 500
					},

					qna_trigger : 
					{
						required : true,
						maxlength : 500
					},

					qna_priority : 
					{
						required : true,
						maxlength : 500
					},
					
					qna_achievement : 
					{
						required : true,
						maxlength : 500
					},

					qna_role_model : 
					{
						required : true,
						maxlength : 500
					},

					qna_hobbies : 
					{
						required : true,
						maxlength : 500
					},

					qna_passion : 
					{
						required : true,
						maxlength : 500
					},

					qna_contribute : 
					{
						required : true,
						maxlength : 500
					},

					qna_wand : 
					{
						required : true,
						maxlength : 500
					},

					first_preference : 
					{
						required : true,
					},

					second_preference : 
					{
						required : true,
					},

					third_preference : 
					{
						required : true,
					},

					<?php for($i = 1 ; $i <= 2 ; $i ++) { ?>
					
					contact_name_<?php echo $i; ?> : 
					{
						required : true,
						maxlength : 500
					},

					contact_title_<?php echo $i; ?> : 
					{
						required : true,
						maxlength : 500
					},

					contact_organization_<?php echo $i; ?> : 
					{
						required : true,
						maxlength : 500
					},

					contact_email_<?php echo $i; ?> : 
					{
						required : true,
						maxlength : 500
					},

					contact_phone_<?php echo $i; ?> : 
					{
						required : true,
						maxlength : 500
					},

					contact_relationship_<?php echo $i; ?> : 
					{
						required : true,
						maxlength : 500
					},

					<?php } ?>
				},

				messages : 
				{
					first_name : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 50 characters"
					},

					middle_name : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 50 characters"
					},		

					last_name : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 50 characters"
					},

					dob : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 50 characters"
					},

					gender : 
					{
						required : "This field is required",
					},

					email : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 50 characters"
					},

					phone : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 50 characters"
					},

					address : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 500 characters"
					},

					city : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 50 characters"
					},	

					highest_qualification : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 500 characters"
					},

					bachelor_degree : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 500 characters"
					},

					bachelor_university : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 500 characters"
					},

					bachelor_university_address : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 500 characters"
					},
					bachelor_university_id : 
					{
						required : "This field is required",
					},
					bachelor_enrollment : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 500 characters"
					},

					bachelor_major : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 500 characters"
					},

					bachelor_gpa : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 500 characters"
					},

					work : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 500 characters"
					},

					work_area : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 500 characters"
					},

					qna_trigger : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 500 characters"
					},

					qna_priority : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 500 characters"
					},
					
					qna_achievement : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 500 characters"
					},

					qna_role_model : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 500 characters"
					},

					qna_hobbies : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 500 characters"
					},

					qna_passion : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 500 characters"
					},

					qna_contribute : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 500 characters"
					},

					qna_wand : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 500 characters"
					},

					first_preference : 
					{
						required : "This field is required"
					},

					second_preference : 
					{
						required : "This field is required"
					},

					third_preference : 
					{
						required : "This field is required"
					},


					<?php for($i = 1 ; $i <= 2 ; $i ++) { ?>
					
					contact_name_<?php echo $i; ?> : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 500 characters"
					},

					contact_title_<?php echo $i; ?> : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 500 characters"
					},

					contact_organization_<?php echo $i; ?> : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 500 characters"
					},

					contact_email_<?php echo $i; ?> : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 500 characters"
					},

					contact_phone_<?php echo $i; ?> : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 500 characters"
					},

					contact_relationship_<?php echo $i; ?> : 
					{
						required : "This field is required",
						maxlength : "This field should not exceed 500 characters"
					},

					<?php } ?>
				},
			});

			var settings = $frm_application.validate().settings;
			var required_fields = [];
			for (var i in settings.rules)
			{
				if(settings.rules[i].required)
				{
					required_fields.push(i);
					$('[name="'+ i +'"]').closest('.form-group').find('label').append('<span class="astk">*</span>');
				}
			}

			$('#required_fields').val(required_fields.join(','));
		}
		$("#profile_picture").on("click",function(){
			$("#fileupload_lnk_photo").trigger("click");
		})
		$("#bachelor_university_id").on("change",function(){
			if($(this).val() == -1){
				$("#bachelor_university_container").show();
			}else{
				$("#bachelor_university_container").hide();
			}
		})
		$("#graduate_university_id").on("change",function(){
			if($(this).val() == -1){
				$("#graduate_university_container").show();
			}else{
				$("#graduate_university_container").hide();
			}
		})
		
		$("#adwards_new_entry").on("click",function(){	
			var last_index = 0;
			if(adwards_indexes_array.length >= 1){
				last_index = parseInt(adwards_indexes_array[adwards_indexes_array.length-1]);
			}
			var new_index = last_index + 1;
			adwards_indexes_array.push(new_index);
			$("#adwards_index").val(adwards_indexes_array.join(","));
			var html = "";
			html += "<div class='adwards'>";
			html += 	"<div class='form-group'>";
			html += 		"<div class='col-lg-12'>";
			html +=				"<a  class='remove_adwards pull-right' data-index='"+new_index+"' onclick='removeAdwards($(this))'><i class='fa fa-minus-circle'></i></a>";
			html += 			"<label>Title</label>";
			html += 			"<input type='text' class='form-control' name='adwards_title_"+new_index+"'>";
			html += 		"</div>";
			html += 	"</div>";
			html += 	"<div class='form-group'>";
			html += 		"<div class='row'>";
			html += 			"<div class='col-lg-6'>";
			html += 				"<label >Issuer</label>";
			html += 				"<input type='text' class='form-control'  name='adwards_issuer_"+new_index+"'>";
			html += 			"</div>";
			html += 			"<div class='col-lg-6'>";
			html += 				"<label>Date</label>";
			html += 				"<input type='text' class='form-control datepicker'  name='adwards_date_"+new_index+"' placeholder='Date (D/M/YY)' aria-required='true' aria-invalid='false'>";
			html += 			"</div>";
			html += 		"</div>";
			html += 	"</div>";
			html += 	"<div class='form-group'>";
			html += 		"<label>Description</label>";
			html += 		"<textarea class='form-control' name='awards_"+new_index+"'></textarea>";
			html += 	"</div>";
			html += 	"<hr>";
			html += "</div>"
			$("#adwards_form").append(html);
			$(".datepicker").datepicker({dateFormat: 'dd/mm/yy'});
		})
		$("#works_new_entry").on("click",function(){	
			var last_index = 0;
			if(works_indexes_array.length >= 1){
				last_index = parseInt(works_indexes_array[works_indexes_array.length-1]);
			}
			var new_index = last_index + 1;
			works_indexes_array.push(new_index);
			$("#works_index").val(works_indexes_array.join(","));
			var html = "";

			html +="<div class='works'>";
			html +=	"<div class='card'>";
			html +=		"<div class='card-body'>";
			html +=			"<div class='row'>";
			html +=				"<div class='col-lg-4'>";
			html +=					"<div class='form-group'>";
			html +=						"<label>Employment Period</label>";
			html +=						"<select class='form-control' name='work_period_"+new_index+"'>";
			html +=							"<option value='0' >0</option>";
			html +=							"<option value='1' >1</option>";
			html +=							"<option value='2' >2</option>";
			html +=							"<option value='3' >3</option>";
			html +=							"<option value='3+'>3+</option>";
			html +=						"</select>";
			html +=					"</div>";
			html +=					"</div>";
			html +=				"<div class='col-lg-4'>";
			html +=					"<div class='form-group'>";
			html +=						"<label>Company / Orgnisation</label>";
			html +=						"<input type='text' class='form-control' name='work_company_"+new_index+"'>";
			html +=					"</div>";
			html +=				"</div>";
			html +=				"<div class='col-lg-4'>";
			html +=					"<div class='form-group'>";
			html +=						"<a  class='remove_works pull-right' data-index='"+new_index+"' onclick='removeWorks($(this))'><i class='fa fa-minus-circle' 							></i></a>";
			html +=						"<label>Location <small>(City, Country)</small></label>";
			html +=						"<input type='text' class='form-control' name='work_location_"+new_index+"'>";
			html +=					"</div>";
			html +=				"</div>";
			html +=			"</div>";
		
			html +=			"<div class='row'>";
			html +=				"<div class='col-lg-12'>";
			html +=					"<div class='form-group'>";
			html +=						"<label>Key Responsibilities</label>";
			html +=						"<textarea type='text' class='form-control' name='work_responsibility_"+new_index+"'></textarea>";
			html +=					"</div>";
			html +=				"</div>";
			html +=			"</div>";
			html +=		"</div>";
			html +=	"</div>";
			html +="</div>"
			$("#works_form").append(html);
		})

		$("#activity_new_entry").on("click",function(){	
			var last_index = 0;
			if(activity_indexes_array.length >= 1){
				last_index = parseInt(activity_indexes_array[activity_indexes_array.length-1]);
			}
			var new_index = last_index + 1;
			activity_indexes_array.push(new_index);
			$("#activity_index").val(activity_indexes_array.join(","));
			var html = "";

			html += "<tr>";
			html +=	"<td><input type='text' class='form-control date-range'  id='extra_period_"+new_index+"' name='extra_period_"+new_index+"'></td>";
			html +=	"<td><input type='text' class='form-control' name='extra_extra_"+new_index+"' ></td>";
			html +=	"<td><input type='text' class='form-control' name='extra_location_"+new_index+"'></td>";
			html +=	"<td><input type='text' class='form-control' name='extra_responsibility_"+new_index+"'></td>";
			html +=	"<td>";
			html +=		"<a  class='remove_activity pull-right' data-index='"+new_index+"' onclick='removeActivity($(this))'><i class='fa fa-minus-circle' ></i></a>";
			html +=	"</td>";
			html +="</tr>"
			$("#activity_form").append(html);
			init_daterangepicker($("#extra_period_"+new_index))
		})
		
	}(jQuery));

</script>