<!DOCTYPE html>
<html lang="en">
<!-- Loading All Scripts -->
<?php $this->load->view('backoffice/template/script.php'); ?>
<body class="fix-header fix-sidebar">
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
    </svg>
</div>

<!-- Main wrapper  -->
<div id="main-wrapper">
    <!-- header header  -->
    <?php $this->load->view('backoffice/template/header.php'); ?>
    <!-- End header header -->
    <!-- Left Sidebar  -->
    <?php $this->load->view('backoffice/template/sidebar.php'); ?>
    <!-- End Left Sidebar  -->
    <!-- Page wrapper  -->
    <div class="page-wrapper">
        <!-- Bread crumb -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary"><?= $this->pageTitle; ?></h3></div>
            <div class="col-md-7 align-self-center">
                <!--<ol class="breadcrumb">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>-->
            </div>
        </div>
        <!-- End Bread crumb -->
        <!-- Container fluid  -->
        <div class="container-fluid">

            <div class="content">
                <div class="container-fluid">

                    <?= $page_content ?>

                </div> <!-- container -->

            </div>
            <!-- End PAge Content -->
        </div>
        <!-- End Container fluid  -->
        <!-- footer -->
        <?php $this->load->view('backoffice/template/footer.php'); ?>
        <!-- End footer -->
    </div>
    <!-- End Page wrapper  -->
</div>
<!-- End Wrapper -->
<?php $this->load->view('backoffice/template/footerScript.php'); ?>
</body>

</html>