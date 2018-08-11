<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-collapse">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav mr-auto">
                <!-- This is  -->
                <li class="nav-item hidden-sm-up">
                    <a class="nav-link nav-toggler waves-effect waves-light" href="javascript:void(0)">
                        <i class="ti-menu"></i>
                    </a>
                </li>
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Search -->
                <!-- ============================================================== -->
                
            </ul>
            <ul class="navbar-nav my-lg-0">
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <img src="<?php echo $user['photo_id'] ? $this->attachment_library->render_url($user['photo_id']) : $base_url.'assets/panel/assets/images/users/nophoto.png'; ?>" alt="user" class="img-circle" width="30">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                        <span class="with-arrow">
                            <span class="bg-primary"></span>
                        </span>
                        <?php $admin = $this->user_session->get_session('admin'); ?>
                        <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                            <div class="">
                                <img src="<?php echo $user['photo_id'] ? $this->attachment_library->render_url($user['photo_id']) : $base_url.'assets/panel/assets/images/users/nophoto.png'; ?>" alt="user" class="img-circle" width="60">
                            </div>
                            <div class="m-l-10">
                                <h4 class="m-b-0"><?php echo $admin['first_name'] ?> <?php echo $admin['last_name'] ?></h4>
                                <p class=" m-b-0"><?php echo $admin['email'] ?></p>
                            </div>
                        </div>
                        
                        <a href="<?php echo $base_url ?>admin/signout" class="dropdown-item" href="javascript:void(0)">
                            <i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
                        <div class="dropdown-divider"></div>
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- End User profile and search -->
                <!-- ============================================================== -->
            </ul>
        </div>
    </nav>
</header>