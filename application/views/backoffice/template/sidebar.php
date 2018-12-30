<?php //sidebar ?>
<div class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- Home -->
                <li class="nav-devider"></li>
                <li class="nav-label">Home</li>
                <li> <a href="<?= base_url('backoffice/dashboard')?>" aria-expanded="false"><i class="fa fa-tachometer"></i>Dashboard</a></li>

                <!--Employee Management -->
                <li class="nav-devider"></li>
                <li class="nav-label">Employee Management</li>
                    <li><a href="<?= base_url('backoffice/Employee')?>" aria-expanded="false"><i class="fa fa-user-circle"></i>Employee management</a></li>
                    <li> <a href="<?= base_url('backoffice/Department')?>" aria-expanded="false"><i class="fa fa-user-circle"></i>Department management</a></li>
                    <li> <a href="<?= base_url('backoffice/ClassManagement')?>" aria-expanded="false"><i class="fa fa-user-circle"></i>Class management</a></li>
                    <li> <a href="<?= base_url('backoffice/EmployeeAllocation')?>" aria-expanded="false"><i class="fa fa-user-circle"></i>Employee Allocation</a></li>


                <!-- Records  -->
                <li class="nav-devider"></li>
                <li class="nav-label">Records</li>
                <li> <a href="<?= base_url('backoffice/EntryRecord')?>" aria-expanded="false"><i class="fa fa-arrow-circle-right"></i>Entry Record</a></li>
                <li> <a href="<?= base_url('backoffice/AnalysisRecord')?>" aria-expanded="false"><i class="fa fa-arrow-circle-right"></i>Analysis Record</a></li>
                <li> <a href="<?= base_url('backoffice/RemarksRecord')?>" aria-expanded="false"><i class="fa fa-arrow-circle-right"></i>Remarks Record</a></li>

                <!-- Analysis  -->
                <li class="nav-devider"></li>`
                <li class="nav-label">Analysis</li>
                <li> <a href="<?= base_url('backoffice/Analysis')?>" aria-expanded="false"><i class="fa fa-arrow-circle-right"></i>Analysis</a></li>

                <!--site Settings -->
                <li class="nav-devider"></li>
                <li class="nav-label">Site Settings</li>
                <li> <a href="<?= base_url('backoffice/SectionManagement')?>" aria-expanded="false"><i class="fa fa-arrow-circle-right"></i>Section Management</a></li>
                <li> <a href="<?= base_url('backoffice/CriteriaManagement')?>" aria-expanded="false"><i class="fa fa-arrow-circle-right"></i>Criteria management</a></li>
                <li> <a href="<?= base_url('backoffice/SiteManagement')?>" aria-expanded="false"><i class="fa fa-arrow-circle-right"></i>Site Management</a></li>

                <!--site Settings -->
                <li class="nav-devider"></li>
                <li class="nav-label">Database Settings</li>
                <li> <a href="<?= base_url('backoffice/DatabaseManagement')?>" aria-expanded="false"><i class="fa fa-database"></i>Database Management</a></li>


                <!-- Database Settings -->
                <!-- <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-envelope"></i><span class="hide-menu">Email</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="email-compose.html">Compose</a></li>
                        <li><a href="email-read.html">Read</a></li>
                        <li><a href="email-inbox.html">Inbox</a></li>
                    </ul>
                </li>-->

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</div>
