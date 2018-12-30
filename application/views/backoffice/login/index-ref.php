<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?= base_url()?>/assets/images/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">

        <link rel="shortcut icon" href="<?= base_url()?>/assets/images/favicon.ico">
        <link rel="apple-touch-icon" sizes="57x57" href="<?= base_url()?>/assets/images/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?= base_url()?>/assets/images/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?= base_url()?>/assets/images/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url()?>/assets/images/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?= base_url()?>/assets/images/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url()?>/assets/images/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?= base_url()?>/assets/images/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url()?>/assets/images/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url()?>/assets/images/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?= base_url()?>/assets/images/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url()?>/assets/images/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?= base_url()?>/assets/images/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url()?>/assets/images/favicon-16x16.png">
        <link rel="manifest" href="<?= base_url()?>/assets/images/manifest.json">

        <title>India Ka Sales | Admin Login</title>

        <link href="<?= base_url()?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url()?>/assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url()?>/assets/css/style.css" rel="stylesheet" type="text/css" />

        <script src="<?= base_url()?>/assets/js/modernizr.min.js"></script>
        
        <style>
            .account-pages
            {
                background: #ebeff2; 
            }
            .wrapper-page .card-box
            {
                padding: 0px;
                border-radius: 0px;
                box-shadow: 1px 0px 20px #b3b3b3;
            }
            
            .clear-login .panel-heading
            {
                background: #ffffff;
                padding: 10px 0px 0px 0px;
            }
            
            .clear-login .logo-admin 
            {
                width: 160px !important;
                margin: 22px auto !important;
                height: auto;
                max-width: 100%;
                padding-bottom: 20px;
            }
            
            .panel-heading h3 strong 
            {
                font-weight: 500 !important;
                color: #2096f5 !important;
            }
            
            .panel-body 
            {
                border-top: 2px solid #999999;
                opacity: 0.8;
            }
            
            body form 
            {
                margin: 0px 35px 20px 35px;
            }
            
            .panel-body .form-control 
            {
                outline: none !important;
                z-index: 1;
                position: relative;
                background: none;
                width: 100%;
                height: 54px;
                border: 0;
                color: #999999;
                font-size: 20px;
                font-weight: 400;
                padding: 0px !important;
            }
            
            .label-box.form-group label 
            {
                color: #999999;
                padding: 0px;
                position: absolute;
                top: 25px;
                left: 0;
                -webkit-transition: all 0.25s ease;
                transition: all 0.25s ease;
                pointer-events: none;
            }
            
            .panel-body .bar 
            {
                position: absolute;
                left: 0px;
                bottom: -2px;
                background: #999999;
                width: 100%;
                height: 1px;
            }
            
            .panel-body .bar:before {
                content: '';
                position: absolute;
                background: #999999;
                width: 0;
                height: 3px;
                -webkit-transition: .2s ease;
                transition: .2s ease;
                left: 0;
            }
            
            .label-box 
            {
                position: relative;
            }
            
            body .panel-body .label-box input:focus ~ label,
			body .panel-body .label-box input:valid ~ label{
				font-size: 0.9em;
				color: #999999;
				top: -10px;
				-webkit-transition: all 0.125s ease;
				transition: all 0.125s ease;
			}
			
			body .panel-body .col-12 
			{
                padding: 0px;
            }
            
            .checkbox.checkbox-primary 
            {
                padding-left: 0;
            }
            
            .checkbox.checkbox-primary label 
            {
                cursor: pointer;
                font-size: 14px;
            }
            
            .checkbox-primary input[type="checkbox"]:checked + label::before 
            {
                background-color: #999999;
                border-color: #999999;
                border-radius: 0px;
            }
            
            .clear-login #loginForm_btn {
                border-radius: 0px !important;
            }
            
            .jwseed-theme-color 
            {
                background: #000000 !important;
                color: #fff;
                border-color: #000000 !important;
            }
            
            .btn-pink:hover, .btn-pink:focus, .btn-pink:active 
            {
                border-color: #999999 !important;
                background-color: #999999 !important;
            }
            
            .btn-pink
            {
                font-weight: 400;
                font-size: 1rem;
            }
            
            #frm_login label.error {
                top: 60px;
                color: red;
                font-size: 13px;
            }
            
        </style>
    </head>
    <body>

        <div class="account-pages"></div>
        <div class="clearfix"></div>
        <div class="wrapper-page">
            <div class="clear-login card-box">
                <div class="panel-heading text-center">
                	<div class="logo-admin">
                		<img alt="Admin Logo" src="<?= base_url('assets/images/IKS-Version1.png')?>" width="100%">
                	</div>
                	<div style="display:inline-block;">
                    	<div style="display: table;">
        		            <h3 class="text-center text-uppercase" style="padding: 0px 0px 10px 0px;display: table-cell;vertical-align: middle;"><strong class="text-custom jwseed-text-color">admin</strong></h3>
        	            </div>
        	       </div>
                </div>


                <div class="panel-body">
                <?php
					$attributes = array(
								'name' 		=> 'frm_login',
								'id' 		=> 'frm_login',
								'method'	=> 'post',
								'class'		=> 'form-horizontal m-t-20'

						);
					echo form_open( base_url(uri_string()), $attributes);
				?>
						<div class="form-group">
							<div id="error_msg" class="<?= ($this->session->flashdata('login_error')) ? 'text-danger' : 'hidden';?>" style="padding: 10px 0px;">
								<?= ($this->session->flashdata('login_error')) ? $this->session->flashdata('login_error') : "";?>
							</div>
						</div>
                        <div class="form-group label-box">
                            <div class="col-12 p-0">
                                <input name="user_email" class="form-control" type="text" required="required" value="">
                                <?= form_error("user_email","<label class='error'>","</label>")?>
                                <label>Username / Email</label>
								<div class="bar"></div>
                            </div>
                        </div>

                        <div class="form-group label-box">
                            <div class="col-12 p-0">
                                <input name="user_pass" class="form-control" type="password" required="required" value="">
                                <?= form_error("user_pass","<label class='error'>","</label>")?>
                                <label>Password</label>
								<div class="bar"></div>
                            </div>
                        </div>

                        <div class="form-group m-t-30">
                            <div class="col-12">
                                <div class="checkbox checkbox-primary">
                                    <input id="checkbox-signup" type="checkbox">
                                    <label for="checkbox-signup">
                                        Remember me
                                    </label>
                                </div>

                            </div>
                        </div>

                        <div class="form-group text-center m-t-40">
                            <div class="col-12">
                                <button id="loginForm_btn" class="btn btn-pink btn-block text-uppercase waves-effect waves-light jwseed-theme-color"
                                        type="submit">Log In
                                </button>
                            </div>
                        </div>

                        <div class="form-group m-t-30 m-b-0">
                            <div class="col-12 text-center">
                                <a href="javascript:void(0)" class="text-dark"><i class="fa fa-lock m-r-5"></i> Forgot
                                    your password?</a>
                            </div>
                        </div>
                    <?php echo form_close()?>

                </div>
            </div>
            
        </div>
        
    	<script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="<?= base_url()?>/assets/js/jquery.min.js"></script>
        <script src="<?= base_url()?>/assets/js/popper.min.js"></script><!-- Popper for Bootstrap -->
        <script src="<?= base_url()?>/assets/js/bootstrap.min.js"></script>
        <script src="<?= base_url()?>/assets/js/detect.js"></script>
        <script src="<?= base_url()?>/assets/js/fastclick.js"></script>
        <script src="<?= base_url()?>/assets/js/jquery.slimscroll.js"></script>
        <script src="<?= base_url()?>/assets/js/jquery.blockUI.js"></script>
        <script src="<?= base_url()?>/assets/js/waves.js"></script>
        <script src="<?= base_url()?>/assets/js/wow.min.js"></script>
        <script src="<?= base_url()?>/assets/js/jquery.nicescroll.js"></script>
        <script src="<?= base_url()?>/assets/js/jquery.scrollTo.min.js"></script>
        <script src="<?= base_url()?>/assets/plugins/jquery-validation/js/jquery.validate.min.js"></script>

        <script src="<?= base_url()?>/assets/js/jquery.core.js"></script>
        <script src="<?= base_url()?>/assets/js/jquery.app.js"></script>
        
        <script type="text/javascript">
			$("#frm_login").validate({
				rules:
				{
					user_email : {required : true},
					user_pass : {required : true},
				},
				messages:
				{
					user_email : {required : "This field is required."},
					user_pass : {required : "This field is required."},
				}
			});

			setTimeout(function(){
				$('#error_msg').addClass('hidden').removeClass('text-danger').html('');
			},5000);

        </script>
	
	</body>
</html>