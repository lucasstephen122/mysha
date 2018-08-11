<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $user; ?></title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="/assets/assets/bootstrap-3.3.6/dist/css/bootstrap.css"/>
	</head>
	<body>
		<div class="export-table">
			<div class="container-fluid">
				<h2 style="margin-top: 0;"><small>Application Reports for :-</small> <?php echo $user; ?></h2>
				<div class="table-responsive">
					<table class="table" style="margin: 0;">
						<tbody>
							<?php foreach ($application as $fields) { ?>
								<tr>
									<?php if($fields[2] == 'head') { ?>
										<th class="h3"><?php echo $fields[0]; ?></th>
									<?php } elseif($fields[2] == 'subhead') { ?>
										<th class="h4"><?php echo $fields[0]; ?></th>
									<?php } else { ?>
										<td><?php echo $fields[0]; ?></td>
									<?php } ?>
									<td><?php echo $fields[1]; ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<style type="text/css">
			.container-fluid{padding: 30px;}
			/*.table tr.th-head{background: #eee !important;}*/
			*{vertical-align: middle !important;}

			@media print
			{
				.container-fluid{padding: 0;}
				/*table tr.th-thead, .table tr.th-head{background: #eee !important;}*/
			}
		</style>

		<script type="text/javascript">
			window.print();
			setTimeout(window.close, 0);
		</script>
	</body>
</html>