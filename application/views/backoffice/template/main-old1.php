<!DOCTYPE html>
<html>
   
	<?php $this->load->view('backoffice/template/script.php'); ?>

    <body class="fixed-left">

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <?php $this->load->view('backoffice/template/header.php'); ?>
            <!-- Top Bar End -->

            <!-- ========== Left Sidebar Start ========== -->
            <?php $this->load->view('backoffice/template/sidebar.php'); ?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container-fluid">
						<?= $page_content?>

                    </div> <!-- container -->

                </div> <!-- content -->

                <?php $this->load->view('backoffice/template/footer.php'); ?>

            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->

			 <?php $this->load->view('backoffice/template/footerScript.php'); ?>

    </body>
</html>