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
                <h1 class="text-themecolor">Administrators</h1>
            </div>

        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <form method="post">
            <div class="row align-items-center">
                <!-- column -->
                <div class="col-lg-4">
                    <div class="form-group">
                        <a href="<?php echo $base_url ?>panel/admin/add" class="btn btn-primary btn-block">Add Administrator</a>
                    </div>
                </div>
                <!-- column -->
            </div>
        </form>

        <?php show_success_message(); ?>

        <div class="row admins-list">
            <div class="col-lg-12">
                <h2>Admins</h2>
            </div>
            <div class="col-lg-12">

                <ul class="list-unstyled">
                    
                    <?php foreach ($admins as $admin) { ?>
                    <li class="admin-list-item  d-flex align-items-center">
                        <img class="d-flex mr-3 admin-profile-image" src="<?php echo $admin['photo_id'] ? $this->attachment_library->render_url($admin['photo_id']) : $base_url.'assets/panel/assets/images/users/nophoto.png'; ?>" />
                        <div class="admin-info">
                            <h4><?php echo $admin['first_name']; ?> <?php echo $admin['last_name']; ?></h4>
                            <span>City <?php echo $admin['city'] ?></span><br/>
                            <a href="<?php echo $base_url ?>panel/admin/edit/<?php echo $admin['user_id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="<?php echo $base_url ?>panel/admin/delete/<?php echo $admin['user_id'] ?>" class="btn btn-sm btn-danger">Delete</a>
                        </div>
                        <div class="admin-roles">
                            <h4><?php echo ucwords($admin['role']) ?> Role</h4>
                        </div>
                    </li>
                    <?php } ?>

                </ul>
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