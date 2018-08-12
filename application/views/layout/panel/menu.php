 <aside class="left-sidebar">
            <div class="left-sidebar-header d-flex no-block nav-text-box align-items-center">
                <span>
                    <img src="<?php echo $base_url; ?>assets/panel/admin/../assets/images/logo.jpeg" alt="user" width="80">
                </span>

            </div>
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <?php if($this->app_library->is_role_session('admin')) { ?>
                        <li>
                            <a class="active waves-effect waves-dark" href="<?php echo $base_url ?>panel/application" aria-expanded="false">
                                <i class="icon-speedometer"></i>
                                <span class="hide-menu">Dashboard

                                </span>
                            </a>
                        </li>
                        <?php } ?>
                        <?php if($this->app_library->is_role_session('admin')) { ?>
                            <li>
                                <a class=" waves-effect waves-dark" href="<?php echo $base_url ?>panel/application/listing/all" aria-expanded="false">
                                    <i class="mdi mdi-account-multiple"></i>
                                    <span class="hide-menu">All Applications</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if($this->app_library->is_role_session('reviewer')) { ?>
                            <li>
                                <a class=" waves-effect waves-dark" href="<?php echo $base_url ?>panel/application/listing/draft" aria-expanded="false">
                                    <i class="mdi mdi-account-multiple"></i>
                                    <span class="hide-menu">Draft Applications</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if($this->app_library->is_role_session('reviewer')) { ?>
                            <li>
                                <a class=" waves-effect waves-dark" href="<?php echo $base_url ?>panel/application/listing/submitted" aria-expanded="false">
                                    <i class="mdi mdi-account-multiple"></i>
                                    <span class="hide-menu">Submitted Applications</span>
                                </a>
                            </li>
                        <?php } ?>
                        <li>
                            <a class=" waves-effect waves-dark" href="<?php echo $base_url ?>panel/application/listing/approved" aria-expanded="false">
                                <i class="mdi mdi-account-multiple"></i>
                                <span class="hide-menu">Approved Applications</span>
                            </a>
                        </li>
                        <li>
                            <a class=" waves-effect waves-dark" href="<?php echo $base_url ?>panel/application/listing/declined" aria-expanded="false">
                                <i class="mdi mdi-account-multiple"></i>
                                <span class="hide-menu">Declined Applications</span>
                            </a>
                        </li>
                        <?php if($this->app_library->is_role_session('admin')) { ?>
                            <li>
                                <a class=" waves-effect waves-dark" href="<?php echo $base_url ?>panel/application/listing/conflicted" aria-expanded="false">
                                    <i class="mdi mdi-account-multiple"></i>
                                    <span class="hide-menu">Conflicted Applications</span>
                                </a>
                            </li>
                        <?php } ?>
                        <li>
                            <a class=" waves-effect waves-dark" href="<?php echo $base_url ?>panel/application/comments" aria-expanded="false">
                                <i class="mdi mdi-comment"></i>
                                <span class="hide-menu">Application Comments

                                </span>
                            </a>
                        </li>
                        <li>
                            <a class=" waves-effect waves-dark" href="<?php echo $base_url ?>panel/application/notifications" aria-expanded="false">
                                <i class="mdi mdi-comment"></i>
                                <span class="hide-menu">Updates

                                </span>
                            </a>
                        </li>
                        <?php if($this->app_library->is_role_session('admin')) { ?>
                        <li>
                            <a class=" waves-effect waves-dark" href="<?php echo $base_url ?>panel/admin/broadcast" aria-expanded="false">
                                <i class="fa fa-podcast"></i>
                                <span class="hide-menu">Broadcast

                                </span>
                            </a>
                        </li>
                        <?php } ?>
                        <?php if($this->app_library->is_role_session('admin')) { ?>
                        <li>
                            <a class=" waves-effect waves-dark" href="<?php echo $base_url ?>panel/application/insights" aria-expanded="false">
                                <i class="fa fa-lightbulb-o"></i>
                                <span class="hide-menu">Insights

                                </span>
                            </a>
                        </li>
                        <?php } ?>
                        <?php /* ?>
                        <li>
                            <a class=" waves-effect waves-dark" href="<?php echo $base_url ?>panel/admin/setting" aria-expanded="false">
                                <i class="fa fa-info-circle"></i>
                                <span class="hide-menu">Submission Settings

                                </span>
                            </a>
                        </li>
                        <?php /**/ ?>
                        <?php if($this->app_library->is_role_session('admin')) { ?>
                        <li>
                            <a class=" waves-effect waves-dark" href="<?php echo $base_url ?>panel/admin/listing" aria-expanded="false">
                                <i class="fa fa-flag"></i>
                                <span class="hide-menu">Access Management

                                </span>
                            </a>
                        </li>
                        <?php } ?>
                        <?php if($this->app_library->is_role_session('admin')) { ?>
                        <li>
                            <a class=" waves-effect waves-dark" href="<?php echo $base_url ?>panel/log/listing" aria-expanded="false">
                                <i class="fa fa-align-justify"></i>
                                <span class="hide-menu">Workflow Logs

                                </span>
                            </a>
                        </li>
                        
                        <li>
                            <a class=" waves-effect waves-dark" href="<?php echo $base_url ?>panel/admin/setting" aria-expanded="false">
                                <i class="fa fa-align-justify"></i>
                                <span class="hide-menu">Settings</span>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>