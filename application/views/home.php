<?php /**
 * Created by PhpStorm.
 * User: jatin
 * Date: 010 10-06-2018
 * Time: 01:12 PM
 */ ?>
<div id="fronthome_heading">
    <?= $site_settings[0]['settings_value']; ?>
</div>
<div class="row">

    <?php if (isset($imagelist) && !empty($imagelist)):?>
    <div class="col-md-12 col-sm-12">
        <div id="MiddleCarousel" class="carousel slide UACarousel" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php $i = 0; ?>
                <?php foreach ($imagelist as $row): ?>
                    <li data-target="#MiddleCarousel" data-slide-to="<?= $i++; ?>"></li>
                <?php endforeach; ?>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" style="height: 500px;width: 500px" src="<?= base_url('images/slider-image/') . $imagelist[0]; ?>"
                         alt="not image found">
                </div>
                <?php unset($imagelist[0]);?>
                <?php foreach ($imagelist as $row): ?>
                    <div class="carousel-item">
                        <img class="d-block w-100" style="height: 500px;width: 500px" src="<?= base_url('images/slider-image/') . $row; ?>"
                             alt="not image found">
                    </div>
                <?php endforeach; ?>
            </div>
            <a class="carousel-control-prev" href="#MiddleCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#MiddleCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <?php endif;?>
</div>
