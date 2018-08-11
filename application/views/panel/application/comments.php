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
                <h1 class="text-themecolor">Application Comments</h1>
            </div>

        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        
        
        
        <div class="row">
            <div class="col-md-12" style="overflow-x: scroll">
               <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Application Comments</h4>
                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Application #</th>
                                        <th>User</th>
                                        <th>Comment</th>
                                        <th>Date Time</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Application #</th>
                                        <th>User</th>
                                        <th>Comment</th>
                                        <th>Date Time</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($comments as $comment) { ?>
                                    <tr>
                                        <td><a target="_blank" href="<?php echo $base_url ?>panel/application/view/<?php echo $comment['user']['user_id'] ?>">#<?php echo $comment['user']['auto_id']; ?></a></td>
                                        <td><?php echo $comment['commenter']['first_name'] ?> <?php echo $comment['commenter']['last_name'] ?></td>
                                        <td><?php echo $comment['comment'] ?></td>
                                        <td><?php echo format_date_time($comment['created_on']); ?></td>
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
    });
});

$(document).ready(function() {
    $('#example23').DataTable({
        dom: 'Bfrtip',
        "order": [
            [4, 'desc']
        ],
        buttons: [
              'excel', 'pdf', 'print'
        ]
    });
});    
</script>