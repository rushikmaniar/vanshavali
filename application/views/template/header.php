<?php //header ?>
<div class="loader">
    <div class="page-loader"></div>
</div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <img src="<?= base_url().'images/front-logo.png';?>" style="background:none;" alt="Feedback 1" class="mr-2" height="80">
    <a class="navbar-brand" href="<?= base_url(); ?>">Feedback</a>
    <div class="pull-right">

    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown-1" aria-controls="navbarNavDropdown-1"
            aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown-1">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home
                    <span class="sr-only">(current)</span>
                </a>
        </ul>

        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('startfeedback')?>">
                    <button class="btn btn-pill btn-success"><i class="fa fa-arrow-right"></i> Start Feedback</button>
                </a>
            </li>
        </ul>
    </div>
</nav>