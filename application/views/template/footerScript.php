<?php // js scripts and custom.js ?>
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>


<!-- blink.js -->
<script src="<?= base_url().'assets/fronted/plugins/modern-blink/jquery.modern-blink.js'?>"></script>

<!-- jquery step.js -->
<script src="<?= base_url().'assets/fronted/plugins/jquery.steps/js/jquery.steps.min.js'?>"></script>

<!-- jquery validation.js -->
<script src="<?= base_url().'assets/fronted/plugins/jquery-validation/js/jquery.validate.min.js'?>"></script>
<script src="<?= base_url().'assets/fronted/plugins/jquery-validation/js/additional-methods.js'?>"></script>

<!-- select2.js -->
<script src="<?= base_url().'assets/fronted/plugins/select2/js/select2.min.js';?>"></script>
<!-- tostr -->
<script src="<?= base_url().'assets/fronted/plugins/toastr/toastr.min.js';?>"></script>

<!-- responsiveslide -->
<script src="<?= base_url().'assets/fronted/plugins/responsiveslides/responsiveslides.min.js';?>"></script>

<script src="<?= base_url().'assets/fronted/js/shards.min.js'?>"></script>

<script type="text/javascript">

    $(document).ready(function () {
        //blink text
        $('.blink').modernBlink({
            duration: 2000
        });
        <?php if($this->session->flashdata('error')) : ?>
        toastr["error"]('<?= $this->session->flashdata('error') ?>', "Error");
        <?php elseif($this->session->flashdata('success')) : ?>
        toastr["success"]('<?= $this->session->flashdata('success') ?>', "Success");
        <?php endif; ?>
    });
    function ajaxModel(url, title, width) {
        if (typeof(width) === 'undefined') {
            width = 'modal-lg';
        }
        if (url) {
            $.ajax({
                url: SITE_URL + url,
                dataType: 'html',
                success: function (responce) {
                    $('#feedback_frontsite_modal .modal-title').html(title);
                    $('#feedback_frontsite_modal .modal-body').html(responce);
                    $('#feedback_frontsite_modal .modal-dialog').addClass(width);

                    if (!$('#feedback_frontsite_modal').hasClass('show')) {
                        $('#feedback_frontsite_modal').modal('show');
                    }

                }
            });
        }
    }
</script>
