<div class="row green">
	<div class="col-md-12">
		
		<div class="actions-container clearfix m-b-15">
			<div class="btn-group pull-left" role="group" aria-label="">
				<a href="<?php echo $base_url ?>admin/applications" class="btn btn-default <?php echo $filter == '' ? 'btn-primary' : ''; ?>">All</a>
				<a href="<?php echo $base_url ?>admin/applications?filter=active" class="btn btn-default <?php echo $filter == 'active' ? 'btn-primary' : ''; ?>">Active</a>
				<a href="<?php echo $base_url ?>admin/applications?filter=completed" class="btn btn-default <?php echo $filter == 'completed' ? 'btn-primary' : ''; ?>">100% Completed</a>
				<a href="<?php echo $base_url ?>admin/applications?filter=approved" class="btn btn-default <?php echo $filter == 'approved' ? 'btn-primary' : ''; ?>">Approved</a>
				<a href="<?php echo $base_url ?>admin/applications?filter=rejected" class="btn btn-default <?php echo $filter == 'rejected' ? 'btn-primary' : ''; ?>">Rejected</a>
			</div>
			<div class="btn-export pull-right">
				<a href="<?php echo $base_url ?>admin/export<?php echo $filter != "" ? '?filter=' . $filter : ''; ?>" class="btn btn-info <?php echo count($users) ? '' : 'disabled' ?>">Export</a>
			</div>
		</div>

		<div class="table-responsive">
			<table class="table table-striped table-green">
				<thead>
					<tr>
						<th>Applicant Name</th>
						<th>Email</th>
						<th>Phone</th>
						<th class="text-right">Progress</th>
						<th class="text-center">Status</th>
						<th class="text-right">Action</th>
					</tr>
				</thead>

				<tbody>
					<?php if(count($users)) { ?>
					<?php foreach ($users as $user) { ?>
					<tr class="<?php echo $user['read'] == 'N' ? 'active' : ''; ?>">
						<td><?php echo $user['name'] ?></td>						
						<td><?php echo $user['email'] ?></td>
						<td><?php echo $user['phone'] ?></td>
						<td class="text-right"><?php echo $user['progress'] ?>%</td>
						<td class="text-center"><?php echo $user['status']; ?></td>
						<td class="text-right">
							<a class="btn btn-pink btn-xs" href="<?php echo $base_url; ?>admin/application/<?php echo $user['user_id']; ?>">View</a>
							<?php if($user['read'] == 'N') { ?>
							<a class="btn btn-default btn-xs" href="<?php echo $base_url; ?>admin/application_read/<?php echo $user['user_id']; ?>">Read</a>
							<?php } else { ?>
							<a class="btn btn-default btn-xs" href="<?php echo $base_url; ?>admin/application_unread/<?php echo $user['user_id']; ?>">Unread</a>
							<?php } ?>
							<a href="<?php echo $base_url ?>admin/application_export/<?php echo $user['user_id']; ?>" class="btn btn-xs btn-info" target="_blank">Export</a>
						</td>
					</tr>	
					<?php } ?>
					<?php } else { ?>
					<tr>
						<td colspan="6" class="text-center">No records found.</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>

	</div>
</div>