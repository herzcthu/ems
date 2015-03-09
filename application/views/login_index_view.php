<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title><?php echo $page_title;?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="Election Monitoring System" name="description"/>
<meta content="Sithu Thwin, Daniel Su" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url('asset/plugins/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url('asset/plugins/simple-line-icons/simple-line-icons.min.css');?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url('asset/plugins/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url('asset/plugins/uniform/css/uniform.default.css');?>" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?php echo base_url('asset/plugins/select2/select2.css');?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url('asset/css/login.css');?>" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME STYLES -->
<link href="<?php echo base_url('asset/css/components.css');?>" id="style_components" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url('asset/css/plugins.css');?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url('asset/css/layout.css');?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url('asset/css/themes/default.css');?>" rel="stylesheet" type="text/css" id="style_color"/>
<link href="<?php echo base_url('asset/css/custom.css');?>" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN LOGO -->
<div class="logo">
	<a href="/login">
	<img src="<?php echo base_url('asset/img/logo-big.png');?>" alt=""/>
	</a>
</div>
<!-- END LOGO -->
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGIN -->
<div class="content">
	<!-- BEGIN LOGIN FORM -->
	<form class="login-form" action="#" method="post">
		<h3 class="form-title"><?php echo lang('common_login_form_title');?></h3>
		<?php echo validation_errors('<div class="alert alert-danger"><button class="close" data-close="alert"></button><span>','</span></div>');?>
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9"><?php echo lang('common_email_address');?></label>
			<div class="input-icon">
				<i class="fa fa-envelope"></i>
				<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="<?php echo lang('common_email_address');?>" name="user_email_address"/>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9"><?php echo lang('common_password');?></label>
			<div class="input-icon">
				<i class="fa fa-lock"></i>
				<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="<?php echo lang('common_password');?>" name="user_password"/>
			</div>
		</div>
		<div class="form-actions">
			<label class="checkbox">
			</label>
			<button type="submit" class="btn green-haze pull-right">
			<?php echo lang('common_login');?> <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>
	</form>
	<!-- END LOGIN FORM -->
</div>
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->
<div class="copyright">
	 <?php echo lang('common_copyright');?>
</div>
<!-- END COPYRIGHT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo base_url('asset/plugins/respond.min.js');?>"></script>
<script src="<?php echo base_url('asset/plugins/excanvas.min.js');?>"></script> 
<![endif]-->
<script src="<?php echo base_url('asset/plugins/jquery.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('asset/plugins/jquery-migrate.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('asset/plugins/bootstrap/js/bootstrap.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('asset/plugins/jquery.blockui.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('asset/plugins/uniform/jquery.uniform.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('asset/plugins/jquery.cokie.min.js');?>" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url('asset/plugins/jquery-validation/js/jquery.validate.min.js');?>" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url('asset/plugins/select2/select2.min.js');?>"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url('asset/scripts/metronic.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('asset/scripts/layout.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('asset/scripts/demo.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('asset/scripts/login.js');?>" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
var emsLoginErrorEmptyEmailAddress = "<?php echo lang('common_login_error_empty_email_address');?>";
var emsLoginErrorEmptyPassword = "<?php echo lang('common_login_error_empty_password');?>"; 
var emsLoginErrorInvalidEmailAddress = "<?php echo lang('common_login_error_invalid_email_address');?>"; 
jQuery(document).ready(function() {
  Metronic.init(); // init metronic core components
  Layout.init(); // init current layout
  Login.init();
  Demo.init();
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>