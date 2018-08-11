<?php $application = $user['application']; ?>
<div class="row green">
	<div class="col-md-6">
		<h1 class="m-v-0">Welcome,</h1>
		<h3 class="m-v-0"><?php echo $user['name']; ?> &nbsp; <a href="<?php echo $base_url; ?>user/signout" class="">(logout)</a></h3>
		<div class="m-b-20"></div>
<p>Your Completion Progress : <?php echo $user['progress'] ?>%</p>
		<div class="progress">
			<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $user['progress'] ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $user['progress'] ?>%">
				<span class="sr-only"><?php echo $user['progress'] ?>% Complete</span>
			</div>
		</div>
		
	</div>
	<div class="col-md-6">
		<div class="m-b-15"></div>
		<div class="alert alert-success" role="alert"><i class="fa fa-info-circle"></i> <strong>Note!</strong> You can login at anytime to complete your application. Deadline for completion is on 10th of May 2016. Kindly ensure that all of the information you provide is correct, and that all necessary documents are successfully uploaded and submitted.</div>
	</div>

	<div class="col-md-12">
		
		<?php show_success_message(); ?>
		<?php show_error_message(); ?>	
		
		<?php if($user['progress'] == 100) { ?>
		
		<div class="alert alert-success" role="alert">
			<i class="fa fa-info-circle"></i> <strong>Congratulations!</strong> You have filled up all necessary information. You can submit this application.
			<br/>
			<i class="fa fa-info-circle invisible"></i> Current Status : <strong><?php echo ucwords($user['status']); ?></strong>
		</div>

		<?php } ?>
		<h2>Your Application Categories :</h2>	

		<form id="frm_application" name="frm_application" action="<?php echo $base_url; ?>user/do_application" method="POST">

		<div class="panel-group accordion" id="accordion" role="tablist" aria-multiselectable="true">
			
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#application_personal" aria-expanded="true" aria-controls="application_personal">
						Personal information
					</a>
					</h4>
				</div>
				<div id="application_personal" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					<div class="panel-body">
						
						<div class="form-group">
							<label for="first_name">First name</label>
							<input type="text" class="form-control" id="first_name" name="first_name" placeholder="First name" value="<?php echo $user['first_name']; ?>">
						</div>

						<div class="form-group">
							<label for="middle_name">Middle name</label>
							<input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Middle name" value="<?php echo $user['middle_name']; ?>">
						</div>

						<div class="form-group">
							<label for="last_name">Last name</label>
							<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last name" value="<?php echo $user['last_name']; ?>">
						</div>

						<div class="form-group">
							<label for="dob">Birth Date</label>
							<input type="text" class="form-control" id="dob" name="dob" placeholder="Birth Date (D/M/YY)" value="<?php echo $user['dob']; ?>">
						</div>

						<div class="form-group">
							<label for="gender">Gender</label>
							<select class="form-control" id="gender" name="gender">
								<option value="Male" <?php echo $user['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
								<option value="Female" <?php echo $user['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
							</select>
						</div>

						<div class="form-group">
							<label for="email">Email Address</label>
							<input type="text" class="form-control" id="email" name="email" placeholder="Email Address" value="<?php echo $user['email'] ?>">
						</div>

						<div class="form-group">
							<label for="phone">Phone number</label>
							<input type="text" class="form-control" id="phone" name="phone" placeholder="Phone number" value="<?php echo $user['phone'] ?>">
						</div>

						<div class="form-group">
							<label for="address">Mailing Address</label>
							<input type="text" class="form-control" id="address" name="address" placeholder="Mailing Address" value="<?php echo $user['address']; ?>">
						</div>

						<div class="form-group">
							<label for="city">City of Residence</label>
							<input type="text" class="form-control" id="city" name="city" placeholder="City of Residence" value="<?php echo $user['city']; ?>">
						</div>

					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#application_education" aria-expanded="true" aria-controls="application_education">
						Education information 
					</a>
					</h4>
				</div>
				<div id="application_education" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					<div class="panel-body">
						
						<div class="form-group">
							<label for="highest_qualification">Highest Acedemic Qualificatoin</label>
							<input type="text" class="form-control" id="highest_qualification" name="highest_qualification" placeholder="Highest Acedemic Qualificatoin" value="<?php echo $application['highest_qualification']; ?>">
						</div>

						<div class="form-group">
							<label for="bachelor_degree">Bachelor's Degree</label>
							<input type="text" class="form-control" id="bachelor_degree" name="bachelor_degree" placeholder="Bachelor's Degree" value="<?php echo $application['bachelor_degree']; ?>">
						</div>

						<div class="form-group">
							<label for="bachelor_university">Bachelor's University Name</label>
							<input type="text" class="form-control" id="bachelor_university" name="bachelor_university" placeholder="Bachelor's University Name" value="<?php echo $application['bachelor_university']; ?>">
						</div>

						<div class="form-group">
							<label for="bachelor_university_address">University Location</label>
							<input type="text" class="form-control" id="bachelor_university_address" name="bachelor_university_address" placeholder="University Location" value="<?php echo $application['bachelor_university_address']; ?>">
						</div>

						<div class="form-group">
							<label for="bachelor_enrollment">Period of enrollment</label>
							<input type="text" class="form-control" id="bachelor_enrollment" name="bachelor_enrollment" placeholder="mm/yyyy - mm/yyyy, or present" value="<?php echo $application['bachelor_enrollment']; ?>">
						</div>

						<div class="form-group">
							<label for="bachelor_major">Bachelor's Major (& Minor)</label>
							<input type="text" class="form-control" id="bachelor_major" name="bachelor_major" placeholder="Bachelor's Major (& Minor)" value="<?php echo $application['bachelor_major']; ?>">
						</div>

						<div class="form-group">
							<label for="bachelor_gpa">Bachelor's final GPA</label>
							<input type="text" class="form-control" id="bachelor_gpa" name="bachelor_gpa" placeholder="Bachelor's final GPA" value="<?php echo $application['bachelor_gpa']; ?>">
						</div>

						<div class="form-group">
							<label for="undergraduate_ranking">Undergraduate Final Year Student Ranking</label>
							<input type="text" class="form-control" id="undergraduate_ranking" name="undergraduate_ranking" placeholder="Ranking" value="<?php echo $application['undergraduate_ranking']; ?>">
						</div>
						
						<hr>

						<div class="form-group">
							<label for="graduate_degree">Graduate Degree</label>
							<input type="text" class="form-control" id="graduate_degree" name="graduate_degree" placeholder="Graduate Degree" value="<?php echo $application['graduate_degree']; ?>">
						</div>

						<div class="form-group">
							<label for="graduate_university">Graduate University Name</label>
							<input type="text" class="form-control" id="graduate_university" name="graduate_university" placeholder="Graduate University Name" value="<?php echo $application['graduate_university']; ?>">
						</div>

						<div class="form-group">
							<label for="graduate_university_address">University Location</label>
							<input type="text" class="form-control" id="graduate_university_address" name="graduate_university_address" placeholder="University Location" value="<?php echo $application['graduate_university_address']; ?>">
						</div>

						<div class="form-group">
							<label for="graduate_enrollment">Period of enrollment</label>
							<input type="text" class="form-control" id="graduate_enrollment" name="graduate_enrollment" placeholder="mm/yyyy - mm/yyyy, or present" value="<?php echo $application['graduate_enrollment']; ?>">
						</div>

						<div class="form-group">
							<label for="graduate_major">Graduate Emphasis</label>
							<input type="text" class="form-control" id="graduate_major" name="graduate_major" placeholder="Graduate Emphasis" value="<?php echo $application['graduate_major']; ?>">
						</div>

						<div class="form-group">
							<label for="graduate_gpa">Graduate final GPA</label>
							<input type="text" class="form-control" id="graduate_gpa" name="graduate_gpa" placeholder="Graduate final GPA" value="<?php echo $application['graduate_gpa']; ?>">
						</div>

						<div class="form-group">
							<label for="graduate_ranking">Graduate Final Year Student Ranking</label>
							<input type="text" class="form-control" id="graduate_ranking" name="graduate_ranking" placeholder="Ranking" value="<?php echo $application['graduate_ranking']; ?>">
						</div>

						<hr>

						<div class="form-group">
							<label for="highschool_name">High School Name</label>
							<input type="text" class="form-control" id="highschool_name" name="highschool_name" placeholder="High School Name" value="<?php echo $application['highschool_name']; ?>">
						</div>

						<div class="form-group">
							<label for="highschool_gpa">High School GPA</label>
							<input type="text" class="form-control" id="highschool_gpa" name="highschool_gpa" placeholder="High School GPA" value="<?php echo $application['highschool_gpa']; ?>">
						</div>

						<div class="form-group">
							<label for="highschool_ranking">High School Final Year Ranking</label>
							<input type="text" class="form-control" id="highschool_ranking" name="highschool_ranking" placeholder="High School Final Year Ranking" value="<?php echo $application['highschool_ranking']; ?>">
						</div>

					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#application_work" aria-expanded="true" aria-controls="application_work">
						Work Experience 
					</a>
					</h4>
				</div>
				<div id="application_work" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					<div class="panel-body">
						
						<div class="form-group">
							<label for="work">Number of years of work experience if applicable:</label>
							<input type="text" class="form-control" id="work" name="work" placeholder="Years" value="<?php echo $application['work']; ?>">
						</div>

						<div class="form-group">
							<label for="work_area">What is your main area of expertise?:</label>
							<input type="text" class="form-control" id="work_area" name="work_area" placeholder="Area of expertise" value="<?php echo $application['work_area']; ?>">
						</div>

						<div class="table-responsive">
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th>Period of Employment</th>
										<th>Name of Company/Organization</th>
										<th>Location (City, Country)</th>
										<th>Key Responsibilities</th>
									</tr>
								</thead>
								<tbody>
									<?php for($i = 0 ; $i < 4 ; $i ++) { ?>
									<tr>
										<td><input type="text" class="form-control" id="work_period_<?php echo $i; ?>" value="<?php echo $application['work_period_' . $i]; ?>" name="work_period_<?php echo $i; ?>"></td>
										<td><input type="text" class="form-control" id="work_company_<?php echo $i; ?>" value="<?php echo $application['work_company_' . $i]; ?>" name="work_company_<?php echo $i; ?>"></td>
										<td><input type="text" class="form-control" id="work_location_<?php echo $i; ?>" value="<?php echo $application['work_location_' . $i]; ?>" name="work_location_<?php echo $i; ?>"></td>
										<td><input type="text" class="form-control" id="work_responsibility_<?php echo $i; ?>" value="<?php echo $application['work_responsibility_' . $i]; ?>" name="work_responsibility_<?php echo $i; ?>"></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>

					</div>
				</div>
			</div>	

			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#application_extra" aria-expanded="true" aria-controls="application_extra">
						Extra - Curricular Activities
					</a>
					</h4>
				</div>
				<div id="application_extra" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					<div class="panel-body">
						
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
									<?php for($i = 0 ; $i < 4 ; $i ++) { ?>
									<tr>
										<td><input type="text" class="form-control" id="extra_period_<?php echo $i; ?>" value="<?php echo $application['extra_period_' . $i]; ?>" name="extra_period_<?php echo $i; ?>"></td>
										<td><input type="text" class="form-control" id="extra_extra_<?php echo $i; ?>" value="<?php echo $application['extra_extra_' . $i]; ?>" name="extra_extra_<?php echo $i; ?>"></td>
										<td><input type="text" class="form-control" id="extra_location_<?php echo $i; ?>" value="<?php echo $application['extra_location_' . $i]; ?>" name="extra_location_<?php echo $i; ?>"></td>
										<td><input type="text" class="form-control" id="extra_responsibility_<?php echo $i; ?>" value="<?php echo $application['extra_responsibility_' . $i]; ?>" name="extra_responsibility_<?php echo $i; ?>"></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>

					</div>
				</div>
			</div>	

			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#application_qna" aria-expanded="true" aria-controls="application_qna">
						Short and long answer questions
					</a>
					</h4>
				</div>
				<div id="application_qna" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					<div class="panel-body">

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
								If you were given a magic wand, how would you use it to change an issue at:<br/>
								a.	At a personal level? <br/>
								b.	At a global level? <br/>
								Please answer with a maximum of 300 words in total.
							</label>
							<textarea class="form-control" id="qna_wand" name="qna_wand" placeholder=""><?php echo $application['qna_wand']; ?></textarea>
						</div>

					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#application_awards" aria-expanded="true" aria-controls="application_awards">
						Significant awards
					</a>
					</h4>
				</div>
				<div id="application_awards" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					<div class="panel-body">
						
						<div class="form-group">
							<label for="awards">
								Please use this area to tell us about any significant awards or recognitions that you have received in the last 3 years (i.e., prizes, honors, other fellowships, etc.).  You can say 'none' if this does not apply. 
							</label>
							<textarea class="form-control" id="awards" name="awards" placeholder=""><?php echo $application['awards']; ?></textarea>
						</div>

					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#application_roles" aria-expanded="true" aria-controls="application_roles">
						Job Role Preference
					</a>
					</h4>
				</div>
				<div id="application_roles" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					<div class="panel-body">
						
						<div class="form-group">
							<label for="awards">
								Please rank below your top 3 preference of job areas (from 1 to 3)
							</label>							
						</div>
						
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

						<div class="form-group">
							<label for="first_preference">First Preference</label>
							<select name="first_preference" id="first_preference" class="form-control">
								<option value="">-- Select --</option>
								<?php foreach ($roles as $role) { ?>
								<option value="<?php echo $role; ?>" <?php echo $role == $application['first_preference'] ? 'selected' : ''; ?>><?php echo $role; ?></option>
								<?php } ?>
							</select>
						</div>

						<div class="form-group">
							<label for="second_preference">Second Preference</label>
							<select name="second_preference" id="second_preference" class="form-control">
								<option value="">-- Select --</option>
								<?php foreach ($roles as $role) { ?>
								<option value="<?php echo $role; ?>" <?php echo $role == $application['second_preference'] ? 'selected' : ''; ?>><?php echo $role; ?></option>
								<?php } ?>
							</select>
						</div>

						<div class="form-group">
							<label for="third_preference">Third Preference</label>
							<select name="third_preference" id="third_preference" class="form-control">
								<option value="">-- Select --</option>
								<?php foreach ($roles as $role) { ?>
								<option value="<?php echo $role; ?>" <?php echo $role == $application['third_preference'] ? 'selected' : ''; ?>><?php echo $role; ?></option>
								<?php } ?>
							</select>
						</div>

					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#application_contact" aria-expanded="true" aria-controls="application_contact">
						Contact Reference
					</a>
					</h4>
				</div>
				<div id="application_contact" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					<div class="panel-body">
						
						<div class="row">
							<div class="col-sm-6">
								
								<h3>Reference # 1</h3>	
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
								
								<h3>Reference # 2</h3>
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


			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#application_cv" aria-expanded="true" aria-controls="application_cv">
						CV
					</a>
					</h4>
				</div>
				<div id="application_cv" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					<div class="panel-body">
						
						<div class="form-group ">
		                    <label for="cv" class="control-label">CV</label>
		                    <div>
		                       <div class="file-uploader-outer">
                                    <a href="javascript:;" class="thumbnail file-thumbnail-text file-uploader" id="lnk_cv" data-module="CV">Upload
                                        <input type="hidden" id="cv_id" name="cv_id" value="<?php echo $application['cv_id']; ?>">
                                    </a>
                                    <a class="download " href="<?php echo $this->attachment_library->download_url($application['cv_id']); ?>"><?php echo $this->attachment_library->get_name($application['cv_id']); ?></a>
                                    <small>Please select file</small>
                                </div>
		                    </div>
		                </div>

		                <div class="form-group ">
		                    <label for="photo" class="control-label">Photo</label>
		                    <div>
		                       <div class="file-uploader-outer">
                                    <a href="javascript:;" class="thumbnail file-thumbnail-text file-uploader" id="lnk_photo" data-module="CV">Upload
                                        <input type="hidden" id="photo_id" name="photo_id" value="<?php echo $application['photo_id']; ?>">
                                    </a>
                                    <a class="download " href="<?php echo $this->attachment_library->download_url($application['photo_id']); ?>"><?php echo $this->attachment_library->get_name($application['photo_id']); ?></a>
                                    <small>Please select file</small>
                                </div>
		                    </div>
		                </div>

					</div>
				</div>
			</div>			
			
		</div>

		<div class="m-b-50"></div>
		
		<div class="floating-action">								
			<div class="container" style="padding:0; margin: 0 auto;">
				<div class="action">
						
					<div class="row">
						<div class="col-xs-12">
							<input type="hidden" name="status" id="status" value="draft" value="<?php echo $application['status']; ?>">
							<input type="hidden" name="required_fields" id="required_fields" value=""/>
		
							<?php if($settings['application'] == 1) { ?>
							<?php if($user['status_edit'] != 'closed') { ?>
							<?php if($user['progress'] == 100) {  ?>
							<input type="button" class="btn btn-block btn-default" value="Save" id="btn_save">
							<input type="submit" class="btn btn-block btn-pink" value="Submit" id="btn_submit">
							<?php } else { ?>
							<input type="button" class="btn btn-block btn-pink" value="Save" id="btn_save">
							<?php } ?>
							<?php } ?>
							<?php } ?>
						</div>	
					</div>	

				</div>	
			</div>		
		</div>		


		
		</form>	
		
		
	</div>

</div>

<script type="text/javascript">
	
	var $frm_application;
	$(document).ready(function() 
	{
		$frm_application = $('#frm_application');
		init_application();
	});

	function init_application()
	{
		$('#btn_save').click(function(event) 
		{
			$('#status').val('draft');
			$frm_application[0].submit();	
			return false;
		});

		$('#btn_submit').click(function(event) 
		{
			$('#status').val('submitted');
		});

		$frm_application.validate(
		{
			ignore: [],
			invalidHandler: function(form, validator) 
			{
				if (validator.numberOfInvalids() > 0) 
				{
				    validator.showErrors();
				    var $collapse = $(":input.error").first().closest(".collapse");
				    $collapse.collapse('show');
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

			submitHandler: function (form)
			{
				$('#status').val('submitted');
				$frm_application[0].submit();	
				return false;
			}
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

</script>