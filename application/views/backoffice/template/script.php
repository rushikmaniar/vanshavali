<?php // css and js scripts to load ?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url();?>images/favicon.png">
    <title><?= $this->pageTitle ?></title>
    <!-- Bootstrap Core CSS -->
    <link href="<?= base_url('assets/backoffice/');?>css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/backoffice/');?>css/lib/calendar2/semantic.ui.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/backoffice/');?>css/lib/calendar2/pignose.calendar.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/backoffice/');?>css/lib/owl.carousel.min.css" rel="stylesheet" />
    <link href="<?= base_url('assets/backoffice/');?>css/lib/owl.theme.default.min.css" rel="stylesheet" />
    <link href="<?= base_url('assets/backoffice/');?>css/helper.css" rel="stylesheet">
    <!-- Data table css-->
    <!--<link href="<?/*= base_url();*/?>assets/backoffice/css/lib/data-table/dataTables.bootstrap.min.css" rel="stylesheet">-->
    <link href="<?= base_url('assets/backoffice/');?>css/style.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
    <!--[if lt IE 9]>
    <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- All Jquery -->
    <script src="<?= base_url('assets/backoffice/')?>js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?= base_url('assets/backoffice/')?>js/lib/bootstrap/js/popper.min.js"></script>
    <script src="<?= base_url('assets/backoffice/')?>js/lib/bootstrap/js/bootstrap.min.js"></script>

    <!-- Bootstrap Select -->
    <link href="<?= base_url('assets/backoffice/');?>/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet">
    <script src="<?= base_url('assets/backoffice/')?>/plugins/bootstrap-select/js/bootstrap-select.min.js"></script>

    <!-- Select2 -->
    <link href="<?= base_url();?>assets/backoffice/plugins/select2/css/select2.min.css" rel="stylesheet">
    <script src="<?= base_url()?>assets/backoffice/plugins/select2/js/select2.min.js"></script>

    <!-- toaster -->
    <link href="<?= base_url();?>assets/backoffice/css/lib/toastr/toastr.min.css" rel="stylesheet">
    <script src="<?= base_url().'assets/backoffice/js/lib/toastr/toastr.min.js'?>"></script>

    <!-- Datatable js-->
    <script src="<?= base_url()?>assets/backoffice/js/lib/datatables/datatables.min.js"></script>
    <script src="<?= base_url()?>assets/backoffice/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url()?>assets/backoffice/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="<?= base_url()?>assets/backoffice/js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="<?= base_url()?>assets/backoffice/js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="<?= base_url()?>assets/backoffice/js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="<?= base_url()?>assets/backoffice/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="<?= base_url()?>assets/backoffice/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>

    <!-- Sweet Alert 2 -->
    <link href="<?= base_url();?>assets/backoffice/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet">
    <script src="<?= base_url()?>assets/backoffice/plugins/sweet-alert2/sweetalert2.min.js"></script>

    <!-- Summer Note-->
    <link href="<?= base_url();?>assets/backoffice/plugins/summernote/summernote.css" rel="stylesheet">
    <script src="<?= base_url()?>assets/backoffice/plugins/summernote/summernote.min.js"></script>

    <!-- Drop Zone-->
    <link href="<?= base_url();?>assets/backoffice/plugins/dropzone/dropzone.css" rel="stylesheet">
    <script src="<?= base_url()?>assets/backoffice/plugins/dropzone/dropzone.js"></script>

    <script type="text/javascript">
        var base_url = "<?= base_url();?>";
        var SITE_URL = "<?= site_url(); ?>";
    </script>
</head>
