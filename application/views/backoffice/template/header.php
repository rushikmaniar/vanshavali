<?php //header of page ?>
<!-- Preloader - style you can find in spinners.css -->
<div class="header">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <!-- Logo -->
        <div class="navbar-header">
            <a class="navbar-brand" href="<?= base_url()?>/backoffice/">
                <!-- Logo icon -->
                <b><img src="<?= base_url('assets/backoffice')?>/images/logo.png" alt="homepage" class="dark-logo" /></b>
                <!--End Logo icon -->
                <!-- Logo text -->
               <!-- <span><img src="<?/*= base_url('assets/backoffice')*/?>/images/logo-text.png" alt="homepage" class="dark-logo" /></span>-->
            </a>
        </div>
        <!-- End Logo -->
        <div class="navbar-collapse">
            <!-- toggle and nav items -->
            <ul class="navbar-nav mr-auto mt-md-0">

            </ul>
            <!-- User profile and search -->
            <ul class="navbar-nav my-lg-0">
                <!-- Profile -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?= base_url('uploads/user/profile/').$this->session->userdata('feedback-admin')['user_image']?>" onerror="this.src='<?= base_url(); ?>assets/backoffice/images/users/5.jpg'" alt="user" class="profile-pic" /></a>
                    <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                        <ul class="dropdown-user">
                            <li><a href="<?= base_url('backoffice/Profile')?>"><i class="ti-user"></i> Profile</a></li>
                            <li><a href="javascript:void(0);" onclick="ajaxModel('backoffice/Profile/viewChangePasswordModel','Change Password','modal-md')"><i class="ti-settings"></i> Change Password</a></li>
                            <li><a href="<?= base_url('backoffice/Login/logout')?>"><i class="fa fa-power-off"></i> Logout</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>