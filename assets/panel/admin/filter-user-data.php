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
    <title>Filter user data</title>
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <link href="dist/css/custom.css" rel="stylesheet">
    <link href="../assets/node_modules/tablesaw-master/dist/tablesaw.css" rel="stylesheet">
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
       <?php include('header.php'); ?>
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
                            <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                            
                        </div>
                    </div>
                    <div class="card-body collapse show">
                          <form style="margin-top: 25px" id="" class="" method="post">
							  <div class="row">
								  <div class="col-lg-4"><div class="filter-search">
                                <div class="form-group">
                                    <label> First Name  </label>
                                    <input type="text" class="form-control">
                                </div>
                            </div></div>
								  <div class="col-lg-4"><div class="filter-search">
                                <div class="form-group">
                                    <label> Last Name  </label>
                                    <input type="text" class="form-control">
                                </div>
                            </div></div>
								  <div class="col-lg-4"><div class="filter-search">
                                <div class="form-group">
                                    <label> Region  </label>
                                    <input type="text" class="form-control">
                                </div>
                            </div></div>
								  
							  </div>
                    <div class="row">
                        <div class="col-lg-4 pr-3">
                            <div class="filter-search">
                                <div class="form-group">
                                    <label> City </label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-lg-4">
                            <div class="filter-search">
                                <div class="form-group">
                                    <label> Experience years  </label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                        </div>
						 <div class="col-lg-4">
                            <div class="filter-search">
                                <div class="form-group">
                                    <label> Completion Status  </label>
                                      <select class="form-control">
                                        <option value="male"> Un-Completed </option>
                                        <option value="female"> Completed </option>
										<option value="female"> Submitted </option>
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
                                    <select class="form-control">
                                        <option value="male"> Male </option>
                                        <option value="female"> Female </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 pr-3">
                            <div class="filter-search">
                                <div class="form-group">
                                    <label> Application Status </label>
                                    <select class="form-control">
                                            <option selected="">Approved</option>
                                                <option value="1">Rejected</option>
                                                <option value="2">In Review</option>
												 <option value="3">Reviewed</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 pr-3">
                            <div class="filter-search">
                                <div class="form-group">
                                    <label> Graduate Degree </label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
							  <div class="row">
								  <div class="col-lg-12"><input type="button" class="btn btn-primary" value="Filter"/></div>
							  </div>
                </form>
                    </div>
                </div>
                
              
                <div class="row">
                    <div class="col-md-12" style="overflow-x: scroll">
                       <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Participants Data</h4>
                                <h6 class="card-subtitle">Export data to Excel, PDF & Print</h6>
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
                                            <tr>
                                                <td>Tiger Nixon</td>
                                                <td>System Architect</td>
                                                <td>Edinburgh</td>
                                                <td>61</td>
                                                <td>2011/04/25</td>
                                                <td>Approved</td>
                                                <td> &nbsp; <a href="profile.php" class="btn btn-success btn-circle"><i class="fa fa-edit"></i> </a>&nbsp;<button type="button" class="btn btn-danger btn-circle"><i class="fa fa-times"></i> </button>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>Garrett Winters</td>
                                                <td>Accountant</td>
                                                <td>Tokyo</td>
                                                <td>63</td>
                                                <td>2011/07/25</td>
                                                <td>Pending</td><td> &nbsp; <a href="profile.php" class="btn btn-success btn-circle"><i class="fa fa-edit"></i> </a>&nbsp;<button type="button" class="btn btn-danger btn-circle"><i class="fa fa-times"></i> </button>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>Ashton Cox</td>
                                                <td>Junior Technical Author</td>
                                                <td>San Francisco</td>
                                                <td>66</td>
                                                <td>2009/01/12</td>
                                                <td>Pending</td><td> &nbsp; <a href="profile.php" class="btn btn-success btn-circle"><i class="fa fa-edit"></i> </a>&nbsp;<button type="button" class="btn btn-danger btn-circle"><i class="fa fa-times"></i> </button>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>Cedric Kelly</td>
                                                <td>Senior Javascript Developer</td>
                                                <td>Edinburgh</td>
                                                <td>22</td>
                                                <td>2012/03/29</td>
                                                <td>Pending</td><td> &nbsp; <a href="profile.php" class="btn btn-success btn-circle"><i class="fa fa-edit"></i> </a>&nbsp;<button type="button" class="btn btn-danger btn-circle"><i class="fa fa-times"></i> </button>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>Airi Satou</td>
                                                <td>Accountant</td>
                                                <td>Tokyo</td>
                                                <td>33</td>
                                                <td>2008/11/28</td>
                                                <td>Pending</td><td> &nbsp; <a href="profile.php" class="btn btn-success btn-circle"><i class="fa fa-edit"></i> </a>&nbsp;<button type="button" class="btn btn-danger btn-circle"><i class="fa fa-times"></i> </button>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>Brielle Williamson</td>
                                                <td>Integration Specialist</td>
                                                <td>New York</td>
                                                <td>61</td>
                                                <td>2012/12/02</td>
                                                <td>Pending</td><td> &nbsp; <a href="profile.php" class="btn btn-success btn-circle"><i class="fa fa-edit"></i> </a>&nbsp;<button type="button" class="btn btn-danger btn-circle"><i class="fa fa-times"></i> </button>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>Herrod Chandler</td>
                                                <td>Sales Assistant</td>
                                                <td>San Francisco</td>
                                                <td>59</td>
                                                <td>2012/08/06</td>
                                                <td>Pending</td><td> &nbsp; <a href="profile.php" class="btn btn-success btn-circle"><i class="fa fa-edit"></i> </a>&nbsp;<button type="button" class="btn btn-danger btn-circle"><i class="fa fa-times"></i> </button>&nbsp;</td>
                                            </tr>
                                            
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
    <script src="../assets/node_modules/tablesaw-master/dist/tablesaw.js"></script>
    <script src="../assets/node_modules/tablesaw-master/dist/tablesaw-init.js"></script>
    
     <script src="../assets/node_modules/datatables/jquery.dataTables.min.js"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <!-- end - This is for export functionality only -->
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
                    [2, 'asc']
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
        });
    });
    $('#example23').DataTable({
        dom: 'Bfrtip',
        buttons: [
              'excel', 'pdf', 'print'
        ]
    });
    </script>
</body>

</html>