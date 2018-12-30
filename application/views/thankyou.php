<?php
/**
 * Created by PhpStorm.
 * User: rushikwin8
 * Date: 001 01-08-2018
 * Time: 08:23 PM
 */ ?>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <h1 class="text-success">Thank You For Your Feedback !</h1>
    </div>
    <?php if (isset($thankyou_image) && $thankyou_image != ''): ?>
        <div class="col-md-12 col-sm-12 " align="center">
            <img src="<?= base_url('images/thankyou/') . $thankyou_image; ?>" style="height: 500px;width: 500px;">
        </div>
    <?php endif; ?>
    <div class="col-md-12 col-sm-12" align="right">
        <button class="btn btn-pill btn-success"><img src="<?= base_url('images/home.png')?>" alt="home"> Go Back Home </button>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        setTimeout(function () {
            window.location = base_url;
        }, 15000);
    });
</script>
