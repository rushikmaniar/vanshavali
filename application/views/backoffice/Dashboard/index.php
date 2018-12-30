<?php
/**
 * Created by PhpStorm.
 * User: Rushik
 * Date: 23-04-2018
 * Time: 11:08 AM
 */
?>

<div class="row">
    <div class="col-md-3">
        <a href="<?= base_url('backoffice/Employee') ?>">
            <div class="card p-30">
                <div class="media">
                    <div class="media-left meida media-middle">
                        <span><i class="ti-user f-s-40 color-primary"></i></span>
                    </div>
                    <div class="media-body media-text-right">
                        <h2><?= $records['total_employees']?></h2>
                        <p class="m-b-0">Employees</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="<?= base_url('backoffice/ClassManagement') ?>">
            <div class="card p-30">
                <div class="media">
                    <div class="media-left meida media-middle">
                        <span><i class="ti-blackboard f-s-40 color-success"></i></span>
                    </div>
                    <div class="media-body media-text-right">
                        <h2><?= $records['total_class']?></h2>
                        <p class="m-b-0">Classes</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="<?= base_url('backoffice/EntryRecord') ?>">
            <div class="card p-30">
                <div class="media">
                    <div class="media-left meida media-middle">
                        <span><i class="ti-write f-s-40 color-warning"></i></span>
                    </div>
                    <div class="media-body media-text-right">
                        <h2><?= $records['total_entries']?></h2>
                        <p class="m-b-0">Total Feedback</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="<?= base_url('CriteriaManagement') ?>">
            <div class="card p-30">
                <div class="media">
                    <div class="media-left meida media-middle">
                        <span><i class="ti-settings f-s-40 color-danger"></i></span>
                    </div>
                    <div class="media-body media-text-right">
                        <h2><?= $records['total_criterias']?></h2>
                        <p class="m-b-0">Criterias</p>
                    </div>
                </div>
            </div>
        </a>
    </div>



    <!-- calender -->
    <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="year-calendar"><div class="pignose-calendar pignose-calendar-blue pignose-calendar-default">												<div class="pignose-calendar-top">													<a href="#" class="pignose-calendar-top-nav pignose-calendar-top-prev">														<span class="icon-arrow-left pignose-calendar-top-icon"></span>													</a>													<div class="pignose-calendar-top-date">														<span class="pignose-calendar-top-month">July</span>														<span class="pignose-calendar-top-year">2018</span>													</div>													<a href="#" class="pignose-calendar-top-nav pignose-calendar-top-next">														<span class="icon-arrow-right pignose-calendar-top-icon"></span>													</a>												</div>												<div class="pignose-calendar-header"><div class="pignose-calendar-week pignose-calendar-week-sun">SUN</div><div class="pignose-calendar-week pignose-calendar-week-mon">MON</div><div class="pignose-calendar-week pignose-calendar-week-tue">TUE</div><div class="pignose-calendar-week pignose-calendar-week-wed">WED</div><div class="pignose-calendar-week pignose-calendar-week-thu">THU</div><div class="pignose-calendar-week pignose-calendar-week-fri">FRI</div><div class="pignose-calendar-week pignose-calendar-week-sat">SAT</div></div>												<div class="pignose-calendar-body"><div class="pignose-calendar-row"><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-sun" data-date="2018-07-01"><a href="#">1</a></div><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-mon" data-date="2018-07-02"><a href="#">2</a></div><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-tue" data-date="2018-07-03"><a href="#">3</a></div><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-wed" data-date="2018-07-04"><a href="#">4</a></div><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-thu" data-date="2018-07-05"><a href="#">5</a></div><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-fri" data-date="2018-07-06"><a href="#">6</a></div><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-sat" data-date="2018-07-07"><a href="#">7</a></div></div><div class="pignose-calendar-row"><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-sun" data-date="2018-07-08"><a href="#">8</a></div><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-mon" data-date="2018-07-09"><a href="#">9</a></div><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-tue" data-date="2018-07-10"><a href="#">10</a></div><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-wed" data-date="2018-07-11"><a href="#">11</a></div><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-thu" data-date="2018-07-12"><a href="#">12</a></div><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-fri" data-date="2018-07-13"><a href="#">13</a></div><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-sat" data-date="2018-07-14"><a href="#">14</a></div></div><div class="pignose-calendar-row"><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-sun" data-date="2018-07-15"><a href="#">15</a></div><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-mon" data-date="2018-07-16"><a href="#">16</a></div><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-tue" data-date="2018-07-17"><a href="#">17</a></div><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-wed" data-date="2018-07-18"><a href="#">18</a></div><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-thu" data-date="2018-07-19"><a href="#">19</a></div><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-fri" data-date="2018-07-20"><a href="#">20</a></div><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-sat" data-date="2018-07-21"><a href="#">21</a></div></div><div class="pignose-calendar-row"><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-sun" data-date="2018-07-22"><a href="#">22</a></div><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-mon" data-date="2018-07-23"><a href="#">23</a></div><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-tue pignose-calendar-unit-active pignose-calendar-unit-first-active" data-date="2018-07-24"><a href="#">24</a></div><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-wed" data-date="2018-07-25"><a href="#">25</a></div><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-thu" data-date="2018-07-26"><a href="#">26</a></div><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-fri" data-date="2018-07-27"><a href="#">27</a></div><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-sat" data-date="2018-07-28"><a href="#">28</a></div></div><div class="pignose-calendar-row"><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-sun" data-date="2018-07-29"><a href="#">29</a></div><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-mon" data-date="2018-07-30"><a href="#">30</a></div><div class="pignose-calendar-unit pignose-calendar-unit-date pignose-calendar-unit-tue" data-date="2018-07-31"><a href="#">31</a></div><div class="pignose-calendar-unit pignose-calendar-unit-wed"></div><div class="pignose-calendar-unit pignose-calendar-unit-thu"></div><div class="pignose-calendar-unit pignose-calendar-unit-fri"></div><div class="pignose-calendar-unit pignose-calendar-unit-sat"></div></div></div>											</div></div>
            </div>
        </div>
    </div>

</div>
