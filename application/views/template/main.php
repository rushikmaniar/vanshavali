<!DOCTYPE html>
<html lang="en">
<!--Css Load Files -->
<?php  $this->load->view('template/scripts');?>
<body>
<!--Header Section-->

<?php $this->load->view('template/header'); ?>
<!--Header Section End-->

<!-- Body Part Starts -->
<div id="page-content">
    <?php echo $page_content;?>
</div>
<!-- Body Part Ends -->

<!--Footer Section-->
<?php $this->load->view('template/footer');?>
<!--end Footer Section-->

<!-- Footer script section-->
<?php $this->load->view('template/footerScript');?>
<!-- end Footer script section-->

</body>
</html>