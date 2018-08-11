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
                <h1 class="text-themecolor">Participants Data </h1>
            </div>

        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        
        
        
        <div class="card">
            <div class="card-header">
                Filter Data
                <div class="card-actions">
                    <a class="" data-action="collapse"><i class="ti-plus"></i></a>
                    
                </div>
            </div>
            <div class="card-body collapse">
                  <form style="margin-top: 25px" id="" class="" method="GET" action="">
                      <div class="row">
                          <div class="col-lg-4"><div class="filter-search">
                        <div class="form-group">
                            <label> First Name  </label>
                            <input type="text" class="form-control" name="first_name" value="<?php echo $filter['first_name'] ?>">
                        </div>
                    </div></div>
                          <div class="col-lg-4"><div class="filter-search">
                        <div class="form-group">
                            <label> Last Name  </label>
                            <input type="text" class="form-control" name="last_name" value="<?php echo $filter['last_name'] ?>">
                        </div>
                    </div></div>
                          <div class="col-lg-4"><div class="filter-search">
                        <div class="form-group">
                            <label> Region  </label>
                            <input type="text" class="form-control" name="region" value="<?php echo $filter['region'] ?>">
                        </div>
                    </div></div>
                          
                      </div>
            <div class="row">
                <div class="col-lg-4 pr-3">
                    <div class="filter-search">
                        <div class="form-group">
                            <label> City </label>
                            <select class="form-control" name="city" id="city">
                                <option value="">- Select City -</option>
                                <option value="Abhā" <?php echo $filter['city'] == "Abhā" ? 'selected' : ''; ?> >Abhā</option>
                                <option value="Abqaiq" <?php echo $filter['city'] == "Abqaiq" ? 'selected' : ''; ?> >Abqaiq</option>
                                <option value="Al-Baḥah" <?php echo $filter['city'] == "Al-Baḥah" ? 'selected' : ''; ?> >Al-Baḥah</option>
                                <option value="Al-Dammām" <?php echo $filter['city'] == "Al-Dammām" ? 'selected' : ''; ?> >Al-Dammām</option>
                                <option value="Al-Hufūf" <?php echo $filter['city'] == "Al-Hufūf" ? 'selected' : ''; ?> >Al-Hufūf</option>
                                <option value="Al-Jawf" <?php echo $filter['city'] == "Al-Jawf" ? 'selected' : ''; ?> >Al-Jawf</option>
                                <option value="Al-Kharj (oasis)" <?php echo $filter['city'] == "Al-Kharj (oasis)" ? 'selected' : ''; ?> >Al-Kharj (oasis)</option>
                                <option value="Al-Khubar" <?php echo $filter['city'] == "Al-Khubar" ? 'selected' : ''; ?> >Al-Khubar</option>
                                <option value="Al-Qaṭīf" <?php echo $filter['city'] == "Al-Qaṭīf" ? 'selected' : ''; ?> >Al-Qaṭīf</option>
                                <option value="Al-Ṭaʾif" <?php echo $filter['city'] == "Al-Ṭaʾif" ? 'selected' : ''; ?> >Al-Ṭaʾif</option>
                                <option value="ʿArʿar" <?php echo $filter['city'] == "ʿArʿar" ? 'selected' : ''; ?> >ʿArʿar</option>
                                <option value="Buraydah" <?php echo $filter['city'] == "Buraydah" ? 'selected' : ''; ?> >Buraydah</option>
                                <option value="Dhahran" <?php echo $filter['city'] == "Dhahran" ? 'selected' : ''; ?> >Dhahran</option>
                                <option value="Ḥāʾil" <?php echo $filter['city'] == "Ḥāʾil" ? 'selected' : ''; ?> >Ḥāʾil</option>
                                <option value="Jiddah" <?php echo $filter['city'] == "Jiddah" ? 'selected' : ''; ?> >Jiddah</option>
                                <option value="Jīzān" <?php echo $filter['city'] == "Jīzān" ? 'selected' : ''; ?> >Jīzān</option>
                                <option value="Khamīs Mushayt" <?php echo $filter['city'] == "Khamīs Mushayt" ? 'selected' : ''; ?> >Khamīs Mushayt</option>
                                <option value="King Khalīd Military City" <?php echo $filter['city'] == "King Khalīd Military City" ? 'selected' : ''; ?> >King Khalīd Military City</option>
                                <option value="Mecca" <?php echo $filter['city'] == "Mecca" ? 'selected' : ''; ?> >Mecca</option>
                                <option value="Medina" <?php echo $filter['city'] == "Medina" ? 'selected' : ''; ?> >Medina</option>
                                <option value="Najrān" <?php echo $filter['city'] == "Najrān" ? 'selected' : ''; ?> >Najrān</option>
                                <option value="Ras Tanura" <?php echo $filter['city'] == "Ras Tanura" ? 'selected' : ''; ?> >Ras Tanura</option>
                                <option value="Riyadh" <?php echo $filter['city'] == "Riyadh" ? 'selected' : ''; ?> >Riyadh</option>
                                <option value="Sakākā" <?php echo $filter['city'] == "Sakākā" ? 'selected' : ''; ?> >Sakākā</option>
                                <option value="Tabūk" <?php echo $filter['city'] == "Tabūk" ? 'selected' : ''; ?> >Tabūk</option>
                                <option value="Yanbuʿ" <?php echo $filter['city'] == "Yanbuʿ" ? 'selected' : ''; ?> >Yanbuʿ</option>
                            </select>    
                        </div>
                    </div>
                </div>
               
                <div class="col-lg-4">
                    <div class="filter-search">
                        <div class="form-group">
                            <label> Experience years  </label>
                            <input type="text" class="form-control" name="work" value="<?php echo $filter['work'] ?>">
                        </div>
                    </div>
                </div>
                 <div class="col-lg-4">
                    <div class="filter-search">
                        <div class="form-group">
                            <label> Completion Status  </label>
                              <select class="form-control" name="progress">
                                <option value="">- Select -</option>  
                                <option value="incomplete" <?php echo $filter['progress'] == 'incomplete' ? 'selected' : '' ?>> Un-Completed </option>
                                <option value="completed" <?php echo $filter['progress'] == 'completed' ? 'selected' : '' ?>> Completed </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 pr-3">
                    <div class="filter-search">
                        <div class="form-group">
                            <label> Gender </label>
                            <select class="form-control" name="gender">
                                <option value="">- Select -</option>
                                <option value="Male" <?php echo $filter['gender'] == 'Male' ? 'selected' : '' ?>> Male </option>
                                <option value="Female" <?php echo $filter['gender'] == 'Female' ? 'selected' : '' ?>> Female </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 pr-3">
                    <div class="filter-search">
                        <div class="form-group">
                            <label> Application Status </label>
                            <select class="form-control" name="status">
                                <option value="">- Select -</option>
                                <?php if($this->app_library->is_role_session('admin')) { ?>
                                <option value="draft" <?php echo $filter['status'] == 'draft' ? 'selected' : '' ?>>Draft</option>
                                <option value="submitted" <?php echo $filter['status'] == 'submitted' ? 'selected' : '' ?>>Submitted</option>
                                <option value="reviewed" <?php echo $filter['status'] == 'reviewed' ? 'selected' : '' ?>>Reviewed</option>
                                <option value="approved" <?php echo $filter['status'] == 'approved' ? 'selected' : '' ?>>Approved</option>
                                <option value="rejected" <?php echo $filter['status'] == 'rejected' ? 'selected' : '' ?>>Rejected</option>
                                <?php } ?>

                                <?php if($this->app_library->is_role_session('reviewer')) { ?>
                                <option value="draft" <?php echo $filter['status'] == 'draft' ? 'selected' : '' ?>>Draft</option>
                                <option value="submitted" <?php echo $filter['status'] == 'submitted' ? 'selected' : '' ?>>Submitted</option>
                                <?php } ?>

                                <?php if($this->app_library->is_role_session('approver')) { ?>
                                <option value="reviewed" <?php echo $filter['status'] == 'reviewed' ? 'selected' : '' ?>>Reviewed</option>
                                <?php /* ?>
                                <option value="approved" <?php echo $filter['status'] == 'approved' ? 'selected' : '' ?>>Approved</option>
                                <option value="rejected" <?php echo $filter['status'] == 'rejected' ? 'selected' : '' ?>>Rejected</option>
                                <?php /**/ ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 pr-3">
                    <div class="filter-search">
                        <div class="form-group">
                            <label> Graduate Degree </label>
                            <input class="form-control" type="text" name="bachelor_degree" value="<?php echo $filter['bachelor_degree'] ?>">
                        </div>
                    </div>
                </div>
            </div>
                      <div class="row">
                          <div class="col-lg-12"><input type="submit" class="btn btn-primary" value="Filter"/></div>
                      </div>
        </form>
            </div>
        </div>
        
      
        <div class="row">
            <div class="col-md-12" style="overflow-x: scroll">
               <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Participants Data</h4>
                        <h6 class="card-subtitle">Export data <a href="<?php echo $base_url ?>panel/application/listing?export=true&<?php echo $_SERVER["QUERY_STRING"]; ?>" class="btn btn-primary btn-xs">Download all participants info</a></h6>
                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>City</th>
                                        <th>Age</th>
                                        <th>Register Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Age</th>
                                        <th>Start date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($users as $user) { ?>
                                    <?php $application = $user['application']; ?>
                                    <tr>
                                        <td><?php echo $user['name'] ?></td>
                                        <td><?php echo $application['first_preference']; ?></td>
                                        <td><?php echo $user['city'] ?></td>
                                        <td><?= $user['dob'] ? calc_age($user['dob']) : ''; ?></td>
                                        <td><?php echo format_date($user['created_on']); ?></td>
                                        <td><?php echo $user['status_text']; ?></td>
                                        <td> &nbsp; <a href="<?php echo $base_url ?>panel/application/view/<?php echo $user['user_id'] ?>" class="btn btn-success btn-circle"><i class="fa fa-edit"></i> </a>&nbsp;<button type="button" class="btn btn-danger btn-circle"><i class="fa fa-times"></i> </button>&nbsp;</td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
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

<script>
$(document).ready(function() {
    $('#myTable').DataTable();
    $(document).ready(function() {
        var table = $('#example').DataTable({
            "columnDefs": [{
                "visible": false,
                "targets": 2
            }],
            "order": [
                [4, 'desc']
            ],
            "displayLength": 25,
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;
                api.column(2, {
                    page: 'current'
                }).data().each(function(group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                        last = group;
                    }
                });               
            }
        });
        // Order by the grouping
        $('#example tbody').on('click', 'tr.group', function() {
            var currentOrder = table.order()[0];
            if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                table.order([2, 'desc']).draw();
            } else {
                table.order([2, 'asc']).draw();
            }
        });

        setTimeout(function() {
            console.log($('.buttons-csv span'));
            $('.buttons-csv span').html('Download summary data');
        } , 1000); 
    });
});

$(document).ready(function() {
    $('#example23').DataTable({
        dom: 'Bfrtip',
        "order": [
            [4, 'desc']
        ],
        buttons: [
              'csv'
        ]
    });
});    
</script>