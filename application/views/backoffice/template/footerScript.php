<?php // js scripts and custom.js ?>

<!-- slimscrollbar scrollbar JavaScript -->
<script src="<?= base_url('assets/backoffice/') ?>js/jquery.slimscroll.js"></script>
<!--Menu sidebar -->
<script src="<?= base_url('assets/backoffice/') ?>js/sidebarmenu.js"></script>

<!--stickey kit -->
<script src="<?= base_url('assets/backoffice/') ?>js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
<!--Custom JavaScript -->


<!-- Amchart -->

<script src="<?= base_url('assets/backoffice/') ?>js/lib/morris-chart/raphael-min.js"></script>
<script src="<?= base_url('assets/backoffice/') ?>js/lib/morris-chart/morris.js"></script>
<script src="<?= base_url('assets/backoffice/') ?>js/lib/morris-chart/dashboard1-init.js"></script>


<script src="<?= base_url('assets/backoffice/') ?>js/lib/calendar-2/moment.latest.min.js"></script>
<!-- scripit init-->
<script src="<?= base_url('assets/backoffice/') ?>js/lib/calendar-2/semantic.ui.min.js"></script>
<!-- scripit init-->
<script src="<?= base_url('assets/backoffice/') ?>js/lib/calendar-2/prism.min.js"></script>
<!-- scripit init-->
<script src="<?= base_url('assets/backoffice/') ?>js/lib/calendar-2/pignose.calendar.min.js"></script>
<!-- scripit init-->
<script src="<?= base_url('assets/backoffice/') ?>js/lib/calendar-2/pignose.init.js"></script>

<script src="<?= base_url('assets/backoffice/') ?>js/lib/owl-carousel/owl.carousel.min.js"></script>
<script src="<?= base_url('assets/backoffice/') ?>js/lib/owl-carousel/owl.carousel-init.js"></script>
<script src="<?= base_url('assets/backoffice/') ?>js/scripts.js"></script>

<!-- Include Again Duew To above script -->
<script src="<?= base_url('assets/backoffice/') ?>js/lib/bootstrap/js/bootstrap.min.js"></script>
<!-- bootstrap selectpiker -->
<script src="<?= base_url() ?>assets/backoffice/plugins/bootstrap-select/js/bootstrap-select.min.js"></script>
<!-- script init -->

<!-- core js for internet explorere -->
<script src="<?= base_url() ?>assets/backoffice/js/lib/core.js"></script>
<!-- jquery validation -->
<script src="<?= base_url() ?>assets/backoffice/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>assets/backoffice/plugins/jquery-validation/js/additional-methods.js"></script>
<script src="<?= base_url() ?>assets/backoffice/plugins/modern-blink/jquery.modern-blink.js"></script>

<script src="<?= base_url('assets/backoffice/') ?>js/custom.min.js"></script>

<script type="text/javascript">

    function ajaxModel(url, title, width) {
        if (typeof(width) === 'undefined') {
            width = 'modal-lg';
        }

        //check user
        $.ajax({
            async:false,
            url: base_url + 'backoffice/Login/checkUser',
            dataType: "json",
            success: function (responce) {

                if (responce.code === 0) {

                    swal({
                        type: 'error',
                        title: 'Oops...',
                        text: responce.message
                    }).then(function (result) {}).catch(swal.noop);


                } else if (responce.code === 2) {
                    swal({
                        type: 'error',
                        title: 'Oops...',
                        text: responce.message
                    }).then(function (result) {}).catch(swal.noop);

                } else if(responce.code === 1){
                    if (url) {
                            $.ajax({
                                async:false,
                                url: SITE_URL + url,
                                dataType: 'html',
                                success: function (responce) {
                                    $('#feedback_admin_modal .modal-title').html(title);
                                    $('#feedback_admin_modal .modal-body').html(responce);
                                    $('#feedback_admin_modal .modal-dialog').addClass(width);

                                    if (!$('#feedback_admin_modal').hasClass('show')) {
                                        $('#feedback_admin_modal').modal('show');
                                    }

                                }
                            });
                        } else {
                            console.log('error');
                        }
                    }
            },
            error: function (response) {

            }
        });

    }//ajaxmodel end

    jQuery(document).ready(function ($) {

        //blink text
        $('.blink').modernBlink({
            duration: 3000
        });

        //summernote
        $('.summernote').summernote();

        <?php if($this->session->flashdata('error')) : ?>
        toastr["error"]('<?= $this->session->flashdata('error') ?>', "Error");
        <?php elseif($this->session->flashdata('success')) : ?>
        toastr["success"]('<?= $this->session->flashdata('success') ?>', "Success");
        <?php endif; ?>


            var checkuser = setInterval(function(){
                //check user
                $.ajax({
                    async: false,
                    url: base_url + 'backoffice/Login/checkUser',
                    dataType: "json",
                    success: function (responce) {

                        if (responce.code === 0) {

                            swal({
                                type: 'error',
                                title: 'Oops...',
                                text: responce.message
                            }).then(function (result) {

                            }).catch(swal.noop);
                            window.location = base_url + 'backoffice/login/logout';
                            window.clearInterval(checkuser); //pause



                        } else if (responce.code === 2) {
                            swal({
                                type: 'error',
                                title: 'Oops...',
                                text: responce.message
                            }).then(function (result) {

                            }).catch(swal.noop);
                            window.location = base_url + 'backoffice/login/logout';
                            window.clearInterval(checkuser); //pause
                        } else if (responce.code === 1) {
                            //continue
                        }
                    }, error: function (responce) {

                    }
                });
            },3000);

    });
</script>